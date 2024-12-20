<?php
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');
echo '<link rel="stylesheet" href="styleemple.css">';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $especialidad = $_POST['especialidad'];

    // Insertar en la base de datos
    $query = "INSERT INTO empleados (nombre, direccion, telefono, especialidad)
              VALUES ('$nombre', '$direccion', '$telefono', '$especialidad')";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "<p>Empleado agregado con éxito.</p>";
    } else {
        echo "<p>Error al agregar empleado: " . pg_last_error($conn) . "</p>";
    }
}
?>

<div class="container">
    <h1>Agregar Nuevo Empleado</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion"><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono"><br>

        <label for="especialidad">Especialidad:</label>
        <input type="text" id="especialidad" name="especialidad"><br>

        <button type="submit">Agregar Empleado</button>
    </form>
</div>
