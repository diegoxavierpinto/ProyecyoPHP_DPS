<?php

declare(strict_types=1);

session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

require 'conexion.php';

//Logica de las funciones del formulario, ELIMINAR Y LEER LOS DATOS

if (isset($_GET['eliminar'])) {
    $idEliminar = (int) $_GET['eliminar'];
    $stmt = $pdo->prepare("DELETE FROM cotizaciones WHERE id = ?");
    $stmt->execute([$idEliminar]);
    header("Location: dashboard.php?msg=Eliminación exitosa");
    exit();
}

//Logica para leer los datos de la tabla cotizaciones
$stmt = $pdo->query("SELECT * FROM cotizaciones ORDER BY id DESC");
$cotizaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
 
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Panel de Administración</a>
        <div>   
            <span class="navbar-text me-3">Usuario: <?= htmlspecialchars($_SESSION['username']) ?></span>
            <a href="index.php" class="btn btn-primary btn-sm me-2">Volver al Cotizador</a>
            <a href="logout.php" class="btn btn-outline-danger btn-sm">Cerrar Sesión</a>
        </div>
        </div>
    </nav>
    <div class="container">
        <h2 class="mb-4">Registro Histórico de Cotizaciones</h2>
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'Eliminación exitosa'): ?>
            <div class="alert alert-warning">Registro eliminado exitosamente.</div>
        <?php endif; ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Componente</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cotizaciones as $cot): ?>
                    <tr>
                        <td><?= $cot['id'] ?></td>
                        <td><?= htmlspecialchars($cot['componente']) ?></td>
                        <td><?= $cot['cantidad'] ?></td>
                        <td>$<?= number_format($cot['total'], 2) ?></td>
                        <td><?= $cot['fecha'] ?></td>
                        <td>
                            <a href="?eliminar=<?= $cot['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Confirma que desea eliminar esta cotización?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <!-- Si no hay cotizaciones, mostrar un mensaje -->
                <?php if (empty($cotizaciones)): ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay cotizaciones registradas.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>        
                
</body>
</html>

