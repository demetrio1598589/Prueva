<?php
require '../../includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'usuario') {
    header("Location: ../../login.php");
    exit();
}

$mensaje = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marcar_asistencia'])) {
    if(registrarAsistencia($conn, $_SESSION['user_id'])) {
        $mensaje = "Asistencia registrada con éxito";
    } else {
        $mensaje = "Ya registraste tu asistencia hoy";
    }
}

// Verificar si ya marcó asistencia hoy
$fecha_hoy = date('Y-m-d');
$stmt = $conn->prepare("SELECT id FROM asistencias WHERE usuario_id = :usuario_id AND fecha = :fecha");
$stmt->bindParam(':usuario_id', $_SESSION['user_id']);
$stmt->bindParam(':fecha', $fecha_hoy);
$stmt->execute();
$asistencia_hoy = $stmt->rowCount() > 0;
?>

<?php include '../../includes/header.php'; ?>

    <h2>Panel de Usuario</h2>
    
    <?php if($mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <section>
        <h3>Marcar Asistencia</h3>
        <?php if($asistencia_hoy): ?>
            <p>Ya registraste tu asistencia hoy. Gracias!</p>
        <?php else: ?>
            <form method="post">
                <button type="submit" name="marcar_asistencia">Marcar Asistencia</button>
            </form>
        <?php endif; ?>
    </section>
    
    <section>
        <h3>Tu Asistencia de Hoy</h3>
        <?php if($asistencia_hoy): ?>
            <?php
            $stmt = $conn->prepare("SELECT fecha, hora FROM asistencias WHERE usuario_id = :usuario_id AND fecha = :fecha");
            $stmt->bindParam(':usuario_id', $_SESSION['user_id']);
            $stmt->bindParam(':fecha', $fecha_hoy);
            $stmt->execute();
            $asistencia = $stmt->fetch(PDO::FETCH_ASSOC);
            ?>
            <p>Fecha: <?php echo $asistencia['fecha']; ?></p>
            <p>Hora: <?php echo $asistencia['hora']; ?></p>
        <?php else: ?>
            <p>Aún no has registrado asistencia hoy.</p>
        <?php endif; ?>
    </section>

<?php include '../../includes/footer.php'; ?>