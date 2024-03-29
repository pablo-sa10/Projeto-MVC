<?php

namespace App\Utils;

class View{

    private static $vars = [];

    public static function init($vars = []){
        self::$vars = $vars;
    }

    /**
     * metodo responsavel por retornar o conteudo de uma view
     * @param string $view
     * @return string
     */

    private static function getContentView($view){
        $file = __DIR__.'/../../resources/view/'.$view.'.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * metodo responsavel por retornar o conteúdo renderizado de uma view
     * @param string $view
     * @param array $vars (string/number)
     * @return string 
     */

    public static function render($view, $vars = []){
        //CONTEUDO DA VIEW
        $contentView = self::getContentView($view);

        $vars = array_merge(self::$vars, $vars);

        //CHAVES DO ARRAY DE VARIÁVEL
        $keys = array_keys($vars);
        $keys = array_map(function($item){
            return '{{'.$item.'}}';
        },$keys);

        //RETORNA O CONTEUDO RENDERIZADO
        return str_replace($keys, array_values($vars), $contentView);
    }


}
