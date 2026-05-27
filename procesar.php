<?php
//1. Sintaxis y Semántica: Activiar el  tipado estricto de la version PHP 7.4 o superior

declare(strict_types=1);

//2. Verificar los datos que llegan del formualrio a travez del metodo POST, para evitar errores de tipo y asegurar que los datos sean del tipo esperado.

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //2.2 Verificar y convertir los datos recibidos del formulario
    //?? Porsi el dato no existe se pone eso
    $componenteRecibido = $_POST['componente']??'';
    //Convertir a string de un numero entero
    $cantidad = (int) ($_POST['cantidad'] ?? 0);
    //checkbox
    $esInstitucional = isset($_POST['institucional']) ? true : false;
    //Estructura de control para validar los datos recibidos
    //Vamos a usar la funcion que se llama match que es una nueva estructura de control en PHP 8.0 para validar el componente recibido
    $precioUnitario = match ($componenteRecibido) {
        'RAM' => 85.00,
        'Disco Duro' => 160.75,
        'Procesador' => 350.50,
        default => 0.0, // Si el componente no es reconocido, se asigna un precio de 0
    };
    //Calcular el precio total con operadores y expresiones
    $subtotal = $precioUnitario * $cantidad;
    //Aplicar un descuento del 10% si es institucional
    $descuento = 0.0;
    //if para la logica del negocio
    if ($esInstitucional) {
        $descuento = $subtotal * 0.10; // 10% de descuento
    }
    //Expresion final
    $total = $subtotal - $descuento;
    //Imprimir el resultado usando HTML y PHP
}
?>