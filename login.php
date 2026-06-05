<?php
// login.php
session_start();

// Si ya tiene sesión, lo redirigimos al CRUD
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: index.php");
    exit();
}

$error = '';

// Procesamiento del formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'conexion.php';
    
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Buscamos al usuario en la BD
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->execute([$user]);
    $usuarioDB = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verificamos la contraseña contra el Hash seguro
    if ($usuarioDB && password_verify($pass, $usuarioDB['password'])) {
        // Credenciales correctas: Creamos la credencial de sesión (El "Gafete")
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['username'] = $usuarioDB['username'];
        header("Location: index.php");
        exit();
    } else {
        $error = "Credenciales incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="card shadow p-4" style="width: 350px;">
        <h3 class="text-center mb-4">Acceso Seguro</h3>
        
        <?php if($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label>Usuario</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>
</body>
</html>