<?php
// Conexión a la base de datos
$host = 'localhost';
$port = '5432';
$dbname = 'club_naut';
$user = 'postgres';
$password = 'fabricio';

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

if (!$conn) {
    die("Error de conexión: " . pg_last_error());
}

// Variables para el filtro de búsqueda
$codigo_empleado = isset($_GET['codigo_empleado']) ? $_GET['codigo_empleado'] : '';
$letra_zona = isset($_GET['letra_zona']) ? $_GET['letra_zona'] : '';

// Consulta para obtener los datos de la vista empleados_zonas_asignadas con filtros
$query = "SELECT * FROM empleados_zonas_asignadas WHERE 1=1";  // Añadido 1=1 para que se puedan agregar condiciones

// Agregar condiciones de búsqueda si existen
if ($codigo_empleado) {
    $query .= " AND codigo_empleado = '$codigo_empleado'";
}

if ($letra_zona) {
    $query .= " AND letra_zona = '$letra_zona'";
}

$result = pg_query($conn, $query);

if (!$result) {
    die("Error en la consulta: " . pg_last_error());
}

// Lógica para insertar un nuevo registro en empleados_zonas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo_empleado = isset($_POST['codigo_empleado']) ? $_POST['codigo_empleado'] : '';
    $letra_zona = isset($_POST['letra_zona']) ? $_POST['letra_zona'] : '';
    $barcos_asignados = isset($_POST['barcos_asignados']) ? $_POST['barcos_asignados'] : '';

    if ($codigo_empleado && $letra_zona && $barcos_asignados) {
        $insert_query = "INSERT INTO empleados_zonas (codigo_empleado, letra_zona, barcos_asignados) 
                         VALUES ('$codigo_empleado', '$letra_zona', '$barcos_asignados')";
        
        $insert_result = pg_query($conn, $insert_query);
        
        if ($insert_result) {
            echo "<p class='success-message'>Registro agregado correctamente.</p>";
        } else {
            echo "<p class='error-message'>Error al agregar el registro.</p>";
        }
    } else {
        echo "<p class='error-message'>Todos los campos son obligatorios.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Empleados Zonas Asignadas</title>
    <link rel="stylesheet" href="styleempzo.css">
</head>
<body>
    <div class="container">
        <h1>Listado de Empleados y Zonas Asignadas</h1>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="">
            <label for="codigo_empleado">Código de Empleado:</label>
            <input type="text" id="codigo_empleado" name="codigo_empleado" value="<?php echo htmlspecialchars($codigo_empleado); ?>">
            
            <label for="letra_zona">Letra de Zona:</label>
            <input type="text" id="letra_zona" name="letra_zona" value="<?php echo htmlspecialchars($letra_zona); ?>">
            
            <button type="submit">Buscar</button>
        </form>

        <!-- Mostrar los resultados de la búsqueda -->
        <table>
            <thead>
                <tr>
                    <th>Código del Empleado</th>
                    <th>Nombre del Empleado</th>
                    <th>Letra de la Zona</th>
                    <th>Tipo de Barco</th>
                    <th>Barcos Asignados</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = pg_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['codigo_empleado']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_empleado']); ?></td>
                        <td><?php echo htmlspecialchars($row['letra_zona']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_barco']); ?></td>
                        <td><?php echo htmlspecialchars($row['barcos_asignados']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <!-- Formulario para agregar un nuevo registro -->
        <h2>Agregar Nuevo Registro</h2>
        <form method="POST" action="">
            <label for="codigo_empleado">Código de Empleado:</label>
            <select id="codigo_empleado" name="codigo_empleado" required>
                <?php
                // Obtener los empleados disponibles para el select
                $empleados_query = "SELECT codigo, nombre FROM empleados ORDER BY nombre";
                $empleados_result = pg_query($conn, $empleados_query);

                if ($empleados_result) {
                    while ($empleado = pg_fetch_assoc($empleados_result)) {
                        echo "<option value='" . $empleado['codigo'] . "'>" . htmlspecialchars($empleado['nombre']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay empleados disponibles</option>";
                }
                ?>
            </select>
            
            <label for="letra_zona">Letra de Zona:</label>
            <select id="letra_zona" name="letra_zona" required>
                <?php
                // Obtener las zonas disponibles para el select
                $zonas_query = "SELECT letra FROM zonas ORDER BY letra";
                $zonas_result = pg_query($conn, $zonas_query);

                if ($zonas_result) {
                    while ($zona = pg_fetch_assoc($zonas_result)) {
                        echo "<option value='" . $zona['letra'] . "'>" . htmlspecialchars($zona['letra']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay zonas disponibles</option>";
                }
                ?>
            </select>

            <label for="barcos_asignados">Barcos Asignados:</label>
            <input type="number" id="barcos_asignados" name="barcos_asignados" required>
            
            <button type="submit">Agregar</button>
        </form>
    </div>
</body>
</html>

<?php
// Liberar resultados y cerrar la conexión
pg_free_result($result);
pg_close($conn);
?>
