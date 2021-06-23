<?php

/**
 * Clase que controla las operaciones con los registros de las tablas. 
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

class S3TablaBD {

    protected $nombreDO;
    public $camposListado;

    public function calcularConsecutivo($columna, $tabla = NULL) {
        //DB_DataObject::debugLevel(1);
        if ($tabla !== NULL) {
            $bdObjeto = DB_DataObject::factory($tabla);
        } else {
            $bdObjeto = DB_DataObject::factory($this->nombreDO);
        }
        $bdObjeto->selectAdd();
        $bdObjeto->selectAdd('(MAX(' . $columna . ')+1) AS consecutivo');
        $bdObjeto->find();
        $bdObjeto->fetch();
        return ($bdObjeto->consecutivo > 0) ? $bdObjeto->consecutivo : 1;
    }

    public function nuevo() {
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        if (property_exists(get_class($bdObjeto), 'activo')) {
            $bdObjeto->activo = 1;
        }
        return $bdObjeto->toArray();
    }

    public function obtenerCamposListado() {
        return $this->camposListado;
    }

    public function obtenerListaRegistros($filtrarActivos = false, $ajaxTabla = false) {
//        DB_DataObject::debugLevel(1);
//        if ($this->nombreDO == 'solicitud') {
//            $ajaxTabla = true;
//        }
        $listaRegistros = array();
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        if (property_exists(get_class($bdObjeto), 'eliminado')) {
            $bdObjeto->eliminado = 0;
        }
        if (property_exists(get_class($bdObjeto), 'activo') && $filtrarActivos) {
            $bdObjeto->activo = 1;
        }

        $this->prelistar($bdObjeto);

        if ($ajaxTabla) {
            $this->obtenerListaRegistrosTablaAjax($bdObjeto);
        }
        $bdObjeto->orderBy($this->nombreDO . '.id DESC');
        $bdObjeto->find();
        while ($bdObjeto->fetch()) {
            $registro = $bdObjeto->toArray();
            $this->preasignarlista($registro);
            $listaRegistros[] = $registro;
            $this->camposListado = array_keys($registro);
        }
        if (count($listaRegistros) == 0) {
            $this->camposListado = array_keys($bdObjeto->toArray());
        }

        if ($ajaxTabla) {
            $this->postObtenerListaRegistros($listaRegistros);
        }
        return $listaRegistros;
    }

    public function obtenerListaRegistrosTabla($filtrarActivos = false, $prelistar = true) {
        // DB_DataObject::debugLevel(5);
        $listaRegistros = array();
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        if (property_exists(get_class($bdObjeto), 'eliminado')) {
            $bdObjeto->eliminado = 0;
        }
        if (property_exists(get_class($bdObjeto), 'activo') && $filtrarActivos) {
            $bdObjeto->activo = 1;
        }
        if ($prelistar) {
            $this->prelistartabla($bdObjeto);
        }
        $bdObjeto->find();
        while ($bdObjeto->fetch()) {
            $registro = $bdObjeto->toArray();
            $listaRegistros[] = $registro;
            $this->camposListado = array_keys($registro);
        }
        if (count($listaRegistros) == 0) {
            $this->camposListado = array_keys($bdObjeto->toArray());
        }
        //__P($listaRegistros);

        return $listaRegistros;
    }

    public function obtenerListaRegistrosTablaAjax(&$bdObjeto) {
        // DB_DataObject::debugLevel(5);
        $request = new S3Request();
        $post = $request->obtenerVariables();

        if (isset($post['search']['value']) && $post['search']['value'] != '') {
            if ($this->nombreDO == 'usuario') {
                $bdObjeto->whereAdd(' usuario.nombre LIKE "%' . $post['search']['value'] . '%" or apellido LIKE "%' . $post['search']['value'] . '%"');
            }

            if ($this->nombreDO != 'solicitud' && $this->nombreDO != 'usuario' && $this->nombreDO != 'propuesto') {
                $bdObjeto->whereAdd(' ' . $this->nombreDO . '.nombre LIKE "%' . $post['search']['value'] . '%"  or ' . $this->nombreDO . '.id LIKE "%' . $post['search']['value'] . '%"');
            }
            if ($this->nombreDO == 'solicitud') {
                //$bdObjeto->whereAdd(' solicitud.id LIKE "%' . $post['search']['value'] . '%"  ');
                $cid = 'solicitud.id LIKE "%' . $post['search']['value'] . '%"';
                //para nombres
                $cnom = '';
                $bdprop1 = DB_DataObject::factory('propuesto');
                $bdprop1->selectAdd('propuesto.id');
                $bdprop1->whereAdd(' propuesto.nombre_usuario like "%' . $post['search']['value'] . '%"');
                $bdprop1->find();
                $Registros1 = array();
                while ($bdprop1->fetch()) {
                    $reg1 = $bdprop1->toArray();
                    $Registros1[] = $reg1;
                }
                $cnom.=' solicitud.nombre_usuario like "%' . $post['search']['value'] . '%"';
                if (count($Registros1) > 0) {
                    $cnom.= ' or solicitud.propuesto_id="' . $Registros1[0]['id'] . '" ';
                    for ($o = 1; $o < count($Registros1); $o++) {
                        $cnom.= ' or solicitud.propuesto_id="' . $Registros1[$o]['id'] . '" ';
                    }
                }

                // para numero documento
                $cdoc = '';
                $bdprop = DB_DataObject::factory('propuesto');
                $bdprop->selectAdd('propuesto.id');
                $bdprop->whereAdd(' propuesto.numero_documento like "%' . $post['search']['value'] . '%"');
                $bdprop->find();
                $Registros = array();
                while ($bdprop->fetch()) {
                    $reg = $bdprop->toArray();
                    $Registros[] = $reg;
                }
                $cdoc.=' solicitud.numero_documento like "%' . $post['search']['value'] . '%"';
                // __P($Registros);
                if (count($Registros) > 0) {
                    $cdoc.= ' or solicitud.propuesto_id="' . $Registros[0]['id'] . '" ';
                    for ($n = 1; $n < count($Registros); $n++) {
                        $cdoc.= ' or solicitud.propuesto_id="' . $Registros[$n]['id'] . '" ';
                    }
                }
                // para agentes
                $cagec = '';
                $bdage = DB_DataObject::factory('usuario');
                $bdage->selectAdd('usuario.id');
                $bdage->whereAdd(' usuario.nombre like "%' . $post['search']['value'] . '%"  or usuario.apellido like "%' . $post['search']['value'] . '%"');
                $bdage->find();
                $Registrosage = array();
                while ($bdage->fetch()) {
                    $regage = $bdage->toArray();
                    $Registrosage[] = $regage;
                }

                if ($Registrosage[0]['id'] > 0) {
                    $cagec.= ' solicitud.agente="' . $Registrosage[0]['id'] . '" ';
                    if (count($Registrosage) > 1) {
                        for ($p = 1; $p < count($Registrosage); $p++) {
                            $cagec.= ' or solicitud.agente="' . $Registrosage[$p]['id'] . '" ';
                        }
                    }
                }
                // para companias
                $ccompc = '';
                $bdcom = DB_DataObject::factory('compania');
                $bdcom->selectAdd('compania.id');
                $bdcom->whereAdd(' compania.nombre like "%' . $post['search']['value'] . '%" ');
                $bdcom->find();
                $Registroscom = array();
                while ($bdcom->fetch()) {
                    $regcom = $bdcom->toArray();
                    $Registroscom[] = $regcom;
                }

                if ($Registroscom[0]['id'] > 0) {
                    $ccompc.= ' solicitud.compania="' . $Registroscom[0]['id'] . '" ';
                    if (count($Registroscom) > 1) {
                        for ($p = 1; $p < count($Registroscom); $p++) {
                            $ccompc.= ' or solicitud.compania="' . $Registroscom[$p]['id'] . '" ';
                        }
                    }
                }



                if ($cagec == '' && $ccompc == '') {
                    $bdObjeto->whereAdd($cid . ' or ' . $cdoc . ' or ' . $cnom);
                }
                if ($cagec != '' && $ccompc == '') {
                    $bdObjeto->whereAdd($cid . ' or ' . $cdoc . ' or ' . $cnom . ' or ' . $cagec);
                }
                if ($cagec == '' && $ccompc != '') {
                    $bdObjeto->whereAdd($cid . ' or ' . $cdoc . ' or ' . $cnom . ' or ' . $ccompc);
                }
                if ($cagec != '' && $ccompc != '') {
                    $bdObjeto->whereAdd($cid . ' or ' . $cdoc . ' or ' . $cnom . ' or ' . $ccompc . ' or ' . $cagec);
                }
            }
            if ($this->nombreDO == 'propuesto') {
                $bdObjeto->whereAdd(' propuesto.nombre_usuario LIKE "%' . $post['search']['value'] . '%" or propuesto.id LIKE "%' . $post['search']['value'] . '%" or  propuesto.numero_documento LIKE "%' . $post['search']['value'] . '%"');
            }


            $this->cantFil = 0;
        }





        //cc_reports
        $bdObjeto->orderby($this->nombreDO . '.id DESC');
        //cc_reports
        $this->modObtenerListaRegistrosTablaAjax($bdObjeto);

        if (isset($this->cantFil)) {
            $this->cantFil = $bdObjeto->count();
        }

        $bdObjeto->limit($post['start'], $post['length']);
    }

    protected function obtenerCount() {
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        if (property_exists(get_class($bdObjeto), 'eliminado')) {
            $bdObjeto->eliminado = 0;
        }

        return $bdObjeto->count();
    }

    protected function modObtenerListaRegistrosTablaAjax(&$bdObjeto) {
        // __P($bdObjeto);
    }

    protected function postObtenerListaRegistros(&$listaRegistros) {
        $request = new S3Request();
        $post = $request->obtenerVariables();

        //  __P($listaRegistros);

        for ($i = 0; $i < count($listaRegistros); $i++) {
            $listaRegistros[$i]['checkbox'] = '<label><input type="checkbox" name="id[]" value="' . $listaRegistros[$i]['id'] . '" class="minimal-red"></label>';
            $listaRegistros[$i]['activo'] = $listaRegistros[$i]['activo'] == 0 ? '<i class="fa fa-square-o"></i>' : '<i class="fa fa-check-square-o"></i>';
        }
//__P($listaRegistros);
        if (!empty($listaRegistros)) {
            $listaRegistros = array(
                'data' => $listaRegistros,
                'draw' => $post['draw'],
                'recordsTotal' => $this->obtenerCount(),
                'recordsFiltered' => empty($this->cantFil) ? $this->obtenerCount() : $this->cantFil,
            );
        }


        if (empty($listaRegistros)) {

            $listaRegistros = array(
                'data' => $listaRegistros,
                'draw' => $post['draw'],
                'recordsTotal' => 0,
                'recordsFiltered' => empty($this->cantFil) ? 0 : 0,
            );
        }
    }

    public function obtenerRegistro($registro) {
        //DB_DataObject::debugLevel(5);
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        if (property_exists(get_class($bdObjeto), 'eliminado')) {
            $bdObjeto->eliminado = 0;
        }
        
        if (!$bdObjeto->get($registro) && !empty($registro)) {
            header("Location: index.php");
        }
        
        $this->preobtenerregistro($bdObjeto);
        $bdObjeto->find();
        $bdObjeto->fetch();
        return $bdObjeto->toArray();
    }

    public function guardar() {
        global $aplicacion;
        //DB_DataObject::debugLevel(5);		
        $request = new S3Request();
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        $registroId = $request->obtenerVariablePGR('registro_id');
        $bdObjeto->get($registroId);
        $this->postgetguardar($bdObjeto);
        $variablesPost = $request->obtenerVariables();
        //__P($variablesPost);
        foreach ($variablesPost as $variablePost => $valorPost) {
            if (property_exists(get_class($bdObjeto), $variablePost)) {
                $bdObjeto->$variablePost = $valorPost == '-1' ? NULL : $valorPost;
            }
        }
        if ($bdObjeto->id > 0) {
            if (property_exists(get_class($bdObjeto), "actualizado_por")) {
                $bdObjeto->actualizado_por = $aplicacion->getUsuario()->getId();
                $bdObjeto->fecha_modificacion = date('Y-m-d H:i:s');
            }
            $this->preguardar($bdObjeto);
            $accion = "Actualizar";
            $bdObjeto->update();
            $this->postguardar($bdObjeto);
        } else {
            if (property_exists(get_class($bdObjeto), "fecha_creacion")) {
                $bdObjeto->fecha_creacion = date('Y-m-d H:i:s');
                $bdObjeto->creado_por = $aplicacion->getUsuario()->getId();
            }
            $accion = "Crear";
            $this->preguardar($bdObjeto);
            $bdObjeto->insert();
            $this->postguardar($bdObjeto);
        }

        return $bdObjeto->id;
    }

    protected function postgetguardar(&$bdObjeto) {
        
    }

    protected function postguardar(&$bdObjeto) {
        
    }

    protected function preobtenerregistro(&$bdObjeto) {
        
    }

    protected function prelistar(&$bdObjeto) {
        
    }

    protected function prelistartabla(&$bdObjeto) {
        
    }

    protected function preasignarlista(&$registro) {
        
    }

    protected function preguardar(&$bdObjeto) {
        
    }

    public function eliminar() {
        //DB_DataObject::debugLevel(5);		
        $request = new S3Request();
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        $variablesPost = $request->obtenerVariables();

        if (isset($variablesPost['id']) && is_array($variablesPost['id'])) {
            foreach ($variablesPost['id'] as $registroId) {
                $bdObjeto = DB_DataObject::factory($this->nombreDO);
                $bdObjeto->get($registroId);
                $bdObjeto->eliminado = 1;
                $bdObjeto->update();
                $bdObjeto = NULL;
            }
        } else if (isset($variablesPost['registro_id'])) {
            $registroId = $request->obtenerVariablePGR('registro_id');
            $bdObjeto->get($registroId);
            $bdObjeto->eliminado = 1;
            $bdObjeto->update();
        }
        return true;
    }

    public function in_activar() {
        //DB_DataObject::debugLevel(5);		
        $request = new S3Request();
        $bdObjeto = DB_DataObject::factory($this->nombreDO);
        $variablesPost = $request->obtenerVariables();

        if (isset($variablesPost['id']) && is_array($variablesPost['id'])) {
            foreach ($variablesPost['id'] as $registroId) {
                $bdObjeto = DB_DataObject::factory($this->nombreDO);
                $bdObjeto->get($registroId);
                if ($bdObjeto->activo == 0) {
                    $bdObjeto->activo = 1;
                } else {
                    $bdObjeto->activo = 0;
                }
                $bdObjeto->update();
                $bdObjeto = NULL;
            }
        } else if (isset($variablesPost['registro_id'])) {
            $registroId = $request->obtenerVariablePGR('registro_id');
            $bdObjeto->get($registroId);
            if ($bdObjeto->activo == 0) {
                $bdObjeto->activo = 1;
            } else {
                $bdObjeto->activo = 0;
            }
            $bdObjeto->update();
        }
        return true;
    }

    public function buscarXNombre($nombre) {
        $bdObjeto = DB_DataObject::factory($this->nombreDO);

        $bdObjeto->eliminado = 0;

        $bdObjeto->whereAdd("nombre LIKE '" . $nombre . "'");
        $bdObjeto->find();
        $bdObjeto->fetch();
        return $bdObjeto->toArray();
    }

    public function obtenerRegistroxNombre($registro, $modelo = NULL) {
        //DB_DataObject::debugLevel(5);
        if ($modelo === NULL) {
            $bdObjeto = DB_DataObject::factory($this->nombreDO);
        } else {
            $bdObjeto = DB_DataObject::factory($modelo);
        }

        if (property_exists(get_class($bdObjeto), 'eliminado')) {
            $bdObjeto->eliminado = 0;
        }

        $bdObjeto->nombre = $registro;
        $bdObjeto->find();
        $bdObjeto->fetch();
        return $bdObjeto->toArray();
    }

}
