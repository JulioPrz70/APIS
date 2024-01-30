<?php
class Database{
    
    private $db_host = 'localhost';     //Trabajemos con el localhost
    private $db_name = 'php_api';       //Nombre de nuestra BD
    private $db_username = 'root';      //Nombre de usuario de la conexi�n a la BD
    private $db_password = '';          //Contrase�a del usuario de conexi�n
    
    
    public function dbConnection(){
        
        try{        //Se realiza la conexi�n con la informaci�n ingresada
            $conn = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name,$this->db_username,$this->db_password); 
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e){     //Si ocurre alg�n error en la conexi�n se manda por consola.
            echo "Connection error ".$e->getMessage(); 
            exit;
        }
        
        
    }
}
?>