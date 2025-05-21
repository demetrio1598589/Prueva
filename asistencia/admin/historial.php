<?php
require '../../includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

$stmt = $conn->query("SELECT u.nombre, a.fecha, a.hora FROM asistencias a JOIN usuarios u ON a.usuario_id = u.id ORDER BY a.fecha DESC, a.hora DESC");
$asistencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../../includes/header.php'; ?>

    <h2>Historial Completo de Asistencias</h2>
    
    <?php if(count($asistencias) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($asistencias as $asistencia): ?>
                    <tr>
                        <td><?php echo $asistencia['nombre']; ?></td>
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
