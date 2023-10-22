<?php 
function DatosLogin($vUsuario, $vClave, $vConexion){
    $Usuario=array();
    


    $SQL=" SELECT us.id, us.nombre, us.apellido,  id_nivel, ni.denominacion as nivel, email, us.imagen 
    FROM usuario us, nivel ni
    where us.id_nivel = ni.id  and us.email ='$vUsuario' AND us.clave='$vClave'  ";

    $rs = mysqli_query($vConexion, $SQL);
        
    $data = mysqli_fetch_array($rs) ;
    if (!empty($data)) {
        $Usuario['ID'] = $data['id'];
        $Usuario['NOMBRE'] = $data['nombre'];
        $Usuario['APELLIDO'] = $data['apellido'];
        $Usuario['IDNIVEL'] = $data['id_nivel'];
        $Usuario['NIVEL'] = $data['nivel'];
        $Usuario['IMG'] = $data['imagen'];
       
        
    }
    return $Usuario;
}

?>