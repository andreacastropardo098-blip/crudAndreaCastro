<?php
require_once __DIR__ . "/Medico.php";

class MedicoDao
{
    private $conexion;

    // CONSTRUCTOR
    public function __construct($conexion)
    {
        $this->conexion = $conexion;
    }

    // LISTAR MÉDICOS
    public function listar()
    {
        $sql = "SELECT id_medico, nombres, apellidos, especialidad, telefono, foto
                FROM medico
                ORDER BY id_medico DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $medicos = [];

        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $medicos[] = new Medico(
                $fila["id_medico"],
                $fila["nombres"],
                $fila["apellidos"],
                $fila["especialidad"],
                $fila["telefono"],
                $fila["foto"]
            );
        }
        return $medicos;
    }

    // BUSCAR POR ID
    public function buscarPorId($id_medico)
    {
        $sql = "SELECT id_medico, nombres, apellidos, especialidad, telefono, foto
                FROM medico
                WHERE id_medico = :id_medico";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute(["id_medico" => $id_medico]);
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return new Medico(
                $fila["id_medico"],
                $fila["nombres"],
                $fila["apellidos"],
                $fila["especialidad"],
                $fila["telefono"],
                $fila["foto"]
            );
        }
        return null;
    }

    // INSERTAR
    public function insertar(Medico $medico)
    {
        $sql = "INSERT INTO medico
                    (nombres, apellidos, especialidad, telefono, foto)
                VALUES
                    (:nombres, :apellidos, :especialidad, :telefono, :foto)";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "nombres"      => $medico->getNombres(),
            "apellidos"    => $medico->getApellidos(),
            "especialidad" => $medico->getEspecialidad(),
            "telefono"     => $medico->getTelefono(),
            "foto"         => $medico->getFoto()
        ]);
    }

    // ACTUALIZAR
    public function actualizar(Medico $medico)
    {
        $sql = "UPDATE medico
                SET nombres = :nombres,
                    apellidos = :apellidos,
                    especialidad = :especialidad,
                    telefono = :telefono,
                    foto = :foto
                WHERE id_medico = :id_medico";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "id_medico"    => $medico->getId_medico(),
            "nombres"      => $medico->getNombres(),
            "apellidos"    => $medico->getApellidos(),
            "especialidad" => $medico->getEspecialidad(),
            "telefono"     => $medico->getTelefono(),
            "foto"         => $medico->getFoto()
        ]);
    }

    // ELIMINAR
    public function eliminar($id_medico)
    {
        $sql = "DELETE FROM medico
                WHERE id_medico = :id_medico";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            "id_medico" => $id_medico
        ]);
    }
}
