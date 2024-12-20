<?php
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');
echo '<link rel="stylesheet" href="stylesoc.css">';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $ci = $_POST['ci'];
    $telefono = $_POST['telefono'];
    $fecha_ingreso = $_POST['fecha_ingreso'];

    // Insertar en la base de datos
    $query = "INSERT INTO socios (nombre, direccion, ci, telefono, fecha_ingreso)
              VALUES ('$nombre', '$direccion', '$ci', '$telefono', '$fecha_ingreso')";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "<p>Socio agregado con éxito.</p>";
        // Mostrar botón de redirección
        echo "<a href='socios.php'><button>Volver a la lista de socios</button></a>";
    } else {
        echo "<p>Error al agregar socio: " . pg_last_error($conn) . "</p>";
    }
}
?>

<div class="container">
    <h1>Agregar Nuevo Socio</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required><br>

        <label for="ci">Cédula de Identidad:</label>
        <input type="text" id="ci" name="ci" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" required><br>

        <label for="fecha_ingreso">Fecha de Ingreso:</label>
        <input type="date" id="fecha_ingreso" name="fecha_ingreso" required><br>

        <button type="submit">Agregar Socio</button>
    </form>
</div>
