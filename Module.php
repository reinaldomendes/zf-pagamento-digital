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
        $di = $e->getParam('application')->getLocator();
        $di = function($name, $params = array())use($di) {
                    return $di->get($name, $params);
                };

        Base::getInstance()->setOptions(array('di' => $di))
                ->setConfig($this->_devConfig->toArray());
        $this->_devConfig->toArray();
//        if ($this->_devConfig->developer) {
//            $events = StaticEventManager::getInstance();
//            $events->attach('Zend\Mvc\Application', 'route', array($this, 'routeDevelopment'), 1000);
//        }
    }

    public function routeDevelopment($e) {
        if (!$this->_devConfig->developer) {
            return;
        }

        $request = $e->getRequest();
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
        $gateway = $this->_devConfig->gateway_url;
        $gateway = '/' . trim($gateway, '/') . '/';


        if ($path == $gateway) {
            $developer = Base::getInstance()->factory('PagamentoDigital\Developer');
            $developer->gateway();
        }
    }

}
