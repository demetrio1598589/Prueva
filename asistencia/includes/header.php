<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Asistencia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Control de Asistencia</h1>
        <p>Sistema de registro de asistencia personalizado</p>
        <?php if(isset($_SESSION['user_name'])): ?>
            <div class="user-info">
                Bienvenido, <?php echo $_SESSION['user_name']; ?> | 
                <a href="../logout.php">Cerrar sesión</a>
            </div>
        <?php endif; ?>
    </header>
    <nav>
        <?php if(isset($_SESSION['user_name'])): ?>
            <a href="<?php echo ($_SESSION['user_role'] == 'admin' ? 'admin/dashboard.php' : 'usuario/dashboard.php'); ?>">Inicio</a>
            <a href="<?php echo ($_SESSION['user_role'] == 'admin' ? 'admin/historial.php' : 'usuario/historial.php'); ?>">Historial</a>
        <?php else: ?>
            <a href="../index.php">Inicio</a>
            <a href="../login.php">Ingresar</a>
        <?php endif; ?>
    </nav>
    <main></main>