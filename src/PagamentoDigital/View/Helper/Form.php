<?php

namespace PagamentoDigital\View\Helper;

use PagamentoDigital,
    \Zend\View\Helper\AbstractHelper,
    \PagamentoDigital\Order,
    \PagamentoDigital\Base;

class Form extends AbstractHelper {

    public function __invoke(Order $order, array $options = array()) {
        $config = Base::getInstance()->getConfig();
        return $this->getView()->render('pagamento_digital/form.phtml', array(
                    'order' => $order,
                    'options' => $options,
                    'config' => $config
                        )
        );
    }

}