<?php
namespace Blog;

use Rain\Tpl;

class Page{

    private $tpl;
    private $options = [];
    private $defaults = [
        'header' => true,
        'footer' => true,
        'data' => []
    ];

    public function __construct($opts = array(), $tpl_dir = "./views/")
    {
        //Gera o cabeçalho das páginas
        
        $this->options = array_merge($this->defaults, $opts);
        // config
        $config = array(
        "tpl_dir"       => $tpl_dir,
        "cache_dir"     => "./views-cache/",
        "debug"         => false, // set to false to improve the speed
        );
        
        Tpl::configure( $config );
        
        $this->tpl = new Tpl;

        $this->setData($this->options["data"]);

        if($this->options["header"] === true)
        {
            $this->tpl->draw("header");
        }
    }

    public function setTpl($name, $data = array(), $returnHTML = false)
    {
        //corpo da página
        $this->setData($data);
        return $this->tpl->draw($name, $returnHTML);
    }

    private function setData($data = array())
    {
        foreach ($data as $key => $value) {
            $this->tpl->assign($key, $value);
        }
    }

    public function __destruct()
    {
        //Gerar o rodapé das páginas
        if($this->options["footer"] === true)
        {
            $this->tpl->draw("footer");
        }

    }
}