<?php
//Configuración de header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,X-requested-with");

//Acceso a BD
require 'database.php';

//db_connection
$db_dbConecction = new Database();
$conn = $db_dbConecction->dbConnection();

//Hacer get form request
$data = json_decode(file_get_contents("php://input"));

//Verificar si el id se encuentra disponible
if (isset($data->id)) {
              
        $post_id = $data->id;
        //Obtener si el valor de la BD
        //Este query es opcional porque se puede borrar directamente
        $check_post = "SELECT * FROM `posts` WHERE id=:post_id";
        $check_post_stmt = $conn->prepare($check_post);
        $check_post_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
        $check_post_stmt->execute();

        //Verificar si existe el POST en nuestra BD
        if ($check_post_stmt->rowCount() > 0) {
            $delete_post = "DELETE FROM `posts` WHERE id=:post_id";
            $delete_post_stmt = $conn->prepare($delete_post);
            $delete_post_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);
            
            if ($delete_post_stmt->execute()) {
                //Crear el mensaje en el arreglo
                $msg['message']='El Post(Publicación) se ha borrado.';
            }else{
                //Crear el mensaje en el arreglo
                $msg['message']='La Publicación no se pudo borrar.';
            }
        }else{
            //Crear el mensaje en el arreglo
            $msg['message']='ID Invalido';
        }
        echo json_encode($msg);

}else{
        //Crear el mensaje en el arreglo
        $msg['message']='No enviaste ningun valor';
}