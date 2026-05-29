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
    //Obtener el porcentaje de descuento seleccionado
    $porcentajeDescuento = (int) ($_POST['descuento'] ?? 0);
    //Estructura de control para validar los datos recibidos
    //Vamos a usar la funcion que se llama match que es una nueva estructura de control en PHP 8.0 para validar el componente recibido
    $precioUnitario = match (strtoupper($componenteRecibido)) {
        'PROCESADOR' => 350.50,
        'RAM' => 85.00,
        'ALMACENAMIENTO' => 160.75,
        'MOUSE' => 25.99,
        'AUDIFONOS' => 89.50,
        'TECLADO' => 120.00,
        'MONITOR' => 399.99,
        'WEBCAM' => 79.99,
        'MICROFONO' => 149.00,
        'HUB' => 45.75,
        'CARGADOR' => 65.00,
        default => 0.0, // Si el componente no es reconocido, se asigna un precio de 0
    };
    //Calcular el precio total con operadores y expresiones
    $subtotal = $precioUnitario * $cantidad;
    //Aplicar descuento según el porcentaje seleccionado
    $descuento = $subtotal * ($porcentajeDescuento / 100);
    //Expresion final
    $total = $subtotal - $descuento;
    //Imprimir el resultado usando HTML y PHP
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>";
    echo "<title>Resultado de la Compra</title></head>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "</head><body class='bg-light'><div class='container mt-5'>";  

    echo "<div class='alert alert-success shadow'>";
    echo "<h2 class='alert-heading'>Detalle de la Compra</h2>";
    echo "<hr>";

    echo "<p><strong>Componente:</strong> " . htmlspecialchars($componenteRecibido) . "</p>";
    echo "<p><strong>Cantidad:</strong> " . $cantidad . " unidades</p>";
    echo "<p><strong>Precio Unitario:</strong> $" . number_format($precioUnitario, 2) . "</p>";
    echo "<p><strong>Subtotal:</strong> $" . number_format($subtotal, 2) . "</p>";
    if ($porcentajeDescuento > 0) {
        echo "<p class='text-danger'><strong>Descuento del (" . $porcentajeDescuento . "%):</strong> $" . number_format($descuento, 2) . "</p>";
    } else {
        echo "<p><strong>Descuento:</strong> No aplica</p>";
    }
    echo "<hr>";
    echo "<h3 class='text-success'><strong>Total a Pagar:</strong> $" . number_format($total, 2) . "</h3>";
    echo "<a href='index.html' class='btn btn-outline-success mt-3'>Realizar otra compra</a>";
    echo "</div></div></body></html>";
} else {
    // Si alguien entra directamente a procesar.php, se redirige al formulario principal
    header("Location: index.html");
    exit();
}
?>