<?php
    class CriarBanco{
        public static function criar(){
            $db = new Database();
        
            $sql = "CREATE TABLE IF NOT EXISTS `ponto`.`usuarios` ( `id` INT NOT NULL AUTO_INCREMENT , `nome` VARCHAR(32) NOT NULL , `usuario` VARCHAR(15) NOT NULL , `senha` VARCHAR(15) NOT NULL , `tipo` VARCHAR(15) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;";
            
            $resul = $db->multi_query($sql);
        
            if($resul){
                echo("banco criado!");
            }
            else{
                echo("Erro");
            }
        }
    }