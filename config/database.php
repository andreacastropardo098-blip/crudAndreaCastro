<?php

class Database
{
    private $host = "localhost";
    private $db_name = "hospital";
    private $username = "root";
    private $password = "";

    public function conectar()
    {
        try {
            $conexion = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password
            );

            // Los errores de SQL generan excepciones
            $conexion->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );

            // Los registros se devuelven como arreglos asociativos
            $conexion->setAttribute(
                PDO::ATTR_DEFAULT_FETCH_MODE,
                PDO::FETCH_ASSOC
            );

            return $conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
