<?php 
require_once "conexion.php";
require_once "respuestas.class.php";

class productos extends conexion{

    private $table = "Productos"; 
    public function listaProductos($pagina = 1){
        
         $inicio = 0;
         $cantidad = 50;
         if($pagina > 1){
             $inicio = ($cantidad * ($pagina-1)) + 1;
             $cantidad = $cantidad * $pagina;
         }

         $query = "SELECT * FROM " . $this->table . " limit $inicio,$cantidad";
        $datos = parent::obtenerDatos($query);
        return ($datos);
    }
    public function obtenerProducto($id){
        //$query = "SELECT * FROM Productos WHERE Nombre LIKE '%".$id."%'";
        $query = "SELECT Equipo, COUNT(*) FROM registro GROUP BY Equipo";
        $datos = parent::obtenerDatos($query);
        return ($datos);

    }
    

}


?>