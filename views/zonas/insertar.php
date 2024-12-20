<?php
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');
echo '<link rel="stylesheet" href="stylezona.css">';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $letra = $_POST['letra'];
    $tipo_barco = $_POST['tipo_barco'];
    $profundidad = $_POST['profundidad'];
    $anchura = $_POST['anchura'];

    // Insertar en la base de datos
    $query = "INSERT INTO zonas (letra, tipo_barco, profundidad, anchura)
              VALUES ('$letra', '$tipo_barco', '$profundidad', '$anchura')";
    $result = pg_query($conn, $query);

    if ($result) {
        echo "<p>Zona agregada con éxito.</p>";
    } else {
        echo "<p>Error al agregar zona: " . pg_last_error($conn) . "</p>";
    }
}
?>

<div class="container">
    <h1>Agregar Zona</h1>
    <form method="POST">
        <label for="letra">Letra de la Zona:</label>
        <input type="text" id="letra" name="letra" required maxlength="1"><br>

        <label for="tipo_barco">Tipo de Barco:</label>
        <input type="text" id="tipo_barco" name="tipo_barco" required><br>

        <label for="profundidad">Profundidad:</label>
        <input type="number" id="profundidad" name="profundidad" required><br>

        <label for="anchura">Anchura:</label>
        <input type="number" id="anchura" name="anchura" required><br>

        <button type="submit">Agregar Zona</button>
    </form>
</div>
