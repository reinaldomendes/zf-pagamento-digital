<?php

namespace PagamentoDigital\Controller;

use \Zend\Mvc\Controller\ActionController;
use \PagamentoDigital\Order;

class IndexController extends ActionController {

    public function indexAction() {
        $order =  new Order;
        $order->setExtras(array(
            'id_pedido' => 1,
            'nome' => 'Reinald Mendes'
        ))->add(array(
            'id' => 2,
            'qtde' => 5,
            'descricao' => 'molho de tomate',
            'preco' => 'R$ 5,00'
        ));
        return array(
            'order' => $order
        );
    }

}