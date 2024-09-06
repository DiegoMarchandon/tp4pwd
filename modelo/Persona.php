<?php

class Persona{
    private $nroDni;
    private $apellido;
    private $nombre;
    private $fechaNac;
    private $telefono;
    private $domicilio;
    private $colAutos;
    private $mensajeoperacion;

    public function __construct() {
        $this->nroDni = '';
        $this->apellido = '';
        $this->nombre = '';
        $this->fechaNac = '';
        $this->telefono = '';
        $this->domicilio = '';
        $this->colAutos = [];
        $this->mensajeoperacion = '';
    }

    public function getNroDni(){
        return $this->nroDni;
    }

    public function setNroDni($nuevoNroDni){
        $this->nroDni = $nuevoNroDni;
    }

    public function getApellido(){
        return $this->apellido;
    }

    public function setApellido($nuevoApellido){
        $this->apellido = $nuevoApellido;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nuevoNombre){
        $this->nombre = $nuevoNombre;
    }

    public function getFechaNac(){
        return $this->fechaNac;
    }

    public function setFechaNac($nuevaFechaNac){
        $this->fechaNac = $nuevaFechaNac;
    }

    public function getTelefono(){
        return $this->telefono;
    }

    public function setTelefono($nuevoTelefono){
        $this->telefono = $nuevoTelefono;
    }

    public function getDomicilio(){
        return $this->domicilio;
    }

    public function setDomicilio($nuevoDomicilio){
        $this->domicilio = $nuevoDomicilio;
    }

    public function getColAutos(){
        return $this->colAutos;
    }

    public function setColAutos($nuevaColAutos){
        $this->colAutos = $nuevaColAutos;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function setMensajeOperacion($nuevoMensajeOperacion){
        $this->mensajeoperacion = $nuevoMensajeOperacion;
    }

    public function setear($dni, $apellido, $nombre, $fechaNac, $telefono, $domicilio, $colAutos){
        $this->setNroDni($dni);
        $this->setApellido($apellido);
        $this->setNombre($nombre);
        $this->setFechaNac($fechaNac);
        $this->setTelefono($telefono);
        $this->setDomicilio($domicilio);
        $this->setColAutos($colAutos);
    }

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM persona WHERE nrodni = ".$this->getNroDni();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear($row['nrodni'], $row['apellido'], $row['nombre'], $row['fechanac'], $row['telefono'], $row['domicilio'], '');
                }
            }
        } else {
            $this->setmensajeoperacion("Persona->listar: ".$base->getError());
        }
        return $resp;
     
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO persona(nrodni, apellido, nombre, fechanac, telefono, domicilio)  VALUES('".$this->getNroDni()."', '".$this->getApellido()."', '".$this->getNombre()."', '".$this->getFechaNac()."', '".$this->getTelefono()."', '".$this->getDomicilio()."');";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Persona->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE persona SET apellido='".$this->getApellido()."', nombre = '".$this->getNombre()."', fechaNac = '".$this->getFechaNac()."', telefono = '". $this->getTelefono()."', domicilio = '". $this->getDomicilio()."' WHERE nroDni= '".$this->getNroDni()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Persona->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM persona WHERE nrodni=".$this->getNroDni();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Persona->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Persona->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM persona ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $personita = new Persona();
                    $personita->setear($row['nrodni'], $row['apellido'], $row['nombre'], $row['fechanac'], $row['telefono'], $row['domicilio']);
                    array_push($arreglo, $personita);
                }
               
            }
            
        } else {
            $this->setmensajeoperacion("Persona->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

    public function arrayToString($arreglo){
        $string = '';
        foreach ($arreglo as $elemento){
            $string .= "$elemento.\n";
        }
        return $string;
    }

    public function __toString()
    {
        return "\nNro dni: ".$this->getNroDni().
        "\nApellido: ".$this->getApellido().
        "\nNombre: ".$this->getNombre().
        "\nFecha nacimiento: ".$this->getFechaNac().
        "\nTeléfono: ".$this->getTelefono().
        "\nDomicilio: ". $this->getDomicilio().
        "\n/////////////////////AUTOS/////////////////////\n".$this->arrayToString($this->colAutos);
    }
}