<?php
namespace Router {
    class Route
 {
        // The regular expression to match the route path
        private string $expr;

        // The callback function to execute if the route matches
        private callable $callback;

        // Array to hold the matched parts from the regular expression
        private array $matches = [];

        // Allowed HTTP methods for this route
        private array $methods = [ 'GET', 'POST', 'HEAD', 'PUT', 'DELETE' ];

        /**
        * Constructor
        *
        * @param string $expr The regular expression to test against
        * @param callable $callback The callback function executed if the route matches
        * @param string|array|null $methods The methods allowed for this route
        */

        public function __construct( string $expr, callable $callback, $methods = null )
 {
            // Ensure the expression matches paths with or without a trailing slash
            $this->expr = '#^' . rtrim( $expr, '/' ) . '/?$#';
            $this->callback = $callback;

            // If specific methods are provided, update the allowed methods
            if ( $methods !== null ) {
                $this->methods = ( array )$methods;
            }
        }

        /**
        * Check if the route matches the given path and HTTP method
        *
        * @param string $path The path to match against
        * @return bool Returns true if the route matches, false otherwise
        */

        public function matches( string $path ): bool
 {
            // Check if the path matches the expression and if the request method is allowed
            return preg_match( $this->expr, $path, $this->matches )
            && in_array( $_SERVER[ 'REQUEST_METHOD' ], $this->methods, true );
        }

        /**
        * Execute the callback function with matched arguments
        *
        * @return mixed Result of the callback function execution
        */

        public function exec()
 {
            // Call the callback function with matched arguments ( excluding the first match )
            return call_user_func_array( $this->callback, array_slice( $this->matches, 1 ) );
        }
    }
}
?>