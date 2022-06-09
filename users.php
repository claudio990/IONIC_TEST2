<?php
require_once 'Clases\conexion/respuestas.class.php';
require_once 'Clases\conexion/users.class.php';

$_respuestas = new respuestas;
$_users = new users;
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaUsers = $_users->listaUsers($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaUsers);
        http_response_code(200);
    }else if(isset($_GET['id'])){
        $usersid = $_GET['id'];
        $datosUsers = $_users->obtenerUsers($usersid);
        header("Content-Type: application/json");
        echo json_encode($datosUsers);
        http_response_code(200);
    }

}
elseif ($_SERVER['REQUEST_METHOD'] == "POST") {
        //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_productos->post($postBody);
    //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);

}elseif ($_SERVER['REQUEST_METHOD'] == "PUT") {
         //recibimos los datos enviados
      $postBody = file_get_contents("php://input");
      //enviamos datos al manejador
      $datosArray = $_productos->put($postBody);
        //delvovemos una respuesta 
     header('Content-Type: application/json');
     if(isset($datosArray["result"]["error_id"])){
         $responseCode = $datosArray["result"]["error_id"];
         http_response_code($responseCode);
     }else{
         http_response_code(200);
     }
     echo json_encode($datosArray);

}else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
    $headers = getallheaders();
    if(isset($headers["id"])){
        //recibimos los datos enviados por el header
        $send = [
            "id" =>$headers["id"]
        ];
        $postBody = json_encode($send);
    }else{
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
    }
    
    //enviamos datos al manejador
    $datosArray = $_users->delete($postBody);
    //delvovemos una respuesta 
    header('Content-Type: application/json');
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray);
}else {
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}





?>