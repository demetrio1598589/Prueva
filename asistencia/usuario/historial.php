<?php
require '../../includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'usuario') {
    header("Location: ../../login.php");
    exit();
}

$stmt = $conn->prepare("SELECT fecha, hora FROM asistencias WHERE usuario_id = :usuario_id ORDER BY fecha DESC, hora DESC");
$stmt->bindParam(':usuario_id', $_SESSION['user_id']);
$stmt->execute();
$asistencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../../includes/header.php'; ?>

    <h2>Tu Historial de Asistencias</h2>
    
    <?php if(count($asistencias) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($asistencias as $asistencia): ?>
                    <tr>
                        <td><?php echo $asistencia['fecha']; ?></td>
                        <td><?php echo $asistencia['hora']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay registros de asistencia.</p>
    <?php endif; ?>

<?php include '../../includes/footer.php'; ?>
