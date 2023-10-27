<?php
function Listar_Usuarios($vConexion) {

    $Listado=array();

    //1) genero la consulta que deseo
    $SQL = "SELECT id, nombre, apellido, dni from usuario where id_nivel = 3 
    order by nombre, apellido";

    //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
     $rs = mysqli_query($vConexion, $SQL);
        
     //3) el resultado deberá organizarse en una matriz, entonces lo recorro
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['ID'] = $data['id'];
            $Listado[$i]['NOMBRE'] = $data['nombre'];
            $Listado[$i]['APELLIDO'] = $data['apellido'];
            $Listado[$i]['DNI'] = $data['dni'];
           

           
         

            $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;
    
   
}

function listado_completo($vConexion) {
    $listadoUsuario = array();

    $SQL = "SELECT usuario.nombre, usuario.apellido, nivel.denominacion 
              FROM usuario 
              INNER JOIN nivel ON usuario.id_nivel = nivel.id";
    
       //2) a la conexion actual le brindo mi consulta, y el resultado lo entrego a variable $rs
 $rs = mysqli_query($vConexion, $SQL);
    
 //3) el resultado deberá organizarse en una matriz, entonces lo recorro
 $i=0;
while ($data = mysqli_fetch_array($rs)) {
        //$listadoUsuario[$i]['ID'] = $data['id'];
        $listadoUsuario[$i]['NOMBRE'] = $data['nombre'];
        $listadoUsuario[$i]['APELLIDO'] = $data['apellido'];
        //$listadoUsuario[$i]['DNI'] = $data['dni'];
        $listadoUsuario[$i]['ROL'] = $data['denominacion'];

       
     

        $i++;
}

return $listadoUsuario;
    
    }

?>

