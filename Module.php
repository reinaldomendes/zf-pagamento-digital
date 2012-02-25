<?php

namespace PagamentoDigital;

use Zend\Module\Manager,
    Zend\Config\Config,
    Zend\EventManager\StaticEventManager,
    Zend\Loader\AutoloaderFactory;

class Module {

    /**
     *
     * @var \Zend\Module\Manager
     */
    protected $_moduleManager;
    protected $_devConfig;

    public function init(Manager $moduleManager) {
        $this->_moduleManager = $moduleManager;
        $this->initAutoloader($moduleManager->getOptions()->getApplicationEnv());
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'bootstrap'), 1000);
    }

    public function initAutoloader($env) {
        AutoloaderFactory::factory(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        ));
    }

    public function getConfig() {
        return new Config(include __DIR__ . '/configs/module.config.php');
    }

    public function bootstrap($e) {
        $env = $this->_moduleManager->getOptions()->getApplicationEnv();
        $config = $this->_moduleManager->getMergedConfig();
        $this->_devConfig = $config->pagamento_digital->{$env};
        //bootstrap base pagamento_digital class
        Base::getInstance(null,$this->_devConfig->toArray());
        
        $events = StaticEventManager::getInstance();
        if ($this->_devConfig->developer) {
            
            $events->attach('Zend\Mvc\Application', 'route', array($this, 'routeDevelopment'), 1000);
        }
    }

    public function routeDevelopment($e) {
        
        if (!$this->_devConfig->developer) {
            return;
        }
        
        $request= $e->getRequest();
        if (!method_exists($request, 'uri')) {
            return;
        }
        
        $router = $e->getRouter();
        if (method_exists($router, 'getBaseUrl')) {
            $baseUrlLength = strlen($router->getBaseUrl() ? : '');
        } else {
            $baseUrlLength = 0;
        }        
        
        $path = substr($request->uri()->getPath(), $baseUrlLength);        
        $path = '/' . trim($path, '/') . '/';
        $gateway = $this->_devConfig->gateway;
        $gateway = '/' . trim($gateway, '/') . '/';
        
        Base::getInstance()->factory('PagamentoDigital\Order');
        if ($path == $gateway) {            
            $logger = Factory::getInstance()->factory('PagamentoDigital\Developer');                    
            $logger->gateway();
        }
    }

}
