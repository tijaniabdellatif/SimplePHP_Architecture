<?php


namespace Framework;

/**
 * Class ManagerRenderer : manage the rendering of a view
 * based on a router call
 * @namespace  Framework
 */
class ManagerRenderer
{
    /**
     * Default Namespace
     */
    const DEFAULT_NAMESPACE = '__MAIN';
    /**
     * @var array  of paths
     */
     private $allPaths = [];


    /**
     * globally accessible variables
     * @var array
     */
     private $globals = [];

    /**
     * @param string $namespace
     * @param string|null $path
     */
    public function addPath(string $namespace,?string $path = null):void{

        if(is_null($path))
        {
            $this->allPaths[self::DEFAULT_NAMESPACE]=$namespace;
        }
        else{
            $this->allPaths[$namespace] = $path;
        }


    }

    /**
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view,array $params = []) : string{
       if($this->hasNamespace($view))
       {
             $path = $this->replaceNamespace($view).'.php';

       }else{
           $path = $this->allPaths[self::DEFAULT_NAMESPACE].'/'.$view.'.php';
       }

        ob_start();
        $renderer = $this;
        extract($this->globals);
        extract($params);
        require($path);
        return  ob_get_clean();
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addGlobal(string $key,$value):void
    {
       $this->globals[$key] = $value;
    }

    /**
     * @param string $view
     * @return string
     */
    private function hasNamespace(string $view):string{

        return $view[0] === '@';

    }

    /**
     * @param string $view
     * @return false|string
     */
    private function getNamespace(string $view){
            return substr($view,1,strpos($view,'/')-1);
    }

    /**
     * @param string $view
     * @return string
     */
    private  function replaceNamespace(string $view):string{
         $namespace = $this->getNamespace($view);
         return str_replace('@'.$namespace,$this->allPaths[$namespace],$view);
    }

}