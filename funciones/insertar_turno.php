<?php 
function InsertarTurno($vConexion) {
    $fecha = $_POST['Fecha'] . ' ' . $_POST['Hora'];
    
    
    $fechaConvertida = strtotime($fecha);
   
    
    $Fecha = date('Y-m-d', $fechaConvertida);
    $Hora = date('Y-m-d H:i:s', $fechaConvertida);
 
    $SQL_Insert = "INSERT INTO turno (paciente, medico, fecha_consulta, fecha_turno, hora, diagnostico, prestacion, estadoTurno)
                VALUES (?, ?, NOW(), ?, ?, ?, ?, 'Cargado')";
    
    $stmt = mysqli_prepare($vConexion, $SQL_Insert);
    mysqli_stmt_bind_param($stmt, 'iissss', $_POST['Paciente'], $_SESSION['Id_Usuario'], $Fecha, $Hora, $_POST['Diagnostico'], $_POST['Prestacion']);
    
    if (!mysqli_stmt_execute($stmt)) {
        die('<h4>Error al intentar insertar el registro.</h4>');
    }
    
    mysqli_stmt_close($stmt);
    
    return true;
}


function Listado_Turnos($vConexion) {

    $Listado=array();
    
    if($_SESSION['Usuario_Id_Nivel'] == 3) {
        $SQL = "select tur.Id as IdTurno, DATE_FORMAT(tur.fecha_turno, '%d/%m/%Y') as Fecha,  
        tur.hora as Hora, CONCAT(pac.Apellido, ' ', pac.Nombre) as Paciente, 
         obr.nombre as ObraSocial, CONCAT(med.Apellido, ' ', med.Nombre) as Medico,
          pres.denominacion as Prestacion, pres.precio, tur.estadoTurno, pres.complejo, pres.porcentaje
         from turno tur, prestaciones pres, usuario pac, usuario med, obras_social obr
         where tur.paciente = pac.id and tur.medico = med.id and tur.prestacion = pres.id 
         and pac.id_obra_social = obr.id and pac.id = ".$_SESSION["Id_Usuario"]."
        ORDER BY tur.fecha_turno, tur.hora ";
    }
              
    else if($_SESSION['Usuario_Id_Nivel'] == 2) {
        $SQL = "select tur.Id as IdTurno, DATE_FORMAT(tur.fecha_turno, '%d/%m/%Y') as Fecha,  
        tur.hora as Hora, CONCAT(pac.Apellido, ' ', pac.Nombre) as Paciente, 
         obr.nombre as ObraSocial, CONCAT(med.Apellido, ' ', med.Nombre) as Medico,
          pres.denominacion as Prestacion, pres.precio, tur.estadoTurno, pres.complejo, pres.porcentaje
         from turno tur, prestaciones pres, usuario pac, usuario med, obras_social obr
         where tur.paciente = pac.id and tur.medico = med.id and tur.prestacion = pres.id 
         and pac.id_obra_social = obr.id and med.id = ".$_SESSION["Id_Usuario"]."
        ORDER BY tur.fecha_turno, tur.hora ";
    }
else {
    $SQL = "select tur.Id as IdTurno, DATE_FORMAT(tur.fecha_turno, '%d/%m/%Y') as Fecha,  
    tur.hora as Hora, CONCAT(pac.Apellido, ' ', pac.Nombre) as Paciente, 
     obr.nombre as ObraSocial, CONCAT(med.Apellido, ' ', med.Nombre) as Medico,
      pres.denominacion as Prestacion, pres.precio, tur.estadoTurno, pres.complejo, pres.porcentaje
     from turno tur, prestaciones pres, usuario pac, usuario med, obras_social obr
     where tur.paciente = pac.id and tur.medico = med.id and tur.prestacion = pres.id 
     and pac.id_obra_social = obr.id
    ORDER BY tur.fecha_turno, tur.hora";
}

if($_SESSION['Usuario_Id_Nivel'] == 3) { 

}
else if($_SESSION['Usuario_Id_Nivel'] == 2) {

 }
else {

}

     $rs = mysqli_query($vConexion, $SQL);
        
     
     $i=0;
    while ($data = mysqli_fetch_array($rs)) {
            $Listado[$i]['IDTURNO'] = $data['IdTurno'];
            $Listado[$i]['FECHA'] = $data['Fecha'];
            $Listado[$i]['HORA'] = $data['Hora'];
            $Listado[$i]['PACIENTE'] = $data['Paciente'];
            $Listado[$i]['OBRASOCIAL'] = $data['ObraSocial'];
            $Listado[$i]['MEDICO'] = $data['Medico'];
            $Listado[$i]['PRESTACION'] = $data['Prestacion'];
            $Listado[$i]['PRECIO'] = $data['precio'];
            $Listado[$i]['ESTADO'] = $data['estadoTurno'];
            $Listado[$i]['COMPLEJO'] = $data['complejo'];
            $Listado[$i]['PORCENTAJE'] = $data['porcentaje'];
         

            $i++;
    }


    //devuelvo el listado generado en el array $Listado. (Podra salir vacio o con datos)..
    return $Listado;

}


?>