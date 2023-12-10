<?php

namespace Urisoft\Env\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;
use Urisoft\Env\Console\Traits\Env;
use Urisoft\Env\Console\Traits\Generate;
use Urisoft\Filesystem;

class DatabaseBackup extends Command
{
    use Env;
    use Generate;

    protected static $defaultName = 'db:backup';

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

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription( 'Backup WordPress database.' )
            ->setHelp( 'This command allows you to create a backup of the WordPress database.' );
    }

    protected function execute( InputInterface $input, OutputInterface $output ): ?int
    {
        $io = new SymfonyStyle( $input, $output );

        try {
            $this->load_dotenv( $this->root_dir_path );
        } catch ( Exception $e ) {
            $io->warning( $e->getMessage() );

            return Command::FAILURE;
        }

        $backup = [
            'db_name'     => wpenv( 'DB_NAME' ),
            'db_user'     => wpenv( 'DB_USER' ),
            'db_passowrd' => wpenv( 'DB_PASSWORD' ),
            'db_host'     => wpenv( 'DB_HOST' ),
            'db_prefix'   => wpenv( 'DB_PREFIX' ),
            'directory'   => $this->root_dir_path . '/storage/.sqldb',
            'db_file'     => self::unique_filename( '.sql', wpenv( 'DB_NAME' ) . '-db' ),
        ];

        if ( ! file_exists( $backup['directory'] ) ) {
            mkdir( $backup['directory'], 0777, true );
        }

        // Build the command to execute
        $command = sprintf(
            'mysqldump -u %s -p%s %s > %s/%s',
            $backup['db_user'],
            $backup['db_passowrd'],
            $backup['db_name'],
            $backup['directory'],
            $backup['db_file'],
        );

        // Create a new process
        $process = Process::fromShellCommandline( $command );

        $process->setInput( null );

        // Run the process silently
        $process->run(
            function ( $type, $buffer ): void {
                // Do nothing with the output
            }
        );

        if ( $process->isSuccessful() ) {
            $output->writeln( sprintf( 'Backup created successfully: %s/%s', $backup['directory'], $backup['db_file'] ) );
        } else {
            $output->writeln( 'Error creating backup.' );
        }

        return $process->getExitCode();
    }
}
