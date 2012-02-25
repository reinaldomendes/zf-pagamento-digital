<?php

namespace PagamentoDigital;

use \InvalidArgumentException;

class Base {

    /**
     *
     * @var PagamentoDigital\Di 
     */
    protected $_di = null;
    protected static $_factoryInstances = array();
    protected $_config = array();

    public static function getInstance($alias='default', $options = array()) {
        $return = self::$_factoryInstances[$alias] =
                self::$_factoryInstances[$alias] ? : new self($options);
        return $options ? $return->setOptions($options) : $return;
    }

    public function __construct($options = array()) {
        $this->setOptions($options);
    }

    public function setOptions(array $options) {
        if (!empty($options['di'])) {
            $this->setDi($options['di']);
        } else {
            $this->_di = $this->_di ?: new Di();
        }
        if (!is_array($options['config'])) {
            throw new InvalidArgumentException('Config não foi informado');
        }
        $this->_config = $options['config'];
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

    public function factory($name, $params = array()) {
        return call_user_func_array($this->getDi(), array($name, $params));
    }

}

