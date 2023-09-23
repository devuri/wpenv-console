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
        if ( ! isset( $_ENV[ $name ] ) ) {
            return $default;
        }

        if ( is_numeric( $_ENV[ $name ] ) && \intval( $_ENV[ $name ] ) ) {
            return (int) $_ENV[ $name ];
        }

        if ( \in_array( $_ENV[ $name ], [ 'True', 'true', 'TRUE' ], true ) ) {
            return true;
        }
        if ( \in_array( $_ENV[ $name ], [ 'False', 'false', 'FALSE' ], true ) ) {
            return false;
        }
        if ( \in_array( $_ENV[ $name ], [ 'Null', 'null', 'NULL' ], true ) ) {
            return '';
        }

        if ( $strtolower ) {
            return strtolower( $_ENV[ $name ] );
        }

        return $_ENV[ $name ];
    }
}// end if
