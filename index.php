<?php

require_once __DIR__.'/vendor/autoload.php';

use \App\Http\Router;
use \App\Utils\View;


define('URL', 'http://10.10.2.99/Projeto-mvc');

View::init([
    'URL' => URL
]);

//incia o router
$obRouter = new Router(URL);

//inclui as rotas de páginas
include __DIR__.'/routes/pages.php';

$obRouter->run()->sendResponse(); 

?>