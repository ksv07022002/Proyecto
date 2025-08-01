<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    if (!$correo || !$contrasena) {
        header('Location: index.php?error=empty');
        exit;
    }

    $archivoUsuarios = 'usuarios.json';

    if (!file_exists($archivoUsuarios)) {
        header('Location: index.php?error=nousuarios');
        exit;
    }

    $usuarios = json_decode(file_get_contents($archivoUsuarios), true);

    $usuarioValido = null;
    foreach ($usuarios as $usuario) {
        if ($usuario['correo'] === $correo && $usuario['contrasena'] === $contrasena) {
            $usuarioValido = $usuario;
            break;
        }
    }

    if (!$usuarioValido) {
        header('Location: index.php?error=incorrecto');
        exit;
    }

    $_SESSION['correo'] = $usuarioValido['correo'];

    header("Location: dashboard.php");
    exit;
}
?>