<?php

return array(
    'pagamento_digital' => array(
        'development' => array(
            'developer' => true,
            'gateway' => '/pagamento-digital/retorno',
            'return_to' => '/'
        )
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'pagamento_digital-index' => 'PagamentoDigital\Controller\IndexController',
            #'pagamento_digital-development' => 'PagamentoDigital\Controller\IndexController',
            )
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
                        'pagamento_digital' => __DIR__ . '/../views'
                    )
                ),
                'broker' => 'Zend\View\HelperBroker',
            ),
        ),
    ),
    'routes' => array(
        'pagamento_digital' => array(
            'type' => 'Zend\Mvc\Router\Http\Literal',
            'options' => array(
                'route' => '/pagamento-digital',
                'defaults' => array(
                    'module' => 'pagamento_digital',
                    'controller' => 'index',
                    'action' => 'index',
                ),
            ),
            'child_routes' => array(
                'pagamento_digital-default' => array(
                    'type' => 'Zend\Mvc\Router\Http\Segment',
                    'may_terminate' => true,
                    'options' => array(
                        'route' => '/:controller[/:action]',
                        'defaults' => array(
                        )
                    ),
                ),
                'pagamento_digital-home' => array(
                    'type' => 'literal',
                    'options' => array(
                        'route' => '/',
                        'defaults' => array(
                        )
                    )
                )
            )
        ),
    ),
);
