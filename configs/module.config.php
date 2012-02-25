<?php

return array(
    'pagamento_digital' => array(
        'development' => array(
            'developer' => true,
            #'gateway_url' => ($gateway_url = '/pagamento-digital/retorno'),
            'return_to' => 'home'
        )
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'pagamento_digital-index' => 'PagamentoDigital\Controller\IndexController',
                'pagamento_digital-development' => 'PagamentoDigital\Controller\DevelopmentController',
            ),
            'Zend\View\HelperLoader' => array(
                'parameters' => array(
                    'map' => array(
                        'pagamentoDigitalForm' => 'PagamentoDigital\View\Helper\Form'
                    ),
                ),
            ),
            'Zend\View\HelperBroker' => array(
                'parameters' => array(
                    'loader' => 'Zend\View\HelperLoader',
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'resolver' => 'Zend\View\TemplatePathStack',
                    'options' => array(
                        'script_paths' => array(
                            'pagamentodigital' => __DIR__ . '/../views'
                        )
                    ),
                    'broker' => 'Zend\View\HelperBroker',
                ),
            ),
        ),
    ),
    'routes' => array(
        'pagamento_digital' => array(
            'type' => 'literal',
            'options' => array(
                'route' => '/pagamento-digital',
                'defaults' => array(
                    'module' => 'pagamento_digital',
                    'controller' => 'index',
                    'action' => 'index',
                ),
            ),
            'child_routes' => array(
                'default' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'may_terminate' => true,
                    'options' => array(
                        'route' => '/:controller[/:action]',
                        'defaults' => array(
                        )
                    ),
                ),
                'development' => array(
                    'type' => 'literal',
                    'options' => array(
                        'route' => '/retorno',
                        'defaults' => array(
                            'controller' => 'development'
                        )
                    )
                ),
                'home' => array(
                    'type' => 'literal',
                    'options' => array(
                        'route' => '/',
                        'defaults' => array(
                        )
                    )
                ),
            )
        ),
    ),
);
