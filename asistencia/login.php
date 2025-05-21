<?php
require 'includes/db.php';

if(isset($_SESSION['user_id'])) {
    header("Location: " . ($_SESSION['user_role'] == 'admin' ? 'admin/dashboard.php' : 'usuario/dashboard.php'));
    exit();
}

$error = '';
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $password = trim($_POST['password']);
    
    if(verificarLogin($conn, $usuario, $password)) {
        header("Location: " . ($_SESSION['user_role'] == 'admin' ? 'admin/dashboard.php' : 'usuario/dashboard.php'));
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<?php include 'includes/header.php'; ?>

    <form action="login.php" method="post">
        <h2>Iniciar Sesión</h2>
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        <div>
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Ingresar</button>
    </form>

<?php include 'includes/footer.php'; ?>
