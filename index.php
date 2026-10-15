<?php

require_once "config/database.php";
require_once "modelo/Medico.php";
require_once "modelo/MedicoDao.php";
require_once "controlador/MedicoController.php";

// Conexión a la base de datos
$database = new Database();
$conexion = $database->conectar();

// Objeto para trabajar con médicos
$dao = new MedicoDao($conexion);

// Controlador
$controlador = new MedicoController($dao);

// Acción solicitada
$accion = $_GET["accion"] ?? "index";

// Ejecutar acción
switch ($accion) {
    case "nuevo":
        $controlador->nuevo();
        break;

    case "guardar":
        $controlador->guardar();
        break;

    case "editar":
        $controlador->editar();
        break;

    case "actualizar":
        $controlador->actualizar();
        break;

    case "eliminar":
        $controlador->eliminar();
        break;

    default:
        $controlador->index();
        break;
}
