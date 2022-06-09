<?php
require_once 'Clases\conexion/respuestas.class.php';
require_once 'Clases\conexion/inventario.class.php';

$_respuestas = new respuestas;
$_productos = new productos;
if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $listaProductos = $_productos->listaProductos($pagina);
        header("Content-Type: application/json");
        echo json_encode($listaProductos);
        http_response_code(200);
    }else if(isset($_GET['id'])){
        $productosid = $_GET['id'];
        $datosProducto = $_productos->obtenerProducto($productosid);
        header("Content-Type: application/json");
        echo json_encode($datosProducto);
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
    if(isset($headers["Id_Producto"])){
        //recibimos los datos enviados por el header
        $send = [
            "Id_Producto" =>$headers["Id_Producto"]
        ];
        $postBody = json_encode($send);
    }else{
        //recibimos los datos enviados
        $postBody = file_get_contents("php://input");
    }
    
    //enviamos datos al manejador
    $datosArray = $_productos->delete($postBody);
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