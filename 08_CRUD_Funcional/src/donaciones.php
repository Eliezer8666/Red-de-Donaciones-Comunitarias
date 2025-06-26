<?php
include 'conexion.php';

// Obtener listas para selects
$usuarios = $conn->query("SELECT id, nombre FROM usuarios");
$necesidades = $conn->query("SELECT id, organizacion FROM necesidades");

// Crear
if (isset($_POST['registrar'])) {
    $id_usuario = $_POST['usuario'];
    $id_necesidad = $_POST['necesidad'];
    $fecha = $_POST['fecha'];
    $desc = $_POST['descripcion'];

    $conn->query("INSERT INTO donaciones (id_usuario, id_necesidad, fecha, descripcion) 
                  VALUES ($id_usuario, $id_necesidad, '$fecha', '$desc')");
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM donaciones WHERE id = $id");
}

$datos = $conn->query("SELECT d.id, u.nombre, n.organizacion, d.fecha, d.descripcion 
                       FROM donaciones d 
                       JOIN usuarios u ON d.id_usuario = u.id 
                       JOIN necesidades n ON d.id_necesidad = n.id");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Donaciones</title>
</head>
<body>

<h2>Registrar Donación</h2>
<form method="POST">
    <select name="usuario" required>
        <option value="">Seleccione Usuario</option>
        <?php while($u = $usuarios->fetch_assoc()): ?>
            <option value="<?= $u['id'] ?>"><?= $u['nombre'] ?></option>
        <?php endwhile; ?>
    </select>
    <select name="necesidad" required>
        <option value="">Seleccione Necesidad</option>
        <?php while($n = $necesidades->fetch_assoc()): ?>
            <option value="<?= $n['id'] ?>"><?= $n['organizacion'] ?></option>
        <?php endwhile; ?>
    </select>
    <input type="date" name="fecha" required>
    <input type="text" name="descripcion" placeholder="Descripción de la donación" required>
    <button name="registrar">Registrar</button>
</form>

<h2>Donaciones Registradas</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Donante</th><th>Organización</th><th>Fecha</th><th>Descripción</th><th>Acciones</th></tr>
    <?php while($fila = $datos->fetch_assoc()): ?>
        <tr>
            <td><?= $fila['id'] ?></td>
            <td><?= $fila['nombre'] ?></td>
            <td><?= $fila['organizacion'] ?></td>
            <td><?= $fila['fecha'] ?></td>
            <td><?= $fila['descripcion'] ?></td>
            <td><a href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar esta donación?')">Eliminar</a></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
