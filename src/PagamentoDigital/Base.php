<?php

namespace PagamentoDigital;
use \InvalidArgumentException;
class Base {
    const GATEWAY_URL = "https://www.pagamentodigital.com.br/checkout/pay/";

    /**
     *
     * @var PagamentoDigital\Di 
     */
    protected $_di = null;
    protected static $_factoryInstances = array();
    protected  $_config = array();
    /**
     *
     * @param type $alias
     * @param type $options
     * @return Base 
     */
    public static function getInstance() {
        #$alias = $alias ?: 'default';        
        $alias = 'default';
        return self::$_factoryInstances[$alias] =
                self::$_factoryInstances[$alias] ? : new static();
        
    }

    private function __construct($options = array()) {
        $this->setOptions($options);
    }
    public function __clone(){
        throw \Exception('non clone');
    }
    
    public function setConfig($config){        
        $this->_config = $config;
    }
    public function getConfig($key = null ){
        return null !== $key ? $this->_config[$key] : $this->_config;
    }

    public function setOptions(array $options) {
        if (!empty($options['di'])) {
            $this->setDi($options['di']);
        } else {
            $this->_di = $this->_di ?: new Di();
        }        
        return $this;
    }

    /**
     *
     * @param PagamentoDigital\Di|callable $di
     * @return PagamentoDigital 
     */
    public function setDi($di) {
        if (!is_callable($di)) {
            throw new InvalidArgumentException('Not Callable');
        }
        $this->_di = $di;
        return $this;
    }

    public function getDi() {
        return $this->_di;
    }

    public function factory($name, $params = array()){
        return call_user_func_array($this->getDi(), array($name, $params));
    }

}

