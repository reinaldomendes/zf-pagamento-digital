<?php

namespace PagamentoDigital\View\Helper;

use \Zend\View\Helper\AbstractHelper;

class Form extends AbstractHelper {

    public function __invoke($order, $options = array()) {
        return $this->render('pagamento_digital/form.phtml', array(
                    'order' => $order, 'options' => $options
                )
        );
    }

}