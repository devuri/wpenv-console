<?php

namespace Urisoft\Env\Console;

use Exception;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Urisoft\Encryption;
use Urisoft\Env\Console\Traits\Env;
use Urisoft\Env\Console\Traits\Generate;
use Urisoft\Filesystem;
use ZipArchive;

class BackupCommand extends Command
{
    use Env;
    use Generate;

    protected static $defaultName = 'backup';

    private $snapshot_dir;
    private $backup_file;
    private $backup_time;
    private $backup_dir;
    private $backup_zip;
    private $s3wp_dir;
    private $encrypter;
    private $encrypted_backup;
    private $s3uploader;
    private $backup_plugins;

    /**
     * BackupCommand constructor.
     *
     * php bin/console backup >/dev/null 2>&1 &
     *
     * @param string     $root_dir_path
     * @param Filesystem $filesystem
     */
    public function __construct( string $root_dir_path, Filesystem $filesystem )
    {
        $this->filesystem    = $filesystem;
        $this->root_dir_path = $root_dir_path;
        $this->snapshot_dir  = $this->root_dir_path . '/.snapshot/' . gmdate( 'Y' ) . '/' . gmdate( 'F' );

        // setup Encryption
        try {
            $this->encrypter = new Encryption( $this->root_dir_path, $this->filesystem );
        } catch ( InvalidArgumentException $e ) {
            $this->encrypter = null;
        }

        parent::__construct();
    }

    /**
     * Saves an array to the 'snap.json' file using the Symfony Filesystem component.
     *
     * @param array $data The array to be saved.
     *
     * @return bool True on success, false on failure.
     */
    public function save_snap_info( array $data ): bool
    {
        try {
            $this->filesystem->dumpFile( $this->root_dir_path . '/snap.json', json_encode( $data ) );

            return true;
        } catch ( Exception $e ) {
            return false;
        }
    }

    /**
     * Handles directory setups.
     *
     * @return void
     */
    protected function create_backup_dir(): void
    {
        // Create snapshot directory.
        if ( ! $this->filesystem->exists( $this->snapshot_dir ) ) {
            $this->filesystem->mkdir( $this->snapshot_dir );
        }

        // Create backup_dir directory.
        if ( ! $this->filesystem->exists( $this->backup_dir ) ) {
            $this->filesystem->mkdir( $this->backup_dir );
        }
    }

    protected function configure(): void
    {
        $this->setDescription( 'Backup the WordPress web application' );
    }

    /**
     * @return int
     *
     * @psalm-return 0|1
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $this->setup_backup_env();

        // backup db
        $dbbackup = $this->create_sql_dump();

        // create_backup_dir()
        $this->create_backup_dir();

        if ( 0 !== $dbbackup['code'] ) {
            return Command::FAILURE;
        }

        $this->save_snap_info(
            array_merge(
                $dbbackup,
                [
                    'site-url'     => wpenv( 'WP_HOME' ),
                    'table-prefix' => wpenv( 'DB_PREFIX' ),
                    'snap'         => $this->backup_file,
                    'date'         => gmdate( 'd-m-Y' ),
                    'timestamp'    => $this->backup_time,
                    's3_dir'       => $this->s3wp_dir,
                ]
            )
        );

        if ( ! class_exists( 'ZipArchive' ) ) {
            throw new Exception( 'This command requires the Zip PHP extension. Install it and try again.' );
        }

        // Create a ZIP archive of the site directory.
        $zip = new ZipArchive();
        $zip->open( $this->backup_zip, ZipArchive::CREATE | ZipArchive::OVERWRITE );
        $this->add_directory_zip( $this->root_dir_path, '', $zip );
        $zip->close();

        // save snap info.
        $this->filesystem->copy( $this->root_dir_path . '/snap.json', $this->backup_dir . '/snap.json' );

        // remove db directory.
        $this->filesystem->remove( $this->root_dir_path . '/.sqldb' );
        unlink( $this->root_dir_path . '/snap.json' );
        // $output->writeln( 'Backup snapshot created: ' . $this->backup_zip );

        if ( wpenv( 'S3ENCRYPTED_BACKUP' ) ) {
            $this->encrypter->encrypt_file(
                $this->backup_zip,
                $this->encrypted_backup
            );
        }

        // maybe upload to s3.
        if ( wpenv( 'ENABLE_S3_BACKUP' ) ) {
            $this->s3_upload_backup();
        }

        // if s3 is enabled we can delete local backups.
        if ( wpenv( 'ENABLE_S3_BACKUP' ) && wpenv( 'DELETE_LOCAL_S3BACKUP' ) ) {
            $this->filesystem->remove( $this->root_dir_path . '/.snapshot' );
        }

        return Command::SUCCESS;
    }

    protected function s3_upload_backup(): bool
    {
        if ( wpenv( 'S3ENCRYPTED_BACKUP' ) ) {
            return $this->s3uploader->uploadFile( $this->encrypted_backup, $this->wpbucket_dir() . $this->backup_file . '.encrypted' );
        }

        return $this->s3uploader->uploadFile( $this->backup_zip, $this->wpbucket_dir() . $this->backup_file );
    }


    private function setup_backup_env(): bool
    {
        try {
            $this->load_dotenv( $this->root_dir_path );
        } catch ( Exception $e ) {
            dump( $e->getMessage() );

            return false;
        }

        // usually the sitename or alphanum siteID.
        $this->s3wp_dir = wpenv( 'S3_BACKUP_DIR', $this->get_domain( wpenv( 'WP_HOME' ) ) );

        // backup directory.
        $this->backup_file = self::unique_filename( '.zip', $this->s3wp_dir . '_snap' );
        $this->backup_time = time();
        $this->backup_dir  = $this->snapshot_dir . '/' . self::getdate( 'd-F-Y' ) . '/' . $this->backup_time;

        // determines if we include plugins (true||false).
        $this->backup_plugins = wpenv( 'BACKUP_PLUGINS' );

        // zip filename
        $this->backup_zip = $this->backup_dir . '/' . $this->backup_file;

        // maybe encrypted backup.
        $this->encrypted_backup = $this->backup_zip . '.encrypted';

        // setup s3
        $this->s3uploader = new S3Uploader(
            wpenv( 'S3_BACKUP_KEY', '' ),
            wpenv( 'S3_BACKUP_SECRET', '' ),
            wpenv( 'S3_BACKUP_BUCKET', 'wp-s3snaps' ),
            // Specify the region where your S3 bucket is located
            wpenv( 'S3_BACKUP_REGION', 'us-west-1' ),
        );

        return true;
    }

    /**
     * The backup directory in s3 bucket.
     *
     * @param mixed $project
     *
     * @return null|string
     */
    private function wpbucket_dir( $project = 'prod' ): ?string
    {
        if ( ! $this->s3wp_dir ) {
            error_log( 's3 upload failed, wpenv value for S3_BACKUP_DIR or WP_HOME is not set' );

            return null;
        }

        return 'wp/' . $this->s3wp_dir . '/' . self::getdate( 'Y' ) . '/' . gmdate( 'F' ) . '/' . self::getdate( 'd-F-Y' ) . '/';
    }

    /**
     * Add directory and its files to a ZIP archive.
     *
     * @param string     $directory
     * @param string     $prefix
     * @param ZipArchive $zip
     */
    private function add_directory_zip( $directory, $prefix, $zip ): void
    {
        $handle = opendir( $directory );

        while ( false !== ( $file = readdir( $handle ) ) ) {
            if ( '.' !== $file && '..' !== $file ) {
                $path       = $directory . '/' . $file;
                $local_path = $prefix . '/' . $file;

                // Exclude directory
                if ( 'wp' === $file || 'vendor' === $file ) {
                    continue;
                }

                // Exclude plugins directory
                if ( 'plugins' === $file && ! $this->backup_plugins ) {
                    continue;
                }

                // Exclude snapshots directory
                if ( '.snapshot' === $file ) {
                    continue;
                }

                if ( is_dir( $path ) ) {
                    $this->add_directory_zip( $path, $local_path, $zip );
                } else {
                    $zip->addFile( $path, $local_path );
                }
            }// end if
        }// end while

        closedir( $handle );
    }


    /**
     * @return (null|int|mixed|string)[]
     *
     * @psalm-return array{db_name: mixed, db_user: mixed, sqlfile: string, code: int|null}
     */
    private function create_sql_dump(): array
    {
        $sqldb = [
            'db_name'     => wpenv( 'DB_NAME' ),
            'db_user'     => wpenv( 'DB_USER' ),
            'db_passowrd' => wpenv( 'DB_PASSWORD' ),
            'db_host'     => wpenv( 'DB_HOST' ),
            'db_prefix'   => wpenv( 'DB_PREFIX' ),
            'directory'   => $this->root_dir_path . '/.sqldb',
            'db_file'     => self::unique_filename( '.sql', wpenv( 'DB_NAME' ) . '-db' ),
        ];

        if ( ! $this->filesystem->exists( $sqldb['directory'] ) ) {
            $this->filesystem->mkdir( $sqldb['directory'] );
        }

        // Create a new process
        $process = Process::fromShellCommandline(
            sprintf(
                'mysqldump -u %s -p%s %s > %s/%s',
                $sqldb['db_user'],
                $sqldb['db_passowrd'],
                $sqldb['db_name'],
                $sqldb['directory'],
                $sqldb['db_file'],
            )
        );

        $process->setInput( null );

        // Run the process silently
        // https://symfony.com/doc/current/components/process.html#getting-real-time-process-output
        $process->run(
            function ( $type, $buffer ): void {
            }
        );

        return [
            'db_name' => $sqldb['db_name'],
            'db_user' => $sqldb['db_user'],
            'sqlfile' => $sqldb['db_file'],
            'code'    => $process->getExitCode(),
        ];
    }
}
