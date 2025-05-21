<?php
session_start();

$host = 'localhost';
$dbname = 'asistencia_db';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

function verificarLogin($conn, $usuario, $password) {
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = :usuario");
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();
    
    if($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre'];
            $_SESSION['user_role'] = $user['rol'];
            return true;
        }
    }
    return false;
}

function registrarAsistencia($conn, $usuario_id) {
    $fecha = date('Y-m-d');
    $hora = date('H:i:s');
    
    // Verificar si ya registró asistencia hoy
    $stmt = $conn->prepare("SELECT id FROM asistencias WHERE usuario_id = :usuario_id AND fecha = :fecha");
    $stmt->bindParam(':usuario_id', $usuario_id);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->execute();
    
    if($stmt->rowCount() == 0) {
        $insert = $conn->prepare("INSERT INTO asistencias (usuario_id, fecha, hora) VALUES (:usuario_id, :fecha, :hora)");
        $insert->bindParam(':usuario_id', $usuario_id);
        $insert->bindParam(':fecha', $fecha);
        $insert->bindParam(':hora', $hora);
        return $insert->execute();
    }
    return false;
}
?>
