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

//Verifica el id de parametro
if (isset($_GET['id'])) {
    //Filtrar por un id
    $post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
        'options' => [
            'default' => 'all_posts',
            'min_range' => 1
        ]
    ]);
}else{
    //Se debe mostrar todo los posts
    $post_id = 'all_posts';
}

//Crear el query
//Si existe un post de un id se muestra solo ese si no se muestran todos los post
$sql = is_numeric($post_id) ? "SELECT * FROM `posts` WHERE id = '$post_id' " :"SELECT * FROM `posts`";
//Se prerara el sql
$stmt = $conn->prepare($sql);
$stmt->execute();

//Verificar si existe algun post en nuestra BD
if ($stmt->rowCount()>0) {
    //Crear el arreglo de los postS
    //Inicializar el arreglo
    $post_array= [];
    while ($row=$stmt -> fetch(PDO::FETCH_ASSOC)) {
        //Generar el array del json
        $post_data = [
            'id' => $row['id'],
            'title' => $row['title'],
            'body' => html_entity_decode($row['body']),
            'author' => $row['author']
        ];
        //Hacer PUSH en el arreglo del post data
        array_push($post_array, $post_data);
    }
    //Mostrar o generar los posts en formato JSON
    echo json_encode($post_array);
}else{
    echo json_encode([message=>'No se encontró el post.']);
}
?>