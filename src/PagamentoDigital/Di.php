<?php

namespace PagamentoDigital;

/*
 * Not real di
 * apenas pagamento_digital.di
 */
class Di {

    /**
     * Retrieve a class instance based on class name
     *
     * Any parameters provided will be used as constructor arguments. If any
     * given parameter is a DependencyReference object, it will be fetched
     * from the container so that the instance may be injected.
     *
     * @param string $class
     * @param array $params     
     * @return object
     */
    public function __invoke($class, $callParameters = array()) {
//        $class = strtr($class,'.',' ');
//        $class = ucwords($class);
//        $class = strtr($class,' ','\\');
//        $class = strtr($class,'_',' ');
//        $class = ucwords($class);
//        $class = str_replace(' ','',$class);        
//        $class = '\\' . ltrim($class,'\\');
        
        // Hack to avoid Reflection in most common use cases
        switch (count($callParameters)) {
            case 0:
                return new $class();
            case 1:
                return new $class($callParameters[0]);
            case 2:
                return new $class($callParameters[0], $callParameters[1]);
            case 3:
                return new $class($callParameters[0], $callParameters[1], $callParameters[2]);
            default:
                $r = new \ReflectionClass($class);
                return $r->newInstanceArgs($callParameters);
        }
    }

}

