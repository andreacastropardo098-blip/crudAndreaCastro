<?php
require_once __DIR__ . "/../modelo/Medico.php";
require_once __DIR__ . "/../modelo/MedicoDao.php";

class MedicoController
{
    private $dao;

    private $carpetaFisica;
    private $carpetaWeb = "public/uploads/";

    // CONSTRUCTOR
    public function __construct($dao)
    {
        $this->dao = $dao;
        $this->carpetaFisica = __DIR__ . "/../public/uploads/";
    }

    // LISTAR
    public function index()
    {
        $medicos = $this->dao->listar();
        $mensaje = $_GET["msg"] ?? "";
        require __DIR__ . "/../vista/medicos/index.php";
    }

    // NUEVO
    public function nuevo()
    {
        $medico = new Medico();
        require __DIR__ . "/../vista/medicos/formulario.php";
    }

    // GUARDAR
    public function guardar()
    {
        $foto = $this->subirFoto("");
        if ($foto === false) {
            header("Location: index.php?msg=foto_invalida");
            exit;
        }

        $medico = new Medico();
        $medico->setNombres(trim($_POST["nombres"]));
        $medico->setApellidos(trim($_POST["apellidos"]));
        $medico->setEspecialidad(trim($_POST["especialidad"]));
        $medico->setTelefono(trim($_POST["telefono"]));
        $medico->setFoto($foto);
        $this->dao->insertar($medico);

        header("Location: index.php?msg=guardado");
        exit;
    }

    // EDITAR
    public function editar()
    {
        $id_medico = $_GET["id"] ?? 0;
        $medico = $this->dao->buscarPorId($id_medico);

        if ($medico === null) {
            header("Location: index.php?msg=no_existe");
            exit;
        }
        require __DIR__ . "/../vista/medicos/formulario.php";
    }

    // ACTUALIZAR
    public function actualizar()
    {
        $id_medico = $_POST["id_medico"];
        $actual = $this->dao->buscarPorId($id_medico);

        if ($actual === null) {
            header("Location: index.php?msg=no_existe");
            exit;
        }

        // Si no se sube una foto nueva, se conserva la actual
        $foto = $this->subirFoto($actual->getFoto());
        if ($foto === false) {
            header("Location: index.php?msg=foto_invalida");
            exit;
        }

        $medico = new Medico();
        $medico->setId_medico($id_medico);
        $medico->setNombres(trim($_POST["nombres"]));
        $medico->setApellidos(trim($_POST["apellidos"]));
        $medico->setEspecialidad(trim($_POST["especialidad"]));
        $medico->setTelefono(trim($_POST["telefono"]));
        $medico->setFoto($foto);
        $this->dao->actualizar($medico);

        header("Location: index.php?msg=actualizado");
        exit;
    }

    // ELIMINAR
    public function eliminar()
    {
        $id_medico = $_GET["id"] ?? 0;
        $medico = $this->dao->buscarPorId($id_medico);

        if ($medico !== null) {
            $this->borrarArchivo($medico->getFoto());
            $this->dao->eliminar($id_medico);
        }

        header("Location: index.php?msg=eliminado");
        exit;
    }

    
    private function subirFoto($fotoActual)
    {
        if (!isset($_FILES["foto"]) || $_FILES["foto"]["error"] === UPLOAD_ERR_NO_FILE) {
            return $fotoActual;
        }

        $archivo = $_FILES["foto"];

        if ($archivo["error"] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Máximo 2 MB
        if ($archivo["size"] > 2 * 1024 * 1024) {
            return false;
        }

        // Solo imágenes permitidas
        $permitidos = [
            "image/jpeg" => "jpg",
            "image/png"  => "png",
            "image/gif"  => "gif",
            "image/webp" => "webp"
        ];

        $info = getimagesize($archivo["tmp_name"]);
        if ($info === false || !isset($permitidos[$info["mime"]])) {
            return false;
        }

        if (!is_dir($this->carpetaFisica)) {
            mkdir($this->carpetaFisica, 0777, true);
        }

        $nombre = uniqid("medico_", true) . "." . $permitidos[$info["mime"]];

        if (!move_uploaded_file($archivo["tmp_name"], $this->carpetaFisica . $nombre)) {
            return false;
        }
        $this->borrarArchivo($fotoActual);

        return $this->carpetaWeb . $nombre;
    }

    private function borrarArchivo($foto)
    {
        if ($foto === "" || $foto === null) {
            return;
        }
        $ruta = $this->carpetaFisica . basename($foto);
        if (is_file($ruta)) {
            unlink($ruta);
        }
    }
}
