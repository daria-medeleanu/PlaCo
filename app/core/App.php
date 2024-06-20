<?php 

class App 
{
    protected $controller;
    protected $method = 'render';
    protected $parametri = [];
    public function __construct()
    {
        $url = $this->parseazaURL();
        if(file_exists('../app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            unset($url[0]);
        } else {
            echo "No such file " . $url[0];
            $uri = 'http://localhost/placo/PlaCo/public/home';
            header('Location: ', $uri);
            exit;
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if(isset($url[1])){
            if(method_exists($this->controller, $url[1])){
                $this->method = $url[1];
                unset($url[1]);
            }
        }
        $this->parametri = $url ? array_values($url) : [];
        call_user_func_array([$this->controller, $this->method], $this->parametri);
    }

    public function parseazaURL()
    {
        if(isset($_GET['url'])){
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}