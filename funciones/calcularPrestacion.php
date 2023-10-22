<?php
function CalcularInteresPrestacion($precio, $porc) {
    $adicional = $precio * ($porc / 100);
    return $adicional;
}

?>