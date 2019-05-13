<?php

require_once("vendor/autoload.php");

use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\Usuario;
use \Blog\helper\Check;
use \Blog\helper\Upload;

$app = new \Slim\Slim();
$app->get('/', function () {
    $dados = [];
    $dados["titulo"] = "Bem-Vindo ao meu Blog";
    $dados_page["titulo_principal"] = "Olá sejá muito bem-vindo!";
    $page = new Page(array(
        "data"=> $dados
    ));
    $page->setTpl("home", $dados_page);

});

$app->get('/admin/',function(){
    $data = ["header"=>false, "footer"=>false];
    $page = new PageAdmin();
    $page->setTpl("modelo", $data);
});
$app->get('/admin/users/', function(){

    $usuarios = new Usuario;
    $data = $usuarios->listAll();

    $page = new PageAdmin();
    $page->setTpl("users",array(
        "users"=>$data
    ));
});
$app->get('/admin/users/create/',function(){
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->run();