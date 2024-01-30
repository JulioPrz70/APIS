<?php
class Database{
    
    private $db_host = 'localhost';     //Trabajemos con el localhost
    private $db_name = 'php_api';       //Nombre de nuestra BD
    private $db_username = 'root';      //Nombre de usuario de la conexión a la BD
    private $db_password = '';          //Contraseña del usuario de conexión
    
    
    public function dbConnection(){
        
        try{        //Se realiza la conexión con la información ingresada
            $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password); 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){     //Si ocurre algún error en la conexión se manda por consola.
            echo "Connection error ".$e->getMessage(); 
            exit;
        }
        
        
    }
}
?>