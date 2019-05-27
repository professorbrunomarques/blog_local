<?php
session_start();

setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo'); 

require_once './vendor/autoload.php';

use \Slim\Slim;
use \Blog\Page;
use \Blog\PageAdmin;
use \Blog\model\User;
use \Blog\model\Category;
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
//UPDATE USER
$app->get('/admin/users/:iduser', function($iduser){
    User::verifyLogin();
    $user = User::getUserById($iduser);

    $page = new PageAdmin();
    $page->setTpl("users-update", array(
        "user" => $user
    ));
});

$app->post('/admin/users/:iduser', function($iduser){
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
    $user->update($data, $iduser);
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

// FORGOT
$app->get('/admin/forgot', function(){

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot");
});
$app->post('/admin/forgot', function(){

    $user = User::getForgot($_POST["email"]);

    header("Location: /admin/forgot/sent");
    exit;

});

$app->get('/admin/forgot/sent', function(){

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot-sent");

});
$app->get('/admin/forgot/reset', function(){
    
    $user = User::validForgotDecrypt($_GET["code"]);

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot-reset", array(
        "name"=>$user["name"],
        "code"=>$_GET["code"]
    ));
});
$app->post('/admin/forgot/reset', function(){
    $forgot = User::validForgotDecrypt($_POST["code"]);

    User::setForgotUsed($forgot["idrecovery"]);

    $user = new User();
    $user->get((int)$forgot["id_user"]);
    $user->setNewPassword($_POST["password"]);

    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("forgot-reset-success");
});

// Admin Categorys

$app->get('/admin/categories', function(){
    User::verifyLogin();
    $categories = Category::listAll();
    $page = new PageAdmin();
    $page->setTpl('categories', array(
        "categories"=>$categories
    ));

});
$app->get('/admin/categories/create', function(){

    User::verifyLogin();
    $categories = Category::listAll();
    $page = new PageAdmin();
    $page->setTpl('categories-create', array(
        "categories"=>$categories
    ));
});

$app->post('/admin/categories/create', function(){
    
    User::verifyLogin();
    $data = $_POST;
    $data["cat_name"] = Check::Name($data["cat_title"]);
    $cat = new Category();
    $cat->setData($data);
    $cat->save();
    header("Location: /admin/categories");
    exit();
});

$app->get('/admin/categories/:cat_id',function($cat_id){
    
    User::verifyLogin();
    $categories = Category::listAll();
    $category = Category::getById($cat_id);
    $page = new PageAdmin();
    $page->setTpl('categories-update', array(
        "categories"=>$categories,
        "category"=>$category
    ));
});

$app->post('/admin/categories/:cat_id', function($cat_id){
    User::verifyLogin();
    $data = $_POST;
    $data["cat_name"] = Check::Name($data["cat_title"]);
    $cat = new Category();
    $cat->setData($data);
    $cat->update($cat_id);
    header("Location: /admin/categories");
    exit();
});
$app->get('/admin/categories/:cat_id/delete', function($cat_id){
    User::verifyLogin();
    $cat = new Category();
    $cat->deleteCatById($cat_id);
    header("Location: /admin/categories");
    exit();
});

$app->run();