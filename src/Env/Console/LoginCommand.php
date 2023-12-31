<?php

namespace Urisoft\Env\Console;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Urisoft\Env\Console\Traits\Env;
use Urisoft\Env\Console\Traits\Generate;
use Urisoft\Filesystem;

class LoginCommand extends Command
{
    use Env;
    use Generate;

    protected static $defaultName = 'wp:login';

    // wp:login -u admin
    public function __construct( string $root_dir_path, Filesystem $filesystem )
    {
        parent::__construct();
        $this->filesystem    = $filesystem;
        $this->root_dir_path = $root_dir_path;
    }

    protected function configure(): void
    {
        $this->setDescription( 'Generate an auto-login URL for a user.' )
            ->addOption( 'user', 'u', InputOption::VALUE_REQUIRED, 'The admin username.', 'admin' )
            ->setHelp( 'This command will generate an auto-login URL.' );
    }

    /**
     * @return int
     *
     * @psalm-return 0|1
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
        $io = new SymfonyStyle( $input, $output );

        try {
            $this->load_dotenv( $this->root_dir_path );
        } catch ( Exception $e ) {
            $io->warning( $e->getMessage() );

            return Command::FAILURE;
        }

        $username = $input->getOption( 'user' );

        $io->title( 'WordPress Auto-login Started...' );

        $autoLoginUrl = self::login( $username );

        if ( $autoLoginUrl ) {
            $io->newLine();
            $io->section( 'Auto-login URL:' );
            $io->writeln( $autoLoginUrl );
            $io->newLine();

            return Command::SUCCESS;
        }

        $io->warning( 'Auto-login failed.' );

        return Command::FAILURE;
    }

    /**
     * WordPress Quick Login.
     *
     * @return string
     */
    protected static function login( string $username ): string
    {
        $secretKey = wpenv( 'WPENV_AUTO_LOGIN_SECRET_KEY' );

        $service_data = [
            'token'    => urlencode( self::secure_token() ),
            'time'     => time(),
            'username' => urlencode( $username ),
            'site_id'  => self::random_id(),
        ];

        $http_query = http_build_query( $service_data, '', '&' );

        $signature = hash_hmac( 'sha256', $http_query, $secretKey );

        return wpenv( 'WP_HOME' ) . '?' . $http_query . '&sig=' . base64_encode( $signature );
    }
}
