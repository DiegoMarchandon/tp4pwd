<?php

class Auto{
    private $patente;
    private $marca;
    private $modelo;
    private $objDuenio;
    private $mensajeoperacion;

    public function __construct() {
        $this->patente='';
        $this->marca='';
        $this->modelo='';
        $this->objDuenio =new Persona();
        $this->mensajeoperacion='';
    }

    public function getPatente(){
        return $this->patente;
    }

    public function setPatente($nuevaPatente){
        $this->patente = $nuevaPatente;
    }

    public function getMarca(){
        return $this->marca;
    }

    public function setMarca($nuevaMarca){
        $this->marca = $nuevaMarca;
    }

    public function getModelo(){
        return $this->modelo;
    }

    public function setModelo($nuevoModelo){
        $this->modelo = $nuevoModelo;
    }

    public function getObjDuenio(){
        return $this->objDuenio;
    }

    public function setObjDuenio($nuevoObjDuenio){
        $this->objDuenio = $nuevoObjDuenio;
    }

    public function getMensajeOperacion(){
        return $this->mensajeoperacion;
    }

    public function setMensajeOperacion($nuevoMensajeOperacion){
        $this->mensajeoperacion = $nuevoMensajeOperacion;
    }

    public function setear($patente, $marca, $modelo, $objDuenio){
        $this->setPatente($patente);
        $this->setMarca($marca);
        $this->setModelo($modelo);
        $this->setObjDuenio($objDuenio);
    }

    public function cargar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="SELECT * FROM auto WHERE patente = ".$this->getPatente();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objDuenio = new Persona();
                    $objDuenio->setNroDni($row['DniDuenio']);
                    $objDuenio->cargar();
                    $this->setear($row['patente'], $row['marca'], $row['modelo'], $objDuenio);
                    
                }
            }
        } else {
            $this->setmensajeoperacion("Auto->listar: ".$base->getError());
        }
        return $resp;
     
    }

    public function insertar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="INSERT INTO auto(patente, marca, modelo, dniduenio)  VALUES('".$this->getPatente()."', '".$this->getMarca()."', '".$this->getModelo()."', '".$this->getObjDuenio()->getNroDni()."');";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Auto->insertar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->insertar: ".$base->getError());
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="UPDATE auto SET marca ='".$this->getMarca()."', modelo= '".$this->getModelo()."', dniduenio = '".$this->getObjDuenio()->getNroDni()."' WHERE patente= '".$this->getPatente()."'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Auto->modificar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->modificar: ".$base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base=new BaseDatos();
        $sql="DELETE FROM auto WHERE patente=".$this->getPatente();
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Auto->eliminar: ".$base->getError());
            }
        } else {
            $this->setmensajeoperacion("Auto->eliminar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro=""){
        $arreglo = array();
        $base=new BaseDatos();
        $sql="SELECT * FROM auto ";
        if ($parametro!="") {
            $sql.='WHERE '.$parametro;
        }
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                
                while ($row = $base->Registro()){
                    $autito= new Auto();
                    $objDuenio = new Persona();
                    $objDuenio->setNroDni($row['DniDuenio']);
                    $objDuenio->cargar();
                    $autito->setear($row['patente'], $row['marca'], $row['modelo'], $objDuenio);      
                    array_push($arreglo, $autito);
                }
               
            }
            
        } else {
            $this->setmensajeoperacion("Auto->listar: ".$base->getError());
        }
 
        return $arreglo;
    }

    // public function toArray(){
    //     return ["Patente"=> $this->getPatente(), "Marca" => $this->getMarca(), "Modelo" => $this->getModelo()];
    // }


    public function arrayToString($arreglo){
        $string = '';
        foreach ($arreglo as $elemento){
            $string .= "$elemento.\n";
        }
        return $string;
    }

    public function __toString()
    {
        return "\nPatente: ".$this->getPatente().
        "\nMarca: " .$this->getMarca().
        "\nModelo: ".$this->getModelo().
        "\nDni dueño:".$this->getObjDuenio()->getNroDni();
    }

}