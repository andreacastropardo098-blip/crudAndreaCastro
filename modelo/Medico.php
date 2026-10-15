<?php

class Medico
{
    private $id_medico;
    private $nombres;
    private $apellidos;
    private $especialidad;
    private $telefono;
    private $foto;

    // CONSTRUCTOR
    public function __construct(
        $id_medico = null,
        $nombres = "",
        $apellidos = "",
        $especialidad = "",
        $telefono = "",
        $foto = ""
    ) {
        $this->id_medico = $id_medico;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->especialidad = $especialidad;
        $this->telefono = $telefono;
        $this->foto = $foto;
    }

    // GETTERS
    public function getId_medico()
    {
        return $this->id_medico;
    }

    public function getNombres()
    {
        return $this->nombres;
    }

    public function getApellidos()
    {
        return $this->apellidos;
    }

    public function getEspecialidad()
    {
        return $this->especialidad;
    }

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    // SETTERS
    public function setId_medico($id_medico)
    {
        $this->id_medico = $id_medico;
    }

    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }

    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function setEspecialidad($especialidad)
    {
        $this->especialidad = $especialidad;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
}
