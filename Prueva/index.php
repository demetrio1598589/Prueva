<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Registrar asistencia
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_asistencia'])) {
    $usuario_id = $_SESSION['user_id'];
    $fecha = date("Y-m-d");
    $hora = date("H:i:s");

    $sql = "INSERT INTO asistencias (usuario_id, fecha, hora) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $usuario_id, $fecha, $hora);
    $stmt->execute();
    $mensaje = "Asistencia registrada correctamente";
}

// Obtener historial de asistencias
if ($_SESSION['rol'] == 'admin') {
    $sql_historial = "SELECT u.nombre, a.fecha, a.hora 
                      FROM asistencias a 
                      JOIN usuarios u ON a.usuario_id = u.id 
                      ORDER BY a.fecha DESC, a.hora DESC";
} else {
    $sql_historial = "SELECT u.nombre, a.fecha, a.hora 
                      FROM asistencias a 
                      JOIN usuarios u ON a.usuario_id = u.id 
                      WHERE a.usuario_id = ? 
                      ORDER BY a.fecha DESC, a.hora DESC";
}
$stmt_historial = $conn->prepare($sql_historial);
if ($_SESSION['rol'] != 'admin') {
    $stmt_historial->bind_param("i", $_SESSION['user_id']);
}
$stmt_historial->execute();
$historial = $stmt_historial->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Asistencia</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4; }
        .header { background-color: #333; color: white; padding: 10px 20px; display: flex; justify-content: space-between; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 5px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .welcome { margin-bottom: 20px; }
        .panel { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        .success { color: green; margin: 10px 0; }
        .btn { padding: 8px 15px; background-color: #5cb85c; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .btn:hover { background-color: #4cae4c; }
        .logout { color: white; text-decoration: none; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Sistema de Asistencia</h2>
        <a href="logout.php" class="logout">Cerrar Sesión</a>
    </div>

    <div class="container">
        <div class="welcome">
            <h3>Bienvenido, <?php echo $_SESSION['nombre']; ?></h3>
            <p>Rol: <?php echo ucfirst($_SESSION['rol']); ?></p>
        </div>

        <div class="panel">
            <h3>Registrar Asistencia</h3>
            <form method="POST" action="">
                <button type="submit" name="registrar_asistencia" class="btn">Registrar Mi Asistencia</button>
            </form>
            <?php if (isset($mensaje)): ?>
                <p class="success"><?php echo $mensaje; ?></p>
            <?php endif; ?>
        </div>

        <div class="panel">
            <h3>Historial de Asistencias</h3>
            <table>
                <tr>
                    <th>Nombre</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
                <?php while ($row = $historial->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <?php if ($_SESSION['rol'] == 'admin'): ?>
        <div class="panel">
            <h3>Administrar Usuarios</h3>
            <a href="agregar_usuario.php" class="btn">Agregar Nuevo Usuario</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>