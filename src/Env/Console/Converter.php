<?php

namespace Urisoft\Env\Console;

use RuntimeException;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Urisoft\Filesystem;

class Converter
{
    protected $root_dir_path = null;
    protected $filesystem;

    public function __construct( string $root_dir_path, Filesystem $filesystem )
    {
        $this->root_dir_path = $root_dir_path;
        $this->filesystem    = $filesystem;
        $this->convert_files = [
            'convert' => $root_dir_path . '/convert/convert.json',
            'revert'  => $root_dir_path . '/convert/revert.json',
        ];
    }

    public function convertToFramework( string $configPath ): void
    {
        $configFilePath = $this->getConfigFile( 'convert' );

        if ( ! $this->isValidJsonFile( $configFilePath ) ) {
            throw new RuntimeException( 'The convert config file is not a valid JSON.' );
        }

        $config = $this->loadConfig( $configFilePath );

        // Create directories
        foreach ( $config['create'] as $dir ) {
            $this->createDirectory( $dir['directory'] );
        }

        // Move files and directories
        foreach ( $config['migrate'] as $migration ) {
            $this->move( $migration['from'], $migration['to'] );
        }

        // Handle specific file operations
        foreach ( $config['files'] as $file ) {
            // Custom logic for file transformation and copying
            $this->transformAndCopyFile( $file['name'], $file['source'], $file['transformation'] );
        }

        // Cleanup
        foreach ( $config['cleanup'] as $path ) {
            $this->remove( $path );
        }
    }

    public function revertToStandard( string $configPath ): void
    {
        $configFilePath = $this->getConfigFile( 'revert' );

        if ( ! $this->isValidJsonFile( $configFilePath ) ) {
            throw new RuntimeException( 'The revert config file is not a valid JSON.' );
        }

        $config = $this->loadConfig( $configFilePath );

        // Similar logic to convertToFramework, adjusted for reverting
    }

    protected function getConfigFile( string $key ): string
    {
        return $this->convert_files[ $key ];
    }

    private function createDirectory( string $dir ): void
    {
        try {
            $this->filesystem->mkdir( $dir );
        } catch ( IOExceptionInterface $exception ) {
            echo 'An error occurred while creating your directory at ' . $exception->getPath();
        }
    }

    private function move( string $from, string $to ): void
    {
        try {
            $this->filesystem->rename( $from, $to, true );
        } catch ( IOExceptionInterface $exception ) {
            echo "An error occurred while moving files from $from to $to";
        }
    }

    private function remove( string $path ): void
    {
        try {
            $this->filesystem->remove( $path );
        } catch ( IOExceptionInterface $exception ) {
            echo "An error occurred while removing $path";
        }
    }

    private function transformAndCopyFile( $name, $source, $transformation ): void
    {
        // Implement your logic for file transformation and copying here
    }

    private function loadConfig( string $path ): array
    {
        $config = json_decode( file_get_contents( $path ), true );
        if ( JSON_ERROR_NONE !== json_last_error() ) {
            throw new RuntimeException( 'Invalid JSON configuration: ' . json_last_error_msg() );
        }

        return $config;
    }

    private function isValidJsonFile( string $path ): bool
    {
        if ( ! file_exists( $path ) ) {
            return false;
        }

        $content = file_get_contents( $path );

        json_decode( $content );

        if ( JSON_ERROR_NONE === json_last_error() ) {
            return true;
        }

        return false;
    }
}
