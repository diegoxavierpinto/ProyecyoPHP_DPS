<?php
// BARRERA DE SEGURIDAD
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizador de partes y piezas de equipos de computo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Cotizador de hardware</h4>
                    </div>
                    <div class="card-body">
                        <form action="procesar.php" method="POST">
                            <div class="mb-3">
                                <label for="componente" class="form-label">Selecciona un componente:</label>
                                <select class="form-select" id="componente" name="componente" required>
                                    <option value="" disabled selected>Elija una opcion</option>
                                    <option value="procesador">Procesador Inter Core I7</option>
                                    <option value="ram">Memoria RAM 16GB DDR5</option>
                                    <option value="almacenamiento">Unidad SSD NVMe 1TB</option>
                                    <option value="mouse">Mouse Inalámbrico Logitech</option>
                                    <option value="audifonos">Audífonos Gamer Over-Ear</option>
                                    <option value="teclado">Teclado Mecánico RGB</option>
                                    <option value="monitor">Monitor 4K 27 pulgadas</option>
                                    <option value="webcam">Webcam Full HD 1080p</option>
                                    <option value="microfono">Micrófono Condensador USB</option>
                                    <option value="hub">Hub USB 3.0 7 Puertos</option>
                                    <option value="cargador">Cargador Rápido USB-C 65W</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad Requerida</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad" min="1"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Selecciona el descuento:</label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="descuento0" name="descuento" value="0" checked>
                                    <label class="form-check-label" for="descuento0">Sin descuento (0%)</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="descuento15" name="descuento" value="15">
                                    <label class="form-check-label" for="descuento15">Descuento del 15%</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="descuento20" name="descuento" value="20">
                                    <label class="form-check-label" for="descuento20">Descuento del 20%</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="descuento25" name="descuento" value="25">
                                    <label class="form-check-label" for="descuento25">Descuento del 25%</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="descuento50" name="descuento" value="50">
                                    <label class="form-check-label" for="descuento50">Descuento del 50%</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Procesar Cotización</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

