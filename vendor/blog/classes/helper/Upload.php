<?php
namespace Blog\helper;

class Upload {
    
    private $file;
    private $size;
    private $type;
    const MAXFILESIZE = 2097152;
    private $rename;

    public function uploadImage ($file, $rename = false){
        $this->file = $file;
        $this->type = array("image/jpeg", "image/jpg","image/png","image/gif");
        $this->rename = $rename;

        if($this->checkFileSize()){
            if($this->checkFileType()){
                if($this->moveFile()){
                    return "Arquivo enviado com sucesso!";
                }else{
                    return "Erro ao enviar o arquivo.";
                }
            }else{
                return "Por favor utilize apenas aquivos do tipo .jpg, .jpeg, .png ou .gif";    
            }

        }else{
            return "O arquivo é maior que 2Mb.";
        }
    }

    

    private function checkFileType(){
        if(in_array($this->file["type"],$this->type)){
            return true;
        }else{
            return false;
        }
    }
    private function checkFileSize(){
        if($this->file["size"] <= self::MAXFILESIZE){
            return true;
        }else{
            return false;
        }
    }
    private function renameFile(){
        $file = $this->file["name"];
        $filename = substr($file, 0, strlen($file)-4);
        $fileext = strtolower(substr($file, -4));
        $new_file_name = Check::Name($filename).$fileext;

        return $new_file_name;
    }
    private function moveFile(){
        if($this->rename == true){
            $filename = $this->renameFile();
        }else{
            $filename = $this->file["name"];
        }

        if(move_uploaded_file($this->file["tmp_name"],"uploads/".$filename)){
            return true;
        }else{
            return false;
        }
    }
}