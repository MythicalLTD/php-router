<?php 
namespace Router {
    /**
     * An exception class representing that a route hasn't been found.
     *
     * @package Router
     */
    class RouteNotFoundException extends \Exception
    {
        /**
         * Constructor.
         *
         * @param string $message Exception message
         * @param int $code Exception code
         * @param Exception|null $previous Previous exception, if any
         */
        public function __construct($message, $code = 0, Exception $previous = null)
        {
            parent::__construct($message, $code, $previous);
        }

        /**
         * Convert the exception to a string representation.
         *
         * @return string String representation of the exception
         */
        public function __toString()
        {
            return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
        }
    }
}
?>