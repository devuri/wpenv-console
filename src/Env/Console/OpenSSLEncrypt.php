<?php

namespace Urisoft\Env\Console;

use InvalidArgumentException;
use RuntimeException;

class OpenSSLEncrypt
{
    private string $encryptionKey;
    private string $cipherAlgorithm;
    private array $allowedCiphers;

    /**
     * Constructor for OpenSSL_Encryptor.
     *
     * @param string $key    The encryption key.
     * @param string $cipher The cipher algorithm.
     */
    public function __construct( ?string $key = null, string $cipher = 'AES-128-CBC' )
    {
        $this->encryptionKey  = $key ?? $this->generateSecureKey();
        $this->allowedCiphers = openssl_get_cipher_methods();
        $this->setCipherAlgorithm( $cipher );
    }

    /**
     * Encrypts the given data.
     *
     * @param string $data         The data to encrypt.
     * @param string $outputFormat The output format (base64, hex, binary).
     *
     * @return string The encrypted data.
     */
    public function encrypt( string $data, string $outputFormat = 'base64' ): string
    {
        $ivLength      = openssl_cipher_iv_length( $this->cipherAlgorithm );
        $iv            = openssl_random_pseudo_bytes( $ivLength );
        $encryptedData = openssl_encrypt( $data, $this->cipherAlgorithm, $this->encryptionKey, OPENSSL_RAW_DATA, $iv );

        if ( false === $encryptedData ) {
            throw new RuntimeException( 'Encryption failed.' );
        }

        $encryptedData = $iv . $encryptedData;

        return $this->convertOutput( $encryptedData, $outputFormat );
    }

    /**
     * Decrypts the given data.
     *
     * @param string $data        The data to decrypt.
     * @param string $inputFormat The input format (base64, hex, binary).
     *
     * @return string The decrypted data.
     */
    public function decrypt( string $data, string $inputFormat = 'base64' ): string
    {
        $data     = $this->convertInput( $data, $inputFormat );
        $ivLength = openssl_cipher_iv_length( $this->cipherAlgorithm );
        $iv       = substr( $data, 0, $ivLength );
        $data     = substr( $data, $ivLength );

        $decryptedData = openssl_decrypt( $data, $this->cipherAlgorithm, $this->encryptionKey, OPENSSL_RAW_DATA, $iv );

        if ( false === $decryptedData ) {
            throw new RuntimeException( 'Decryption failed.' );
        }

        return $decryptedData;
    }

    /**
     * Sets the cipher algorithm.
     *
     * @param string $cipher The cipher algorithm.
     *
     * @throws InvalidArgumentException If an unsupported cipher is provided.
     *
     * @return void
     */
    private function setCipherAlgorithm( string $cipher ): void
    {
        if ( ! \in_array( $cipher, $this->allowedCiphers, true ) ) {
            throw new InvalidArgumentException( 'Unsupported cipher algorithm.' );
        }
        $this->cipherAlgorithm = $cipher;
    }

    /**
     * Generates a secure random key.
     *
     * @return string The generated key.
     */
    private function generateSecureKey(): string
    {
        $keyLength = openssl_cipher_iv_length( $this->cipherAlgorithm );

        return openssl_random_pseudo_bytes( $keyLength );
    }

    private function convertOutput( $data, $format )
    {
        switch ( $format ) {
            case 'base64':
                return base64_encode( $data );
            case 'hex':
                return bin2hex( $data );
            default:
                return $data;
        }
    }

    private function convertInput( $data, $format )
    {
        switch ( $format ) {
            case 'base64':
                return base64_decode( $data, true );
            case 'hex':
                return hex2bin( $data );
            default:
                return $data;
        }
    }
}
