<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST['correo'];

    // Buscar usuario por correo
    $sql = "SELECT id FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($usuario_id);
        $stmt->fetch();

        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        $sql_insert = "INSERT INTO asistencias (usuario_id, fecha, hora) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("iss", $usuario_id, $fecha, $hora);
        $stmt_insert->execute();

        echo "<p>✅ Asistencia registrada correctamente.</p>";
    } else {
        echo "<p>❌ Correo no registrado.</p>";
    }
}
?>
