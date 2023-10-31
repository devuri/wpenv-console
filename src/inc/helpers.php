<?php

if ( ! \function_exists( 'wpenv' ) ) {
    /**
     * Get the value of an environment variable.
     *
     * @param string     $name       the environment variable name.
     * @param null|mixed $default
     * @param bool       $strtolower
     *
     * @return mixed
     */
    function wpenv( string $name, $default = null, bool $strtolower = false )
    {
        if ( isset( $_ENV[ $name ] ) ) {
            $env_value = $_ENV[ $name ];
        } else {
            $env_value = null;
        }

        if ( \is_null( $env_value ) ) {
            return $default;
        }

        if ( is_numeric( $env_value ) && \intval( $_ENV[ $name ] ) ) {
            return (int) $env_value;
        }

        if ( \in_array( $env_value, [ 'True', 'true', 'TRUE' ], true ) ) {
            return true;
        }
        if ( \in_array( $env_value, [ 'False', 'false', 'FALSE' ], true ) ) {
            return false;
        }
        if ( \in_array( $env_value, [ 'Null', 'null', 'NULL' ], true ) ) {
            return '';
        }

        if ( $strtolower ) {
            return strtolower( $env_value );
        }

        return $env_value;
    }
}// end if
