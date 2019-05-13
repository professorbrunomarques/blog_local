<?php

namespace Blog\model;

use \Blog\DB\Sql;

class Usuario {
    private $sql;

    private $id;
    private $nome;
    private $email;
    private $senha;



    /**
     * METODOS PÚBLICOS
     */
    public function __construct(){
        $this->sql = new Sql;
    }


    public function listAll(){
        $query = "SELECT * FROM tb_users";
        $resultado = $this->sql->select($query);
        return $resultado;
    }
    
}