<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    if (!$correo || !$contrasena) {
        $_SESSION['error_registro'] = 'Debe completar todos los campos.';
        header('Location: index.php#register');
        exit;
    }

    $archivoUsuarios = 'usuarios.json';
    $usuarios = [];

    if (file_exists($archivoUsuarios)) {
        $contenido = file_get_contents($archivoUsuarios);
        $usuarios = json_decode($contenido, true);
    }

    // Verificar si ya existe el correo
    foreach ($usuarios as $usuario) {
        if ($usuario['correo'] === $correo) {
            $_SESSION['error_registro'] = 'Este correo ya está registrado.';
            header('Location: index.php#register');
            exit;
        }
    }

    // Agregar nuevo usuario
    $usuarios[] = [
        'correo' => $correo,
        'contrasena' => $contrasena
    ];

    file_put_contents($archivoUsuarios, json_encode($usuarios, JSON_PRETTY_PRINT));

    $_SESSION['exito_registro'] = 'Registro exitoso. Ahora puede iniciar sesión.';
    header('Location: index.php#login');
    exit;
}
?>