<?php

namespace PagamentoDigital;

class Order {

    protected static $_EXTRAS_MAPPING = array(
        'nome' => "nome",
        'cpf' => "cpf",
        'sexo' => "sexo",
        'data_nasc' => 'data_nascimento',
        'email' => "email",
        'telefone' => "telefone",
        'celular' => "celular",
        'endereco' => "endereco",
        'complemento' => "complemento",
        'bairro' => "bairro",
        'cidade' => "cidade",
        'estado' => "estado",
        'cep' => "cep",
        'free' => "free",
        'tipo_frete' => "tipo_frete",
        'desconto' => "desconto",
        'acrescimo' => "acrescimo",
        'razao_social' => 'cliente_razao_social',
        'cnpj' => "cliente_cnpj",
        'rg' => 'rg',
        'hash' => "hash",
    );
    protected $_extras = array();

    public function setExtras($array = array()) {
        $this->_extras = $array;
        return $this;
    }

    public function setExtra($name, $value) {
        $this->_extras[$name] = $value;
        return $this;
    }

    public function getExtras($name= null) {
        if (null === $name)
            return $this->_extras;
        return $this->_extras[$name];
    }

    public function getExtrasMapped() {
        $return = array();
        foreach ($this->_extras as $key => $value) {
            $key = self::$_EXTRAS_MAPPING[$key];
            if ($key) {
                $return[$key] = $value;
            }
        }
        return $return;
    }
    
    public function setFrete($value){
        $this->_frete = $this->_convertUnit($value, 2);
        return $this;
    }
    public function getFrete(){
        return $this->_frete;
    }
    

    /**
     * Add a product
     * 
     * @param array $params  array('descricao'=> [optional]'preco' => 1,'id' => 1,'qtde' => [optional])
     */
    public function add(array $params = array()) {
        $options = $params + array(                        
            'preco' => null,
            'qtde' => 1
        );
        $options['preco'] = $this->_convertUnit($options['preco'], 2);
        $this->_products[] = $options;
        return $this;
    }
    /**
     *
     * @param mixed $valor
     * @param int $unit 
     */
    protected function _convertUnit($valor, $unit) {
        round(Utils::toFloat($valor), $unit);
    }

}