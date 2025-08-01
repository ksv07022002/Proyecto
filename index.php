<?php 
session_start();
$tabActiva = isset($_SESSION['tab_activa']) ? $_SESSION['tab_activa'] : 'login';
unset($_SESSION['tab_activa']); // Se borra para que no afecte recargas futuras
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventario de Libros Personales</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    <?php if (isset($_SESSION['tab_activa'])): ?>
      let tabActiva = "<?= $_SESSION['tab_activa']; ?>";
      let trigger = new bootstrap.Tab(document.querySelector(`#myTabs a[href="#${tabActiva}"]`));
      trigger.show();
      <?php unset($_SESSION['tab_activa']); ?>
    <?php endif; ?>
  });
</script>


<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <span class="navbar-brand">📚 Mi biblioteca personal</span>
    </div>
  </nav>

  <div class="container mt-5">
        <div class="row justify-content-center text-center">
            <div class="col-md-8">
                <h1 class="mb-4">Bienvenido a tu Inventario de Libros</h1>
                <p class="lead">
                    Registra tus libros personales, mantén un control de tu colección y accede desde cualquier lugar.
                </p>
            </div>
        </div>
    </div>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">

      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo $tabActiva === 'login' ? 'active' : ''; ?>" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Iniciar sesión</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link <?php echo $tabActiva === 'register' ? 'active' : ''; ?>" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Registrarse</button>
        </li>
        </ul>

        <div class="tab-content" id="myTabContent">
          
          <!-- Formulario de Login -->
 <div class="tab-pane fade <?php echo $tabActiva === 'login' ? 'show active' : ''; ?>" id="login" role="tabpanel">
  <form action="login.php" method="POST" class="card card-body shadow">
    <h4 class="mb-3">Iniciar Sesión</h4>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger">
        <?php
          switch ($_GET['error']) {
            case 'empty': echo 'Debe completar todos los campos.'; break;
            case 'incorrecto': echo 'Correo o contraseña incorrectos.'; break;
            case 'nousuarios': echo 'No hay usuarios registrados.'; break;
            default: echo 'Ocurrió un error.';
          }
        ?>
      </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['exito_registro'])): ?>
      <div class="alert alert-success">
        <?= $_SESSION['exito_registro']; unset($_SESSION['exito_registro']); ?>
      </div>
    <?php endif; ?>

    <div class="mb-3">
      <label for="loginCorreo" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="loginCorreo" name="correo" required>
    </div>
    <div class="mb-3">
      <label for="loginContrasena" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="loginContrasena" name="contrasena" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Entrar</button>
  </form>
</div>


          
          <!-- Formulario de Registro -->
<div class="tab-pane fade <?php echo $tabActiva === 'register' ? 'show active' : ''; ?>" id="register" role="tabpanel">
  <form action="registro.php" method="POST" class="card card-body shadow">
    <h4 class="mb-3">Registrarse</h4>

    <?php if (isset($_SESSION['error_registro'])): ?>
      <div class="alert alert-danger">
        <?= $_SESSION['error_registro']; unset($_SESSION['error_registro']); ?>
      </div>
    <?php endif; ?>

    <div class="mb-3">
      <label for="registroCorreo" class="form-label">Correo electrónico</label>
      <input type="email" class="form-control" id="registroCorreo" name="correo" required>
    </div>
    <div class="mb-3">
      <label for="registroContrasena" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="registroContrasena" name="contrasena" required>
    </div>
    <button type="submit" class="btn btn-success w-100">Registrarse</button>
  </form>
</div>


         


      </div>
    </div>
  </div>
  <footer class="text-center mt-5 text-muted">
        <p>&copy; <?php echo date("Y"); ?> Mi Biblioteca Personal. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>