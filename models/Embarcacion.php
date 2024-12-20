<?php
class Embarcacion {
    private $matricula;
    private $nombre;
    private $tipo;
    private $dimensiones;
    private $id_socio;

    public function __construct($matricula, $nombre, $tipo, $dimensiones, $id_socio) {
        $this->matricula = $matricula;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->dimensiones = $dimensiones;
        $this->id_socio = $id_socio;
    }

    public static function getAll() {
        global $conn;
        $result = pg_query($conn, "SELECT * FROM embarcaciones");
        return pg_fetch_all($result);
    }

    public static function getById($matricula) {
        global $conn;
        $result = pg_query($conn, "SELECT * FROM embarcaciones WHERE matricula = $matricula");
        return pg_fetch_assoc($result);
    }

    public function create() {
        global $conn;
        $sql = "INSERT INTO embarcaciones (nombre, tipo, dimensiones, id_socio) 
                VALUES ('$this->nombre', '$this->tipo', '$this->dimensiones', '$this->id_socio')";
        return pg_query($conn, $sql);
    }

    public function update() {
        global $conn;
        $sql = "UPDATE embarcaciones SET nombre = '$this->nombre', tipo = '$this->tipo', dimensiones = '$this->dimensiones' 
                WHERE matricula = $this->matricula";
        return pg_query($conn, $sql);
    }

    public function delete() {
        global $conn;
        $sql = "DELETE FROM embarcaciones WHERE matricula = $this->matricula";
        return pg_query($conn, $sql);
    }
}
?>
