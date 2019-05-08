<?php
namespace Blog\helper;

class Check {
    private static $data;
    private static $format;

    /**
     * Valida E-mail, telefone ou CEP.
     * @param string $campo [ email | telefone | cep ]
     * <b>Formatos válidos:</b>
     * - E-mail => email@provedor.com | email@provedor.com.br
     * - Telefone => (99)9999-9999 | (99)99999-9999
     * - CEP => 99999-999
     * 
     * @param string $valor Valor a ser validado.
     * 
     * @return bool 
     */
    public static function campo($campo, $valor){
        self::$format = array();
        self::$format["email"]="/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/";
        self::$format["telefone"]="/\([0-9]{2}\)+[0-9]{4,5}+\-[0-9]{4}$/";
        self::$format["cep"]="/[0-9]{5}+\-[0-9]{3}$/";

        self::$data = $valor;

        if(preg_match(self::$format[$campo],self::$data)){
            return true;
        }else{
            return false;
        }
    }
    
    public static function limitWords(string $text, int $limit, string $delimiter = null):string{
        self::$data[0] = explode(" ", $text);
        self::$data[1] = array_slice(self::$data[0],0,$limit);
        self::$format[0] = implode(" ",self::$data[1]);

        if (!empty($delimiter)):
            self::$format[0] .= $delimiter;
        endif;
        return self::$format[0];    
    }

    /**
    * <b>Tranforma URL:</b> Tranforma uma string no formato de URL amigável e retorna o a string convertida!
    * @param STRING $Name = Uma string qualquer
    * @return STRING = $Data = Uma URL amigável válida
    */
    public static function Name($Name) {
        
        self::$format = array();
        self::$format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
        self::$format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
        
        self::$data = strtr(utf8_decode($Name), utf8_decode(self::$format['a']), self::$format['b']);
        self::$data = strip_tags(trim(self::$data));
        self::$data = str_replace(' ', '-', self::$data);
        self::$data = str_replace(array('-----', '----', '---', '--'), '-', self::$data);
    
        return strtolower(utf8_encode(self::$data));
    }
}