<?php

class ABMPersona{
    //Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto

    public function abm($datos){
        $resp = false;
        if($datos['accion']=='editar'){
            if($this->modificacion($datos)){
                $resp = true;
            }
        }
        if($datos['accion']=='borrar'){
            if($this->baja($datos)){
                $resp =true;
            }
        }
        if($datos['accion']=='nuevo'){
            if($this->alta($datos)){
                $resp =true;
            }
            
        }
        return $resp;

    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return Auto
     */
    private function cargarObjeto($param){
        $obj = null;
           
        if(array_key_exists('nrodni',$param) && array_key_exists('apellido',$param) && array_key_exists('nombre', $param) && array_key_exists('fechanac', $param) && array_key_exists('telefono', $param) && array_key_exists('domicilio', $param)){
            $obj = new Persona();
            $auto = new Auto();
            $autosPersona = $auto->listar("dniduenio = '".$param['nrodni']."'");
            $obj->setear($param['nrodni'], $param['apellido'], $param['nombre'], $param['fechanac'], $param['telefono'], $param['domicilio'], $autosPersona);
        }
        return $obj;
    }
    
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return Auto
     */
    private function cargarObjetoConClave($param){
        $obj = null;
        
        if( isset($param['nrodni']) ){
            $obj = new Persona();
            $obj->setear($param['nrodni'], null, null, null, null, null, null);
        }
        return $obj;
    }
    
    
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    
    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['nrodni']))
            $resp = true;
        return $resp;
    }
    
    /**
     * 
     * @param array $param
     */
    public function alta($param){
        $resp = false;
        // $param['patente'] =null;
        $objPersona = $this->cargarObjeto($param);
//        verEstructura($elObjtTabla);
        if ($objPersona!=null and $objPersona->insertar()){
            $resp = true;
        }
        return $resp;
        
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objPersona = $this->cargarObjetoConClave($param);
            if ($objPersona!=null and $objPersona->eliminar()){
                $resp = true;
            }
        }
        
        return $resp;
    }
    
    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        //echo "Estoy en modificacion";
        $resp = false;
        if ($this->seteadosCamposClaves($param)){
            $objPersona = $this->cargarObjeto($param);
            if($objPersona!=null and $objPersona->modificar()){
                $resp = true;
            }
        }
        return $resp;
    }
    
    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        if ($param<>NULL){
            if (isset($param['nrodni'])) $where.=" and nrodni =".$param['nrodni'];
            if (isset($param['apellido'])) $where.=" and apellido ='".$param['apellido']."'";
            if (isset($param['nombre'])) $where.=" and nombre =".$param['nombre']."";
            if (isset($param['fechanac'])) $where.=" and fechanac =".$param['fechanac']."";
            if (isset($param['telefono'])) $where.=" and telefono =".$param['telefono']."";
            if (isset($param['domicilio'])) $where.=" and domicilio =".$param['domicilio']."";


        }
        $personita = new Persona();
        $arreglo = $personita->listar($where);  
        return $arreglo;
        
    }
    
}
?>



}