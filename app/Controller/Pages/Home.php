<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Home{

    public static function getHome(){
        return View::render('pages/home', [
            'name' => 'Pablo',
            'description' => 'Projeto MVC: https://youtu.be/TmeyoTNu748?si=o1mHOx1Jbq9mfHeL'
        ]);
    }

}

?>