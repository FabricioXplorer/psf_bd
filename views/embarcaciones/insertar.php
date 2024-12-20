<?php
// Incluir la conexión a la base de datos
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');
echo '<link rel="stylesheet" href="styleemba.css">';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $dimensiones = $_POST['dimensiones'];
    $id_socio = $_POST['id_socio'];

    // Insertar los datos en la tabla embarcaciones
    $query = "
        INSERT INTO embarcaciones (nombre, tipo, dimensiones, id_socio)
        VALUES ('$nombre', '$tipo', '$dimensiones', $id_socio)
    ";

    // Ejecutar la consulta
    $result = pg_query($conn, $query);

    // Verificar si la inserción fue exitosa
    if ($result) {
        echo "<p class='success-message'>Embarcación insertada correctamente.</p>";
    } else {
        echo "<p class='error-message'>Error al insertar la embarcación.</p>";
    }
}
?>


    <div class="container">
        <h1>Agregar Nueva Embarcación</h1>

        <form action="insertar.php" method="POST" class="form">
            <!-- Campo para el nombre de la embarcación -->
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre de la Embarcación:</label>
                <input type="text" id="nombre" name="nombre" class="form-input" required maxlength="100">
            </div>

            <!-- Campo para el tipo de la embarcación -->
            <div class="form-group">
                <label for="tipo" class="form-label">Tipo de Embarcación:</label>
                <input type="text" id="tipo" name="tipo" class="form-input" required maxlength="50">
            </div>

            <!-- Campo para las dimensiones de la embarcación -->
            <div class="form-group">
                <label for="dimensiones" class="form-label">Dimensiones:</label>
                <input type="text" id="dimensiones" name="dimensiones" class="form-input" maxlength="50">
            </div>

            <!-- Campo para seleccionar el socio asociado a la embarcación -->
            <div class="form-group">
                <label for="id_socio" class="form-label">Socio:</label>
                <select id="id_socio" name="id_socio" class="form-input" required>
                    <?php
                    // Consultar los socios disponibles para el select
                    $query_socios = "SELECT id_socio, nombre FROM socios ORDER BY nombre";
                    $result_socios = pg_query($conn, $query_socios);

                    if ($result_socios) {
                        while ($row = pg_fetch_assoc($result_socios)) {
                            echo "<option value='" . $row['id_socio'] . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay socios disponibles</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Botón para enviar el formulario -->
            <button type="submit" class="form-button">Agregar Embarcación</button>
        </form>
    </div>

