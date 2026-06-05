<?php
//tipado estricto
declare(strict_types=1);

// 2. SEGURIDAD: Iniciar sesión y validar
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

//Verificamos los datos que llegan desde el formulario a traves del metodo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //2. RECEPECION Y CONVERSION DE LOS TIPOS DE DATOS (casteo/parseo)
    //?? por si el dato no existe
    $componenteRecibido = $_POST['componente'] ?? '';
    // Convertimos el string en un numero entero
    $cantidad = (int) ($_POST['cantidad'] ?? 0);
    //obtener el porcentaje de descuento seleccionado
    $porcentajeDescuento = (float) ($_POST['descuento'] ?? 0);

    //Estructuas de control
    //vamos a utilizar una funcion que se llama match (PHP 8.X) es un equivalente a lo que hace un switch
    $precioUnitario = match ($componenteRecibido) {
        'procesador'        => 350.50,
        'ram'               => 85.00,
        'almacenamiento'    => 160.75,
        'mouse'             => 45.00,
        'audifonos'         => 120.00,
        'teclado'           => 95.50,
        'monitor'           => 350.00,
        'webcam'            => 75.00,
        'microfono'         => 80.00,
        'hub'               => 55.00,
        'cargador'          => 65.00,
        default             => 0.00,
    };
    //cálculo matemarico con operadors y expresiones
    $subtotal = $precioUnitario * $cantidad;
    //descuento basado en el porcentaje seleccionado
    $descuento = $subtotal * ($porcentajeDescuento / 100);
    //expresion final
    $totalPagar = $subtotal - $descuento;

    //imrpmir la salida de datos utilizando html con php
    echo "<!DOCTYPE html><html lang='es'><head><meta charset='UTF-8'>";
    echo "<title>Resultado de Cotización</title>";
    echo "<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>";
    echo "</head><body class='bg-light'><div class='container mt-5'>";
    
    echo "<div class='alert alert-success shadow'>";
    echo "<h2 class='alert-heading'>Resumen de su pedido</h2>";
    echo "<hr>";
    echo "<p><strong>Componente:</strong> " . htmlspecialchars($componenteRecibido) . "</p>";
    echo "<p><strong>Cantidad:</strong> " . $cantidad . " unidades</p>";
    echo "<p><strong>Precio Unitario:</strong> $" . number_format($precioUnitario, 2) . "</p>";
    echo "<p><strong>Subtotal:</strong> $" . number_format($subtotal, 2) . "</p>";
    
    if ($porcentajeDescuento > 0) {
        echo "<p class='text-danger'><strong>Descuento (" . $porcentajeDescuento . "%):</strong> -$" . number_format($descuento, 2) . "</p>";
    }
    
    echo "<h3><strong>Total a Pagar:</strong> $" . number_format($totalPagar, 2) . "</h3>";
    echo "<a href='index.php' class='btn btn-outline-success mt-3'>Realizar otra cotización</a>";
    echo "</div></div></body></html>";

    //Toma los datos del formulario e inserta en la base de datos
    try{
    //Insercion de los datos
    require 'conexion.php';
    $stmt = $pdo->prepare("INSERT INTO cotizaciones (componente,cantidad,total) VALUES (?, ?, ?)");
    $stmt->execute([$componenteRecibido, $cantidad, $totalPagar]);
    header("Location: dashboard.php?msg=success");
    exit();
    

    }catch(PDOException $e){
        //manejo de errores
        die("<div style='backgroud: #ffcccc; padding:20px; border: 1px solid red; font-family: Arial, sans-serif;'>
        <h2 style='color: #ff0000;'>Error al guardar la cotización</h2>
        <p><strong>Mensaje de error del servidor:</strong> " . $e->getMessage() . "</p>
        
        </div>");
    }



} else {
    // redirigimos el formulario
    header("Location: index.php");
    exit();
}
?>
