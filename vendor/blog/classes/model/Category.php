<?php
namespace Blog\model;

use \Blog\model;
use \Blog\DB\Sql;
use \Blog\helper\Check;

class Category extends Model {

    public static function listAll()
    {
        $db = new SQL;
        $resultado = $db->select("SELECT * FROM tb_categories");
        return $resultado;
    }
    /**
     * Retorna uma categoria informando o id_cat
     * 
     * @param int $id Informe o id da categoria a ser consultada
     * @return array com o resultado da consulta.
     */
    public static function getById(int $cat_id)
    {
        $sql = new Sql();
        $resultado = $sql->select("SELECT * FROM tb_categories WHERE cat_id = :cat_id",array(
            ":cat_id"=>$cat_id
        ));
        return $resultado[0];
    }



    public function save() 
    {
        
        $sql = new Sql();
        $sql->query("INSERT INTO tb_categories (cat_id, cat_title, cat_name, cat_desc, cat_parent) VALUES (NULL, :cat_title, :cat_name, :cat_desc, :cat_parent);",array(
            ":cat_title"=>$this->getcat_title(),
            ":cat_name"=>$this->getcat_name(),
            ":cat_desc"=>$this->getcat_desc(),
            ":cat_parent"=>$this->getcat_parent()
        ));
        //Category::updateFile();
    }

    public function update(int $cat_id) 
    {
        
        $sql = new Sql();
        $sql->query("UPDATE tb_categories set cat_title = :cat_title, cat_name = :cat_name, cat_desc = :cat_desc, cat_parent = :cat_parent WHERE cat_id = :cat_id;",array(
            ":cat_id"=>$cat_id,
            ":cat_title"=>$this->getcat_title(),
            ":cat_name"=>$this->getcat_name(),
            ":cat_desc"=>$this->getcat_desc(),
            ":cat_parent"=>$this->getcat_parent()
        ));
        //Category::updateFile();
    }

    public function deleteCatById($cat_id)
    {
        $sql = new Sql();
        $sql->query("DELETE FROM tb_categories WHERE cat_id = :cat_id", array(
            ":cat_id"=>$cat_id
        ));
    } 
}