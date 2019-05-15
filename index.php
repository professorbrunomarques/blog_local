<?php
session_start();

require_once("vendor/autoload.php");

use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\User;
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
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("index");
});
$app->get('/admin/users', function(){
    User::verifyLogin();
    $usuarios = new User;
    $data = $usuarios->listAll();

    $page = new PageAdmin();
    $page->setTpl("users",array(
        "users"=>$data
    ));
});

$app->get('/admin/users/create/',function(){
    User::verifyLogin();
    $page = new PageAdmin();
    $page->setTpl("users-create");
});

$app->post('/admin/users/create', function(){
    User::verifyLogin();

    $data = $_POST;
    $data = array_map('strip_tags', $data);
    $data = array_map('trim', $data);
    $data["email"] = strtolower($data["email"]);
    $data["level"] = (isset($data["level"]) ? 1 : 0);

    if(!Check::campo("email",$data["email"])){
        throw new \Exception('formato do email é inválido!');
    }

    $user = new User;
    $user->setData($data);
    $user->save();
    header("Location: /admin/users");
    exit();
});

$app->get('/admin/users/:iduser/delete', function($iduser){
    User::verifyLogin();
    $user = new User;
    $user->deleteUserById($iduser);
    header("Location: /admin/users");
    exit();
});

//LOGIN
$app->get('/admin/login', function(){
    $page = new PageAdmin(["header"=>false, "footer"=>false]);
    $page->setTpl("login");
});

$app->post('/admin/login', function(){
    if(!User::login($_POST["login"], $_POST["password"])){
        header("location: /admin/login");
    }else{
        header("location: /admin");
    }
    exit();
});

//LOGOUT
$app->get('/admin/logout', function(){
    User::logout();
    header("location: /admin/login");
    exit();
});

$app->run();