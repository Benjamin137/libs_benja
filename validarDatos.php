<?php

class TipoDatoValidator {
//------------------------Objetos para mapeo----------------------------
    private $tipoMapeo = [
        'i' => 'int',
        's' => 'string',
        'f' => 'date',
        't' => 'time'

    ];

    private $validaciones = [
        'int' => 'validarEntero',
        'string' => 'validarTexto',
        'date' => 'validarFecha',
        'time' => 'validarHora'

    ];

    private $tipoRequerimiento = [
      
        'o' => 'obligatorio',
        'n' => 'no obligatorio'

    ];

    private $validacionesRequerimiento = [
        'obligatorio' => 'validarObligatorio',
        //'no obligatorio' => 'validarNoObligatorio'

    ];

    private $arrayNoValidados = array();
    private $arrayIncumplimientoRequerimiento = array();

//------------------------Ordenadores de array----------------------------
    
    public function obtenerTipoDato($array) {

        $arrayReturn = array();

        $tipoMapeo = $this->tipoMapeo;
        
        foreach ($array as $key => $value) {
            $tipo = substr($key, 0, 1);
        
            if (isset($tipoMapeo[$tipo])) {

                $arrayReturn[$tipoMapeo[$tipo]][$key] = $value;

            } else {

                responseRequest(true, "TIPO DE DATO NO VALIDO: " . $key, true, array());

            }
        }

        return $arrayReturn;
    }

    
    public function obtenerRequerimientoCampo($array) {

        $arrayReturn = array();

        $tipoMapeo = $this->tipoRequerimiento;
        
        foreach ($array as $key => $value) {
            $tipo = substr($key, 1, 1);
        
            if (isset($tipoMapeo[$tipo])) {

                $arrayReturn[$tipoMapeo[$tipo]][$key] = $value;

            } else {

                responseRequest(true, "TIPO DE REQUERIMIENTO NO VALIDO: " . $key, true, array());

            }
        }

        return $arrayReturn;
    }

//------------------------Validador----------------------------

    public function validarTipoRequerimiento($array) {
        
        $validacionesRequerimiento = $this->validacionesRequerimiento;
        foreach ($array as $tipo => $valores){

            if (isset($validacionesRequerimiento[$tipo]) && is_array($valores)){
                foreach ($valores as $key => $value) {

                    $this->{$validacionesRequerimiento[$tipo]}($value, $key);

                }
            }
        }

        return $this->arrayIncumplimientoRequerimiento;

    }

    public function validarTipoDato($array) {
        
        $validaciones = $this->validaciones;
        foreach ($array as $tipo => $valores){

            if (isset($validaciones[$tipo]) && is_array($valores)){
                foreach ($valores as $key => $value) {

                    $this->{$validaciones[$tipo]}($value, $key);

                }
            }
        }

        return $this->arrayNoValidados;

    }
//--------------------VALIDACIONES DE DATO--------------------
    
    public function validarEntero($valor, $nombreId) {
  
        if(is_int($valor) || empty($valor) || is_null($valor)) {
            return true;
        } else {
            $this->arrayNoValidados[] = $nombreId;
        }
  
    }

    public function validarTexto($valor, $nombreId) {
     
        if(is_string($valor) || empty($valor) || is_null($valor)) {
            return true;
        } else {
            $this->arrayNoValidados[] = $nombreId;
        }

    }

    public function validarFecha($valor, $nombreId) {

        if(is_string($valor)) {
            return true;
        } else {
            $this->arrayNoValidados[] = $nombreId;
        }
       
    }

    public function validarHora($valor, $nombreId) {
        if(is_string($valor)) {
            return true;
        } else {
            $this->arrayNoValidados[] = $nombreId;
        }
    }

    public function validarDecimal($valor) {
        if(is_float($valor)) {
            return true;
        } else {
            $this->arrayNoValidados[] = $nombreId;
        }
    }

    //--------------------VALIDACIONES DE REQUERIMIENTO--------------------
    public function validarObligatorio($valor, $nombreId) {
        if(!empty($valor) || is_null($valor)) {
            return true;
            echo "hola";
        } else {
            $this->arrayIncumplimientoRequerimiento[] = $nombreId;
        }
 
    }

}

?>