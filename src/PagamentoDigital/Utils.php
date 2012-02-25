<?php

namespace PagamentoDigital;

class Utils {
    public static function toFloat($value) {
        $value = (string)$value;
        if(!is_numeric($value[0])){
          $value = '0' . $value;
        }
        
        if(strrpos($value,',') > strrpos($value,'.')){
            $value = str_replace('.','',$value);
            $value = strtr($value,',','.');
        }else{
            $value = str_replace(',','',$value);
        }
        $value = explode('.',$value);
        $value = array_shift($value) . '.' . join($value);        
        
        return (float)$value;
    }

}