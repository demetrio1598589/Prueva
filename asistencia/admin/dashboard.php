<?php
require '../../includes/db.php';

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../../login.php");
    exit();
}

$mensaje = '';
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['marcar_asistencia'])) {
    $usuario_id = $_POST['usuario_id'];
    if(registrarAsistencia($conn, $usuario_id)) {
        $mensaje = "Asistencia registrada con éxito para el usuario seleccionado";
    } else {
        $mensaje = "El usuario ya registró asistencia hoy";
    }
}

// Obtener lista de usuarios
$stmt = $conn->query("SELECT id, nombre FROM usuarios ORDER BY nombre");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener asistencias de hoy
$fecha_hoy = date('Y-m-d');
$stmt = $conn->prepare("SELECT u.nombre, a.hora FROM asistencias a JOIN usuarios u ON a.usuario_id = u.id WHERE a.fecha = :fecha ORDER BY a.hora");
$stmt->bindParam(':fecha', $fecha_hoy);
$stmt->execute();
$asistencias_hoy = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../../includes/header.php'; ?>

    <h2>Panel de Administración</h2>
    
    <?php if($mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    
    <section>
        <h3>Marcar Asistencia para Usuario</h3>
        <form method="post">
            <div>
                <label for="usuario_id">Seleccionar Usuario:</label>
                <select id="usuario_id" name="usuario_id" required>
                    <?php foreach($usuarios as $usuario): ?>
                        <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nombre']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="marcar_asistencia">Marcar Asistencia</button>
        </form>
    </section>
    
    <section>
        <h3>Asistencias de Hoy</h3>
        <?php if(count($asistencias_hoy) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Hora</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($asistencias_hoy as $asistencia): ?>
                        <tr>
                            <td><?php echo $asistencia['nombre']; ?></td>
                            <td><?php echo $asistencia['hora']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay asistencias registradas hoy.</p>
        <?php endif; ?>
    </section>

<?php include '../../includes/footer.php'; ?>
