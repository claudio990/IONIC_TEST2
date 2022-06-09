<?php 
require_once 'conexion.php';
require_once 'respuestas.class.php';

class auth extends conexion{
   public function  login($json){
       $_respuestas = new respuestas;
       $datos = json_decode($json,true);
       if(!isset($datos['usuario']) || !isset($datos["password"])){
           //error en los campos
           return $_respuestas->error_400();
       }
       else{
           //todo bien
           $usuario = $datos['usuario'];
           $password = $datos['password'];
           $password = parent::encriptar($password);
           $password = "12345";
           $datos = $this->obtenerDatosUsuario($usuario);
           if($datos){
               if($password == $datos[0]['passord']){
                    if($datos[0]['Estado']=="Activo"){
                        $verificar = $this->insertarToken($datos[0]['UsuarioId']);
                        
                        if($verificar){
                            $result =  $_respuestas->response;
                            $result["result"]= array(
                                "token" => $verificar
                            );
                            return $result;
                        }
                        else{
                            return  $_respuestas->error_500("Error interno del servidor");
                        }
                    }
                    else{
                        return  $_respuestas->error_200("usuario incorrecto");
                        echo "hola";
                    }
               }
               else{
                   //return $_respuestas->error_200("contraseña incorrecta");
                   print_r($password);
               }
           }
           else{
               return $_respuestas->error_200("El usuario $usuario no existe");
           }
       }
   }

   private function obtenerDatosUsuario($correo){
       $query = "SELECT UsuarioId,passord,Estado FROM Usuarios WHERE usuario = '$correo'";
       $datos = parent::obtenerDatos($query);
       if(isset($datos[0]["UsuarioId"])){
           return $datos;
       }
       else{
           return 0;
       }
   }

   private function insertarToken($usuarioid){
    $val = true;
    $token = bin2hex(openssl_random_pseudo_bytes(16,$val));
    $date = date("Y-m-d H:i");
    $estado = "Activo";
    $query = "INSERT INTO usuarios_token (UsuarioId,Token,Estado,Fecha)VALUES('$usuarioid','$token','$estado','$date')";
    $verifica = parent::nonQuery($query);
    if($verifica){
        return $token;
    }else{
        return 0;
    }
   } 
}

?>