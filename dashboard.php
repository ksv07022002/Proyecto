<?php
session_start();

if (!isset($_SESSION['correo'])) {
    header('Location: index.php');
    exit;
}

$archivo = 'libros_' . md5($_SESSION['correo']) . '.json';
$libros = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];

// Agregar libro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar'])) {
    $nuevoLibro = [
        'titulo' => trim($_POST['titulo']),
        'autor' => trim($_POST['autor'])
    ];
    $libros[] = $nuevoLibro;
    file_put_contents($archivo, json_encode($libros, JSON_PRETTY_PRINT));
    header('Location: dashboard.php');
    exit;
}

// Editar libro
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar_edicion'])) {
    $i = (int) $_POST['indice'];
    $libros[$i] = [
        'titulo' => trim($_POST['titulo']),
        'autor' => trim($_POST['autor'])
    ];
    file_put_contents($archivo, json_encode($libros, JSON_PRETTY_PRINT));
    header('Location: dashboard.php');
    exit;
}

// Eliminar libro
if (isset($_GET['eliminar'])) {
    $i = (int) $_GET['eliminar'];
    unset($libros[$i]);
    $libros = array_values($libros); // Reindexar
    file_put_contents($archivo, json_encode($libros, JSON_PRETTY_PRINT));
    header('Location: dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">📚 Inventario de Libros</a>
        <div class="d-flex">
            <a href="logout.php" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
        </div>
    </div>
</nav>

<div class="container">

    <!-- Formulario agregar libro -->
    <h4 class="mt-4">Agregar nuevo libro</h4>
    <form method="POST" class="row g-3">
        <div class="col-md-5">
            <input type="text" name="titulo" class="form-control" placeholder="Título" required>
        </div>
        <div class="col-md-5">
            <input type="text" name="autor" class="form-control" placeholder="Autor" required>
        </div>
        <div class="col-md-2">
            <button type="submit" name="agregar" class="btn btn-primary w-100">Agregar</button>
        </div>
    </form>

    <!-- Tabla de libros -->
    <h4 class="mt-5">Mis Libros</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($libros as $index => $libro): ?>
                <?php if (isset($_GET['editar']) && $_GET['editar'] == $index): ?>
                    <!-- Formulario edición -->
                    <tr>
                        <form method="POST">
                            <td><input type="text" name="titulo" value="<?= htmlspecialchars($libro['titulo']) ?>" class="form-control" required></td>
                            <td><input type="text" name="autor" value="<?= htmlspecialchars($libro['autor']) ?>" class="form-control" required></td>
                            <td>
                                <input type="hidden" name="indice" value="<?= $index ?>">
                                <button type="submit" name="guardar_edicion" class="btn btn-success btn-sm">Guardar</button>
                                <a href="dashboard.php" class="btn btn-secondary btn-sm">Cancelar</a>
                            </td>
                        </form>
                    </tr>
                <?php else: ?>
                    <!-- Fila normal -->
                    <tr>
                        <td><?= htmlspecialchars($libro['titulo']) ?></td>
                        <td><?= htmlspecialchars($libro['autor']) ?></td>
                        <td>
                            <a href="dashboard.php?editar=<?= $index ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="dashboard.php?eliminar=<?= $index ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este libro?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
</body>
</html>