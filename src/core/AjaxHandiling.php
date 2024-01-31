<?php 


namespace Mvc\Portfolio\core;
use ReflectionMethod;

    class AjaxHandiling
    {
        public function __construct()
        {
            if(isset($_POST['controller']) && $_POST['controller'] == 'AjaxControl' )
            {
                $controller = "Mvc\\Portfolio\\controllers\\".$_POST['controller'];
                $method = $_POST['method'];
                $controller = new $controller;
                if(method_exists($controller,$method))
                {
                    $reflection = new ReflectionMethod($controller, $method);
                    if ($reflection->isPublic()) {
                        $methodparam = $reflection->getNumberOfParameters();
                        $paramslen = count($_POST['params']);
                        if($methodparam == $paramslen){
                            call_user_func_array([$controller,$method],$_POST['params']);
                        }else{
                            die;
                        }
                    }
                }else{
                    die;
                }
            }
        }
    }