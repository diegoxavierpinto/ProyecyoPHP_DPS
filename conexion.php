<?php

declare(strict_types=1);
try {

    $pdo = new PDO('sqlite:sistemadb.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //CREAMOS LA TABLA PARA LAS COTIZACIONES
    $pdo->exec("CREATE TABLE IF NOT EXISTS cotizaciones (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        componente TEXT NOT NULL,
        cantidad INTEGER NOT NULL,
        total REAL NOT NULL,
        fecha DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    //2 tabla USUARIOS (Administrador)
    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL
    )");

    //INSERCION DE UN USUARIO SI LA TABLA ESTA VACIA
    //LAS CONTRASEÑAS NO SE GUARDAN EN TEXTOS PLANOS SINO SE UTILIZA ALGUN TIPO DE ALGORITMO DE ENCRITACION MENOS MD5
    $stmt = $pdo->query("SELECT COUNT(*) FROM usuarios");
    if ($stmt->fetchColumn() == 0) {
        $hash = password_hash('ingenieria123', PASSWORD_DEFAULT);
        $pdo->exec("INSERT INTO usuarios (username, password) VALUES ('admin', '$hash')");
    }
} catch (PDOException $e) {
    die("Error de conexion" . $e->getMessage());
}
