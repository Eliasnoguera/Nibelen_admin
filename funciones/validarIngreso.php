<?php 

function Validar_Ingreso() {
    $formatoHora = '/^(?:[01]\d|2[0-3]):(?:[0-5]\d):(?:[0-5]\d)$/';
    $vMensaje = '';
    $Fecha = isset($_POST['Fecha']) ? $_POST['Fecha'] : '';
    $Hora = isset($_POST['Hora']) ? $_POST['Hora'] : '';
    
    if ($_POST['Paciente'] === 'Selecciona una opción...') { 
        $vMensaje = 'Debe seleccionar un Paciente';
    } else if ($_POST['Prestacion'] === '') { 
        $vMensaje = 'Debe seleccionar una prestación.';
    } else if (empty($Fecha)) {  
        $vMensaje = 'Debe ingresar una fecha';
    } else if (!preg_match($formatoHora, $Hora)) {
        $vMensaje = 'Debe ingresar un horario';
    }

    foreach($_POST as $Id=>$Valor){
        $_POST[$Id] = trim($_POST[$Id]);
        $_POST[$Id] = strip_tags($_POST[$Id]);
    }


    return $vMensaje;

}
?>