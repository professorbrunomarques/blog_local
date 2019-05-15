<?php

namespace Blog\model;

use \Blog\Model;
use \Blog\DB\Sql;

class User extends Model {

    const SESSION = 'User';

    public static function login($login, $password)
    {
        $db = new Sql;
        $resultado = $db->select("SELECT * FROM tb_users WHERE login = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        if(count($resultado) == 0){
            throw new \Exception("Não foi possível fazer login.");
        }

        $data = $resultado[0];

		if (password_verify($password, $data["password"])) {
			$user = new User();
			$user->setData($data);
			$_SESSION[User::SESSION] = $user->getValues();
           
			return $user;
		} else {
			throw new \Exception("Não foi possível fazer login.");
			//$_SESSION["ERROR"] = "Não foi possível fazer o login.";
		}

    }

    public static function logout(){
        $_SESSION[User::SESSION] = NULL;
    }

    public static function verifyLogin($isadmin = true)
    {
        if(
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]['id_user'] > 0
            ||
            (bool)$_SESSION[User::SESSION]['level'] !== $isadmin
        )
        {
            var_dump($_SESSION[User::SESSION]);
            //header('Location: /admin/login');
            //exit();
        }
        
    }

    public function listAll(){
        $db = new SQL;
        $resultado = $db->select("SELECT * FROM tb_users");
        return $resultado;
    }
    
    public function save()
    {
        $db = new Sql;
        return $db->query("INSERT INTO tb_users (login, password, name, level, email) VALUES (:login, :password, :name, :level, :email)", array(
            ":login"     => $this->getlogin(),
            ":password"  => password_hash($this->getpassword(), PASSWORD_DEFAULT, ["coast"=>12]),
            ":name"      => $this->getname(),
            ":level"     => $this->getlevel(),
            ":email"     => $this->getemail()
        ));
    }

    public function deleteUserById($id)
    {
        $db = new Sql;
        return $db->query("DELETE FROM tb_users WHERE id_user = :id_user", array(
            ":id_user"=>$id
        ));
    }
}