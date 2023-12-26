<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{

    // método responsavel por renderizar o topo da pagina
    private static function getHeader()
    {
        return View::render('Pages/header');
    }

    //método responsável por renderizar o rodapé da página
    private static function getFooter()
    {
        return View::render('pages/footer');
    }


    public static function getPage($tilte, $content)
    {
        return View::render('pages/page', [
            'title' => $tilte,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter()
        ]);
    }
}
