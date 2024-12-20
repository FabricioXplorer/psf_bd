<?php
include($_SERVER['DOCUMENT_ROOT'] . '/psf_bd/config/db.php');
echo '<link rel="stylesheet" href="estyleamarres.css">';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $zona = isset($_POST['zona']) ? trim($_POST['zona']) : '';
    $numero = isset($_POST['numero']) ? trim($_POST['numero']) : '';
    $ultima_lectura_agua = isset($_POST['ultima_lectura_agua']) ? trim($_POST['ultima_lectura_agua']) : null;
    $ultima_lectura_luz = isset($_POST['ultima_lectura_luz']) ? trim($_POST['ultima_lectura_luz']) : null;
    $matricula_embarcacion = isset($_POST['matricula_embarcacion']) ? trim($_POST['matricula_embarcacion']) : '';
    $fecha_asignacion = isset($_POST['fecha_asignacion']) ? $_POST['fecha_asignacion'] : '';

    // Validación de los campos requeridos
    if (empty($zona) || empty($numero) || empty($matricula_embarcacion) || empty($fecha_asignacion)) {
        echo "<p class='error-message'>Todos los campos son obligatorios.</p>";
    } else {
        // Validar que la zona existe en la tabla zonas (revisar la clave foránea)
        $query_zona = "SELECT letra FROM zonas WHERE letra = '$zona'";
        $result_zona = pg_query($conn, $query_zona);

        if (pg_num_rows($result_zona) == 0) {
            echo "<p class='error-message'>La zona ingresada no existe en la tabla zonas.</p>";
        } else {
            // Insertar en la base de datos
            $query = "INSERT INTO amarres (zona, numero, ultima_lectura_agua, ultima_lectura_luz, matricula_embarcacion, fecha_asignacion) 
                      VALUES ('$zona', '$numero', '$ultima_lectura_agua', '$ultima_lectura_luz', '$matricula_embarcacion', '$fecha_asignacion')";
            $result = pg_query($conn, $query);

            if ($result) {
                echo "<p class='success-message'>Amarre insertado correctamente.</p>";
            } else {
                echo "<p class='error-message'>Error al insertar el amarre.</p>";
            }
        }
    }
}
?>

<div class="container">
    <h1 class="form-title">Agregar Nuevo Amarre</h1>
    
    <form action="insertar.php" method="POST" class="form">
        <div class="form-group">
            <label for="zona" class="form-label">Zona:</label>
            <select id="zona" name="zona" class="form-input" required>
                <option value="">Seleccione una zona</option>
                <?php
                // Consultar las zonas disponibles para el select
                $query_zonas = "SELECT letra FROM zonas ORDER BY letra";
                $result_zonas = pg_query($conn, $query_zonas);

                if ($result_zonas) {
                    while ($row = pg_fetch_assoc($result_zonas)) {
                        echo "<option value='" . $row['letra'] . "'>" . htmlspecialchars($row['letra']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay zonas disponibles</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="numero" class="form-label">Número de Amarre:</label>
            <input type="number" id="numero" name="numero" class="form-input" required>
        </div>
        
        <div class="form-group">
            <label for="ultima_lectura_agua" class="form-label">Última Lectura de Agua:</label>
            <input type="number" id="ultima_lectura_agua" name="ultima_lectura_agua" class="form-input" step="0.01">
        </div>
        
        <div class="form-group">
            <label for="ultima_lectura_luz" class="form-label">Última Lectura de Luz:</label>
            <input type="number" id="ultima_lectura_luz" name="ultima_lectura_luz" class="form-input" step="0.01">
        </div>
        
        <div class="form-group">
            <label for="matricula_embarcacion" class="form-label">Matrícula de la Embarcación:</label>
            <select id="matricula_embarcacion" name="matricula_embarcacion" class="form-input" required>
                <?php
                // Consultar las embarcaciones disponibles para el select
                $query_embarcaciones = "SELECT matricula, nombre FROM embarcaciones ORDER BY nombre";
                $result_embarcaciones = pg_query($conn, $query_embarcaciones);

                if ($result_embarcaciones) {
                    while ($row = pg_fetch_assoc($result_embarcaciones)) {
                        echo "<option value='" . $row['matricula'] . "'>" . htmlspecialchars($row['nombre']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay embarcaciones disponibles</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="fecha_asignacion" class="form-label">Fecha de Asignación:</label>
            <input type="date" id="fecha_asignacion" name="fecha_asignacion" class="form-input" required>
        </div>
        
        <button type="submit" class="form-button">Agregar Amarre</button>
    </form>
</div>
