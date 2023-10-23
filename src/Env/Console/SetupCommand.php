<?php

namespace Urisoft\Env\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Urisoft\Env\Console\Traits\Env;
use Urisoft\Env\Console\Traits\Generate;

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

        return Command::SUCCESS;
    }
}
