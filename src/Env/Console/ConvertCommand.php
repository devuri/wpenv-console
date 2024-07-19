<?php

namespace Urisoft\Env\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Urisoft\Env\Console\Traits\Env;
use Urisoft\Env\Console\Traits\Generate;
use Urisoft\Filesystem;

class ConvertCommand extends Command
{
    use Env;
    use Generate;

    protected static $defaultName = 'wp:convert';
    private $converter;

    public function __construct( string $root_dir_path, Filesystem $filesystem )
    {
        parent::__construct();
        $this->filesystem    = $filesystem;
        $this->root_dir_path = $root_dir_path;
        $this->converter     = new Converter( $root_dir_path, $filesystem );
    }

    protected function configure(): void
    {
        // $this->setDescription( 'Create DB admin directory' )
        // ->addOption( '_dir', '-d', InputOption::VALUE_REQUIRED, 'The database admin directory.', self::uuid() );
    }

    /**
     * Create the dbadmin dir.
     *
     * make the dir in public/"$dbadmin"
     *
     * @return int
     *
     * @psalm-return 0|1
     */
    protected function execute( InputInterface $input, OutputInterface $output ): int
    {
        // $dbadmin = $input->getOption( '_dir' );
        //
        // return Command::SUCCESS;
    }
}
