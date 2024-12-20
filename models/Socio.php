<?php
class Socio {
    private $id_socio;
    private $nombre;
    private $direccion;
    private $ci;
    private $telefono;
    private $fecha_ingreso;

    public function __construct($id_socio, $nombre, $direccion, $ci, $telefono, $fecha_ingreso) {
        $this->id_socio = $id_socio;
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->ci = $ci;
        $this->telefono = $telefono;
        $this->fecha_ingreso = $fecha_ingreso;
    }

    public static function getAll() {
        global $conn;
        $result = pg_query($conn, "SELECT * FROM socios");
        return pg_fetch_all($result);
    }

    public static function getById($id) {
        global $conn;
        $result = pg_query($conn, "SELECT * FROM socios WHERE id_socio = $id");
        return pg_fetch_assoc($result);
    }

    public function create() {
        global $conn;
        $sql = "INSERT INTO socios (nombre, direccion, ci, telefono, fecha_ingreso) 
                VALUES ('$this->nombre', '$this->direccion', '$this->ci', '$this->telefono', '$this->fecha_ingreso')";
        return pg_query($conn, $sql);
    }

    public function update() {
        global $conn;
        $sql = "UPDATE socios SET nombre = '$this->nombre', direccion = '$this->direccion', telefono = '$this->telefono' 
                WHERE id_socio = $this->id_socio";
        return pg_query($conn, $sql);
    }

    public function delete() {
        global $conn;
        $sql = "DELETE FROM socios WHERE id_socio = $this->id_socio";
        return pg_query($conn, $sql);
    }
}
?>
