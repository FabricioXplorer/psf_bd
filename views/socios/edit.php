<!-- views/socios/editar.php -->
<?php
include('../config/db.php');  // Conexión a la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Obtener los datos actuales del socio
    $query = "SELECT * FROM socios WHERE id_socio = '$id'";
    $result = pg_query($conn, $query);
    $socio = pg_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Actualizar los datos del socio
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $ci = $_POST['ci'];
    $telefono = $_POST['telefono'];
    $fecha_ingreso = $_POST['fecha_ingreso'];

    $query = "UPDATE socios SET nombre='$nombre', direccion='$direccion', ci='$ci', telefono='$telefono', fecha_ingreso='$fecha_ingreso' WHERE id_socio='$id'";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "<p>Socio actualizado con éxito.</p>";
    } else {
        echo "<p>Error al actualizar socio: " . pg_last_error($conn) . "</p>";
    }
}
?>

<div class="container">
    <h1>Editar Socio</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $socio['nombre']; ?>" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" value="<?php echo $socio['direccion']; ?>" required><br>

        <label for="ci">Cédula de Identidad:</label>
        <input type="text" id="ci" name="ci" value="<?php echo $socio['ci']; ?>" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" value="<?php echo $socio['telefono']; ?>" required><br>

        <label for="fecha_ingreso">Fecha de Ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $socio['fecha_ingreso']; ?>" required><br>

        <button type="submit">Actualizar Socio</button>
    </form>
</div>
