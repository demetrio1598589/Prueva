<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Control de Asistencias</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 0; background-color: #f4f4f4; }
        .header { background-color: #333; color: white; padding: 20px; }
        .container { max-width: 600px; margin: 50px auto; padding: 20px; }
        .btn { padding: 10px 20px; background-color: #5cb85c; color: white; text-decoration: none; border-radius: 4px; }
        .btn:hover { background-color: #4cae4c; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Control de Asistencias</h1>
        <p>"Registrando tu esfuerzo, construimos éxito juntos"</p>
    </div>
    
    <div class="container">
        <a href="login.php" class="btn">Iniciar Sesión</a>
    </div>
</body>
</html>
