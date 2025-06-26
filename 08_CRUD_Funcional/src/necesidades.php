<?php
include 'conexion.php';

// Crear (Insertar)
if (isset($_POST['registrar'])) {
    $org = $_POST['organizacion'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO necesidades (organizacion, tipo, descripcion, estado)
            VALUES ('$org', '$tipo', '$descripcion', 'Pendiente')";
    $conn->query($sql);
}

// Eliminar
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $conn->query("DELETE FROM necesidades WHERE id = $id");
}

// Leer (Select)
$datos = $conn->query("SELECT * FROM necesidades");

// Editar (Actualizar)
if (isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $org = $_POST['organizacion'];
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $estado = $_POST['estado'];

    $conn->query("UPDATE necesidades 
                  SET organizacion='$org', tipo='$tipo', descripcion='$descripcion', estado='$estado'
                  WHERE id=$id");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Necesidades</title>
    <style>
        table, th, td { border: 1px solid black; border-collapse: collapse; padding: 8px; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>

<h2>Registrar Nueva Necesidad</h2>
<form method="POST">
    <input type="text" name="organizacion" placeholder="Organización" required><br>
    <select name="tipo">
        <option>Alimentos</option>
        <option>Ropa</option>
        <option>Materiales</option>
    </select><br>
    <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
    <button type="submit" name="registrar">Registrar</button>
</form>

<h2>Lista de Necesidades</h2>
<table>
    <tr>
        <th>ID</th><th>Organización</th><th>Tipo</th><th>Descripción</th><th>Estado</th><th>Acciones</th>
    </tr>
    <?php while ($fila = $datos->fetch_assoc()): ?>
        <tr>
            <form method="POST">
                <td><?= $fila['id'] ?><input type="hidden" name="id" value="<?= $fila['id'] ?>"></td>
                <td><input type="text" name="organizacion" value="<?= $fila['organizacion'] ?>"></td>
                <td>
                    <select name="tipo">
                        <option <?= $fila['tipo'] == 'Alimentos' ? 'selected' : '' ?>>Alimentos</option>
                        <option <?= $fila['tipo'] == 'Ropa' ? 'selected' : '' ?>>Ropa</option>
                        <option <?= $fila['tipo'] == 'Materiales' ? 'selected' : '' ?>>Materiales</option>
                    </select>
                </td>
                <td><input type="text" name="descripcion" value="<?= $fila['descripcion'] ?>"></td>
                <td><input type="text" name="estado" value="<?= $fila['estado'] ?>"></td>
                <td>
                    <button type="submit" name="actualizar">Actualizar</button>
                    <a href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                </td>
            </form>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>