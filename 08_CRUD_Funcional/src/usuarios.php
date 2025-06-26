<?php
include 'conexion.php';

// Crear
if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $conn->query("INSERT INTO usuarios (nombre, correo, rol) VALUES ('$nombre', '$correo', '$rol')");
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM usuarios WHERE id = $id");
}

// Actualizar
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $rol = $_POST['rol'];

    $conn->query("UPDATE usuarios SET nombre='$nombre', correo='$correo', rol='$rol' WHERE id=$id");
}

$datos = $conn->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body>
<h2>Registro de Usuarios</h2>
<form method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="email" name="correo" placeholder="Correo" required>
    <select name="rol">
        <option>Donante</option>
        <option>Administrador</option>
    </select>
    <button name="registrar">Registrar</button>
</form>

<h2>Lista de Usuarios</h2>
<table border="1" cellpadding="6">
    <tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th><th>Acciones</th></tr>
    <?php while ($fila = $datos->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <td><?= $fila['id'] ?><input type="hidden" name="id" value="<?= $fila['id'] ?>"></td>
                <td><input name="nombre" value="<?= $fila['nombre'] ?>"></td>
                <td><input name="correo" value="<?= $fila['correo'] ?>"></td>
                <td>
                    <select name="rol">
                        <option <?= $fila['rol']=='Donante'?'selected':'' ?>>Donante</option>
                        <option <?= $fila['rol']=='Administrador'?'selected':'' ?>>Administrador</option>
                    </select>
                </td>
                <td>
                    <button name="actualizar">Actualizar</button>
                    <a href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
