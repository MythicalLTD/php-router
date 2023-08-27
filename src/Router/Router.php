<?php 
namespace Router {
    /**
     * The main router class
     *
     * @package Router
     */
    class Router
    {
        // Base URL for the router
        private $base_path;
    
        // Current relative URL
        private $path;
    
        // Array to hold registered Route instances
        public $routes = [];
    
        /**
         * Constructor
         *
         * @param string $base_path The base URL of the router
         */
        public function __construct($base_path = '')
        {
            $this->base_path = $base_path;
        
            // Extract and set the relative path from the URL
            $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
            $path = substr($path, strlen($base_path));
            $this->path = $path;
        }
    
        // ... (Methods for adding routes)
    
        /**
         * Test all routes until any of them matches
         *
         * @throws RouteNotFoundException if no registered route matches the current path
         */
        public function route()
        {
            foreach ($this->routes as $route) {
                if ($route->matches($this->path)) {
                    return $route->exec();
                }
            }
        
            throw new RouteNotFoundException("No routes matching {$this->path}");
        }
    
        /**
         * Get the URL for a specific path
         *
         * @param string|null $path The path for the URL
         * @return string The generated URL
         */
        public function url($path = null)
        {
            if ($path === null) {
                $path = $this->path;
            }
        
            return $this->base_path . $path;
        }
    
        /**
         * Redirect from one URL to another
         *
         * @param string $from_path The source URL to match against
         * @param string $to_path The target URL to redirect to
         * @param int $code The HTTP status code for the redirect
         */
        public function redirect($from_path, $to_path, $code = 302)
        {
            $this->all($from_path, function () use ($to_path, $code) {
                http_response_code($code);
                header("Location: {$to_path}");
            });
        }
    }
}
?>