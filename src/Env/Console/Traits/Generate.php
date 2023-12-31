<?php

namespace Urisoft\Env\Console\Traits;

use Devuri\UUIDGenerator\UUIDGenerator;
use Exception;
use Urisoft\PasswordGenerator;

trait Generate
{
    public static function uuid(): string
    {
        return ( new UUIDGenerator() )->generateUUID();
    }

    /**
     * Generate a random four-letter word.
     *
     * @return string The generated four-letter word.
     */
    public function four_letter_word(): string
    {
        $consonants = $this->get_consonants();
        $vowels     = $this->get_vowels();
        $word       = '';

        for ( $j = 0; $j < 4; $j++ ) {
            if ( 0 === $j % 2 ) {
                $word .= $consonants[ array_rand( $consonants ) ];
            } else {
                $word .= $vowels[ array_rand( $vowels ) ];
            }
        }

        return $word;
    }

    /**
     * Generates a random port number within a specified range.
     *
     * This function generates a random port number using the mt_rand function.
     * It accepts two optional parameters which define the minimum and maximum
     * range for the random number. If the minimum value is greater than the maximum,
     * the function swaps them to ensure the minimum is always less than the maximum.
     *
     * @since 1.0.0
     *
     * @param int $min Optional. The minimum value in the range. Default is 10010.
     * @param int $max Optional. The maximum value in the range. Default is 10900.
     *
     * @return int Returns a random port number within the specified range.
     *
     * @example Usage
     *
     * $randomPort1 = generateRandomPort(); // Default range
     * $randomPort2 = generateRandomPort(10000, 10100); // Custom range
     *
     * echo "Random Port Number (Default Range): " . $randomPort1 . "\n";
     * echo "Random Port Number (Custom Range): " . $randomPort2;
     */
    public function generate_random_port( $min = 5000, $max = 5100 )
    {
        if ( $min > $max ) {
            // Swap the values to ensure $min is always less than $max
            list($min, $max) = [ $max, $min ];
        }

        return mt_rand( $min, $max );
    }

    public function create_uuid_key_file()
    {
        $filename = 'env-' . self::uuid();

        $this->filesystem->copy(
            __DIR__ . '/sample-key.pub',
            $this->root_dir_path . '/pubkey/' . $filename . '.pub'
        );

        return $filename;
    }

    /**
     * Generates a unique filename with optional prefix and hashing.
     *
     * @param string       $ext   The file extension.
     * @param null|string  $name  Optional. The prefix for the filename. Default is null.
     * @param false|string $hasit Optional. The hashing algorithm to use. Default is 'sha256'.
     *
     * @return string The unique filename generated.
     */
    public static function unique_filename( string $ext, ?string $name = null, $hasit = 'sha256' ): string
    {
        $prefix   = ( $name ) ? $name . '-' : null;
        $filename = $prefix . self::uuid();
        $datetime = mb_strtolower( gmdate( 'Y-M-d_' ) . time() );

        if ( $hasit ) {
            return $prefix . $datetime . hash( $hasit, $filename ) . $ext;
        }

        return $filename . '-' . $datetime . '-' . self::rand_str() . $ext;
    }

    /**
     * Generates a unique identifier within a given range of values using
     * PHP's built-in random_int function.
     *
     * @param int $min The minimum value for the identifier. Defaults to 100000.
     * @param int $max The maximum value for the identifier. Defaults to 900000.
     *
     * @throws Exception
     *
     * @see https://www.php.net/manual/en/function.random-int.php
     *
     * @return int A randomly generated integer between the values specified.
     *
     * @psalm-return int<min, max>
     */
    public static function random_id( int $min = 100000, int $max = 900000 ): int
    {
        return random_int( $min, $max );
    }

    /**
     * Generates a secure token of the specified length.
     *
     * This static method generates a cryptographically secure token of the specified length
     * in bytes using the random_bytes function. The generated key is then converted to a hexadecimal string
     * using bin2hex to ensure it is suitable for use in various security-related scenarios.
     *
     * @param int $bytes The length of the token to generate, in bytes.
     *
     * @return string The cryptographically secure token as a hexadecimal string.
     */
    public static function secure_token( int $bytes = 32 ): string
    {
        return bin2hex( random_bytes( $bytes ) );
    }

    /**
     * Generate a random alphanumeric alphanum_str of a specified length, starting with a letter.
     *
     * @param int $length The length of the alphanum_str to generate.
     *
     * @return string The generated string.
     */
    protected static function rand_str( int $length = 8 ): string
    {
        return PasswordGenerator::generatePassword( $length, false );
    }

    protected static function htpasswd( string $username, $password, $salted = null ): string
    {
        if ( ! $salted ) {
            $salt = self::rand_str( 16 );
        } else {
            $salt = $salted;
        }

        $salted_password = '$apr1$' . $salt . '$' . md5( $salt . $password . $salt );

        return $username . ':' . $salted_password . ':' . $salt;
    }

    /**
     * @param mixed $password
     *
     * @throws Exception
     */
    protected static function bcr_htpasswd( string $username, $password ): string
    {
        // Determine the number of hashing rounds (between 4 and 31)
        $cost = 10;

        // Generate a random salt using bcrypt's built-in function
        $salt = sprintf( '$2y$%02d$%s', $cost, substr( strtr( base64_encode( random_bytes( 16 ) ), '+', '.' ), 0, 22 ) );

        return $username . ':' . crypt( $password, $salt );
    }

    /**
     * Get the website name from a domain.
     *
     * Example:
     * ```php
     * $domain = 'http://staging.mycoolwebsite.io';
     * $websiteName = get_domain($domain);
     * echo $websiteName;  // Output: staging-mycoolwebsite-io
     * ```
     *
     * @param string $domain The domain URL.
     *
     * @return string The extracted website name.
     */
    protected function get_domain( string $domain ): ?string
    {
        if ( ! $domain ) {
            return null;
        }
        $domain      = preg_replace( '/^https?:\/\//', '', $domain );
        $domain      = preg_replace( '/\/.*$/', '', $domain );
        $segments    = explode( '.', $domain );
        $numSegments = \count( $segments );
        if ( $numSegments >= 2 ) {
            if ( $numSegments > 2 ) {
                $subdomain   = implode( '-', \array_slice( $segments, 0, $numSegments - 2 ) );
                $websiteName = $segments[ $numSegments - 2 ] . '-' . $segments[ $numSegments - 1 ];

                return $subdomain . '-' . $websiteName;
            }

            return $segments[ $numSegments - 2 ] . '-' . $segments[ $numSegments - 1 ];
        }

        return $domain;
    }

    /**
     * Get the date.
     *
     * @param string $format
     * @param bool   $lowercase
     *
     * @return string
     */
    protected static function getdate( string $format, bool $lowercase = true ): string
    {
        if ( true === $lowercase ) {
            return mb_strtolower( gmdate( $format ) );
        }

        return gmdate( $format );
    }

    /**
     * Get the consonants array.
     *
     * @return string[]
     *
     * @psalm-return list{'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z'}
     */
    private function get_consonants(): array
    {
        return [ 'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm', 'n', 'p', 'q', 'r', 's', 't', 'v', 'w', 'x', 'y', 'z' ];
    }

    /**
     * Get the vowels array.
     *
     * @return string[]
     *
     * @psalm-return list{'a', 'e', 'i', 'o', 'u'}
     */
    private function get_vowels(): array
    {
        return [ 'a', 'e', 'i', 'o', 'u' ];
    }
}
