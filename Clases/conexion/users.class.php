<?php 
require_once "conexion.php";
require_once "respuestas.class.php";

class users extends conexion{

    private $table = "Users"; 
    public function listaUsers($pagina = 1){
        
         $inicio = 0;
         $cantidad = 50;
         if($pagina > 1){
             $inicio = ($cantidad * ($pagina-1)) + 1;
             $cantidad = $cantidad * $pagina;
         }

         $query = "SELECT * FROM Users";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    public function obtenerUsers($id){
        $query = "SELECT * FROM Users WHERE id LIKE '%".$id."%'";
        $datos = parent::obtenerDatos($query);
        return ($datos);

    }
    

}


?>