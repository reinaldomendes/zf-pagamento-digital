<?php

namespace PagamentoDigital\Controller;

use Zend\Mvc\Controller\ActionController,
    PagamentoDigital\Base,
    Zend\Mvc\Router\Exception\RuntimeException as RouteNotFound;
#new Zend\Mvc\Controller\Plugin\Redirect;
class DevelopmentController extends ActionController {

    public function indexAction() {
        if ($this->request->isPost()) {
            $developer = Base::getInstance()->factory('PagamentoDigital\Developer');
            $params = $developer->gateway($this->request->post()->toArray());
            $url = Base::getInstance()->getConfig('return_to');
            $router = $this->event->getRouter();
            try {
                $this->redirect()->toRoute($url,(array)$params);
            } catch (RouteNotFound $e) {
                $url = strpos($url, '://') 
                        ? $url 
                        : $router->getBaseUrl() . '/' . ltrim($url, '/');
                
                if ($params) {
                    $url = explode('?', $url);
                    $params = http_build_query($params);
                    $url[] = $params;
                    $url = array_shift($url) . '?' . join('&', $url);
                }
                
                
                $this->redirect()->toUrl($url);
            }
        }
    }

}