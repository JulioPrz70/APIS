<?php
//Configuración de header
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset:UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization,X-requested-with");

//Acceso a BD
require 'database.php';

//Conexión a la Base de datos
$db_dbConecction = new Database();
$conn = $db_dbConecction->dbConnection();

//Hacer get form request
$data = json_decode(file_get_contents("php://input"));

//Crear el mensaje en el arreglo
$msg['message']='';

//Verificar si se recibe datos del request
if(isset($data->title) && isset($data->body) && isset($data->author)){
    //Verificamos que no sean datos vacios
    if (!empty($data->title) && !empty($data->body) && !empty($data->author)) {
        //Crear la consulta
        $insert_query="INSERT INTO `posts`(title, body, author) VALUES (:title, :body, :author)";
        
        //Conexión de la BD con el Query
        $insert_stmt= $conn->prepare($insert_query);

        //Data Binding es la conexión entre el backend con el frontend
        $insert_stmt->bindValue(':title', htmlspecialchars(strip_tags($data->title)), PDO::PARAM_STR);
        $insert_stmt->bindValue(':body', htmlspecialchars(strip_tags($data->body)), PDO::PARAM_STR);
        $insert_stmt->bindValue(':author', htmlspecialchars(strip_tags($data->author)), PDO::PARAM_STR);

        //Validar si se ejecuto
        if ($insert_stmt->execute()) {
            $msg['message']='Los datos se insertaron'; //Mensaje al ser posible la inserción
        }else{
            $msg['message']='No se insertaron los datos'; //Mensaje al no ser posible la inserción  
        }
}
else{
    $msg['message']= 'No se envio ningun parametro'; //Mensaje al no mandar ningun dato a guardar.
}
}else{
    $msg['message']= 'Por favor llena todos los campos: title: body y author'; //Mensaje al no mandar todos los datos requeridos en la tabla.
}

//Imprimir con un echo DATA en Formato de Json
echo json_encode($msg);
//CORREMOS UN SERVIDOR EN LA CONSOLA PARA PODER VISUALIZARLO
//php -S localhost:8089
?>

