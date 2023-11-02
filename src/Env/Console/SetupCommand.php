<?php

namespace Urisoft\Env\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Urisoft\EncryptionKey;
use Urisoft\Env\Console\Traits\Env;
use Urisoft\Env\Console\Traits\Generate;
use Urisoft\Filesystem;

class SetupCommand extends Command
{
    use Env;
    use Generate;

    protected static $defaultName = 'setup';

    public function __construct( string $root_dir_path, Filesystem $filesystem )
    {
        parent::__construct();
        $this->filesystem    = $filesystem;
        $this->root_dir_path = $root_dir_path;
        $this->files         = [
            'env'      => $root_dir_path . '/.env',
            'secret'   => $root_dir_path . '/.secret',
            'htaccess' => $root_dir_path . '/public/.htaccess',
            'robots'   => $root_dir_path . '/public/robots.txt',
        ];
    }

    protected function configure(): void
    {
        $this->setDescription( 'Creates .env file for new Application' );
    }

    /**
     * @return int
     */
    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        if ( ! $this->filesystem->exists( $this->files['env'] ) ) {
            $output->writeln( '<comment>.env file does not exist. we will create the file.</comment>' );
            $this->filesystem->dumpFile( $this->files['env'], $this->envFileContent() );
            $output->writeln( '<info>Remember to update .env with the application domain and remove example.com.</info>' );
        }

        if ( ! $this->filesystem->exists( $this->files['secret'] ) ) {
            $output->writeln( '<comment>.secret file does not exist. we will create .secret file.</comment>' );

            $secretkey = EncryptionKey::generate_key();

            $this->filesystem->dumpFile( $this->files['secret'], $secretkey );
        }

        return Command::SUCCESS;
    }

    protected function envFileContent(): string
    {
        $auto_login_secret = bin2hex( random_bytes( 32 ) );

        $app_tenant_secret = bin2hex( random_bytes( 32 ) );

        $salt = (object) $this->saltToArray();

        $home_url       = 'http://example.com';
        $site_url       = '${WP_HOME}/wp';
        $dbprefix       = strtolower( 'wp_' . self::rand_str( 8 ) . '_' );
        $app_public_key = self::uuid();

        return <<<END
		WP_HOME='$home_url'
		WP_SITEURL="$site_url"
		WP_ENVIRONMENT_TYPE='debug'
		SUDO_ADMIN='1'

		APP_TENANT_ID=null
		IS_MULTI_TENANT_APP=false
		APP_TENANT_SECRET='$app_tenant_secret'

		BASIC_AUTH_USER='admin'
		BASIC_AUTH_PASSWORD='demo'

		USE_APP_THEME=false
		BACKUP_PLUGINS=false

		DISABLE_WP_APPLICATION_PASSWORDS=true
		SEND_EMAIL_CHANGE_EMAIL=false

		# Premium
		SENDGRID_API_KEY=''
		ELEMENTOR_PRO_LICENSE=''
		AVADAKEY=''

		MEMORY_LIMIT='256M'
		MAX_MEMORY_LIMIT='256M'

		FORCE_SSL_ADMIN=false
		FORCE_SSL_LOGIN=false

		# s3backup
		ENABLE_S3_BACKUP=false
		S3ENCRYPTED_BACKUP=false
		S3_BACKUP_KEY=null
		S3_BACKUP_SECRET=null
		S3_BACKUP_BUCKET='wp-s3snaps'
		S3_BACKUP_REGION='us-west-1'
		S3_BACKUP_DIR=null
		DELETE_LOCAL_S3BACKUP=false

		DB_NAME=local
		DB_USER=root
		DB_PASSWORD=password
		DB_HOST=localhost
		DB_PREFIX=$dbprefix

		AUTH_KEY='$salt->AUTH_KEY'
		SECURE_AUTH_KEY='$salt->SECURE_AUTH_KEY'
		LOGGED_IN_KEY='$salt->LOGGED_IN_KEY'
		NONCE_KEY='$salt->NONCE_KEY'
		AUTH_SALT='$salt->AUTH_SALT'
		SECURE_AUTH_SALT='$salt->SECURE_AUTH_SALT'
		LOGGED_IN_SALT='$salt->LOGGED_IN_SALT'
		NONCE_SALT='$salt->NONCE_SALT'

		WPENV_AUTO_LOGIN_SECRET_KEY='$auto_login_secret'
		WEB_APP_PUBLIC_KEY=$app_public_key

		END;
    }
}
