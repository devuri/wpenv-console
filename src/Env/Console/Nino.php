<?php

namespace Urisoft\Env\Console;

use Exception;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Urisoft\Filesystem;

/**
 * Nino.
 *
 * Italian, "Nino" is a diminutive of the name Giovanni, which means "God is gracious".
 * Spanish, "Niño" means "boy" or "child".
 * Georgian, "Nino" is a female name that means "granddaughter".
 * Japanese, "Nino" is a surname that means "two fields" or "two wilds".
 * Swahili, "Nino" means "we are" or "we exist".
 */
class Nino
{
    protected $root_dir;
    protected $nino;

    /**
     * New Application command.
     */
    public function __construct( string $root_dir )
    {
        $this->nino     = new Application( 'Nino Cli', '0.1.3' );
        $this->root_dir = $root_dir;

        // cli only.
        if ( PHP_SAPI !== 'cli' ) {
            exit( 'please run from command line only' );
        }
    }

    /**
     * @throws Exception
     */
    public function load(): void
    {
        $this->add_command( new ServeCommand( $this->root_dir, new Filesystem() ) );
        $this->add_command( new Installer( $this->root_dir, new Filesystem() ) );
        $this->add_command( new LoginCommand( $this->root_dir, new Filesystem() ) );
        $this->add_command( new SetupCommand( $this->root_dir, new Filesystem() ) );
        $this->add_command( new BackupCommand( $this->root_dir, new Filesystem() ) );
        $this->add_command( new InstallPackage() );
        $this->add_command( new CreateHtpasswd( $this->root_dir, new Filesystem() ) );
        $this->add_command( new DatabaseBackup( $this->root_dir, new Filesystem() ) );
        $this->add_command( new GenerateComposer( $this->root_dir, new Filesystem() ) );
        $this->add_command( new CertCommand() );
        $this->add_command( new MakeCommand( $this->root_dir, new Filesystem() ) );
        $this->add_command( new ConfigCommand( $this->root_dir, new Filesystem() ) );

        try {
            $this->nino->run();
        } catch ( Exception $e ) {
            exit( $e->getMessage() );
        }
    }

    /**
     * Add new Application command.
     *
     * @param Command $command the command
     */
    protected function add_command( Command $command ): void
    {
        $this->nino->add( $command );
        $this->nino->setDefaultCommand( $command->getName() );
    }
}
