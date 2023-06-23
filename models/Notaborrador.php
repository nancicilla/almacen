<?php

/*
 * Notaborrador.php
 *
 * Version 0.$Rev: 806 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2018-03-21 09:30:32 -0400 (Wed 21 de Mar de 2018) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "notaborrador".
 *
 * The followings are the available columns in table 'notaborrador':
 * @property integer $id
 * @property string $glosa
 * @property string $fecha
 * @property boolean $eliminado
 * @property string $usuario
 * @property integer $idtipo
 * @property integer $idorigen
 *
 * The followings are the available model relations:
 * @property Productonotaborrador[] $productonotaborradors
 */

class Notaborrador extends CActiveRecord {

    public $fechaInicio; //busqueda entre rangos
    public $fechaFin; //busqueda entre rangos
    public $idalmacenOrigen;
    public $idalmacenDestino;
    public $norden;
    public $idcausa;
    public $detalle;
    public $costovariable;
    public $color;
    public $cambiarcosto;
    public $ingesp;
    public $baja;

    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {     
       if (Yii::app()->user->getName() == 'invitado') {
            return array(
                'condition' => $this->getTableAlias(false, false) .
                '.eliminado = false'
            );
        } else {
            return array(
                'condition' => $this->getTableAlias(false, false) .
                '.eliminado = false'
                . ' and ' . $this->getTableAlias(false, false) .
                '.idalmacen in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[]))',
            );
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'notaborrador';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('fecha', 'required', 'on' => array('update')),
            array('idalmacenOrigen,idalmacenDestino', 'required', 'on' => array('traspaso')),
            array('idorigen,idalmacen,idtipodocumento,idcausa', 'required', 'on' => array('insert', 'update')),
            array('fecha', 'type', 'type' => 'date', 'message' => 'Fecha no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'except' => array('anular', 'nota')),
            array('idtipo, idorigen, idestado', 'numerical', 'integerOnly' => true),
            array('usuario', 'length', 'max' => 30),
            array('fechaFin', 'compareDateRange', 'type' => 'date', 'message' => 'Fecha fin no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'except' => array('anular')),
            array('fechaInicio', 'type', 'type' => 'date', 'message' => 'Fecha inicio no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'except' => array('anular')),
            array('fechaFin', 'type', 'type' => 'date', 'message' => 'Fecha fin no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'except' => array('anular')),
            array('fechaFin,fechaInicio', 'required', 'on' => 'checked'),
            array('glosa,eliminado,idalmacenOrigen,idalmacenDestino,total,idasientointegrado,idcausa', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,idalmacen, glosa, fecha, eliminado, usuario, idtipo, idtipodocumento, '
                . 'fechaInicio,fechaFin,idorigen,norden,idcausa', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idtipo0' => array(self::BELONGS_TO, 'Tipo', 'idtipo'),
            'productonotaborradors' => array(self::HAS_MANY, 'Productonotaborrador', 'idnotaborrador'),
            'idorigen0' => array(self::BELONGS_TO, 'Origen', 'idorigen'),
            'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
            'idalmacen0' => array(self::BELONGS_TO, 'Almacen', 'idalmacen'),
            'idtipodoc0' => array(self::BELONGS_TO, 'Tipodocumento', 'idtipodocumento'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'glosa' => 'Glosa',
            'fecha' => 'Fecha',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
            'idtipo' => 'Movimiento',
            'idorigen' => 'Origen',
            'fechaInicio' => 'Fecha desde',
            'fechaFin' => 'Fecha hasta',
            'idalmacenOrigen' => 'Almacén Origen',
            'idalmacenDestino' => 'Almacén Destino',
            'idestado' => 'Estado',
            'idalmacen' => 'Almacén',
            'idtipodocumento' => 'Documento',
            'numero' => 'Nº Nota',
            'norden'=>'Nº O.P.',
            'idcausa'=> 'Causa',
            'iddetallenota' => 'Detalle',
            'cambiarcosto'=>'Cambiar Costo'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        $criteria->with = array('idtipodoc0');

        if ($this->validate()) {
            $criteria->compare('t.id', $this->id);
            $criteria->compare('t.idalmacen', $this->idalmacen);
            if ($this->norden != Null) {
                $criteria->addCondition("t.glosa ilike '%O.P. Nº " . $this->norden. " %'");
            }
            $criteria->addSearchCondition('t.glosa', $this->glosa, true, 'AND', 'ILIKE');
            if ($this->fecha != Null) {
                $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
            }
            $criteria->compare('t.eliminado', 0);
            $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
            $criteria->compare('t.idtipo', $this->idtipo);
            $criteria->compare('t.idorigen', $this->idorigen);
            $criteria->compare('t.idestado', $this->idestado);
            $criteria->compare('t.idtipodocumento', $this->idtipodocumento);
            if ($this->fechaInicio != Null) {
                if ($this->fechaFin == Null) {
                    $this->fechaFin = new CDbExpression('NOW()');
                }

                $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaInicio' AND '$this->fechaFin'");
            }
        } else {
            $criteria->compare('t.idorigen', -10);
        }
        Yii::app()->session['notaBorradorLote'] = $criteria;
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.numero desc',
                'attributes' => array(
                    'idtipodocumento' => array(
                        'asc' => 'idtipodoc0.nombre',
                        'desc' => 'idtipodoc0.nombre DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection() {
        return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Notaborrador the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     *
     * Sentencias entes de ejecutar metodo save
     * Antes de guardar se cambia todos los campos  de tipo character
     * varying y text a mayúsculas
     * Si existe el campo fecha, este toma el valor de la fecha actual antes
     * de almacenarse
     * Si existe el campo usuario, toma el valor del usuario actual antes de
     * almacenarse
     * 
     */
    public function beforeSave() {
        if ($this->scenario != "anular") {
            $this->glosa = strtoupper($this->glosa);
            $this->fecha = new CDbExpression('NOW()');

            if (isset(Yii::app()->session['var']))
                $this->usuario = Yii::app()->session['var'];
            else
                $this->usuario = Yii::app()->user->getName();
        }
        return parent::beforeSave();
    }

    /**
     *
     * Sirve para comparar un rango de fechas, verifica que la fecha posterior
     * sea mayor a la fecha inicial, de no ser asi, se añade un error
     * 
     */
    public function compareDateRange($attribute, $params) {
        if (!empty($this->fechaFin)) {
            if (strtotime($this->fechaFin) < strtotime($this->fechaInicio)) {
                $this->addError($attribute, 'Fecha fin no puede ser menor a la fecha de inicio.');
            }
        }
    }

    /**
     * Ejecuta la funcion que desencadena el proceso de confirmacion de 
     * diferencias de inventario 
     */
    public function confirmarNotaBorrador() {
        $command = Yii::app()->almacen->createCommand("select notaborrador_confirmar(" . $this->getPrimaryKey() . ",'" . Yii::app()->user->getName() . "');");
        return $command->queryScalar();
    }

    public function cambiaEstadoOrdenEnProceso() {
        //El estado de la orden de produccion deb estar en estado iniciado=2, 
        $orden = new WSOrden;
        $docid = $this->iddocumento;
        $estado = $orden->getUltimoEstadoOrden($docid); //<<<--- El estado debe ser 2=Iniciado
        
        if($estado = 2) {
            //La nota borrador generada; iddocumento=id de la orden,idtipo=2 salida, idorigen=4 produccion
            if ($this->idtipo = 2 && $this->idorigen = 4) {
                $usuario = Yii::app()->user->getName();
                $ordenEstado = new WSOrden;
                $respuesta = $ordenEstado->nuevoEstadoOrden($docid, $usuario);
                
                if ($respuesta == 0) {
                    //no hubo ningun error
                } else {
                    //ocurrió algún error
                }
            }
        }
    }
    
    /**
     * Registra una nota borrador en el almacen
     * @param string $glosa
     * @param integer $tipo
     * @param integer $idOrigen
     * @param array[idproducto,cantidad] $producto
     * @return string
     */
    public function registrarNotaBorrador($glosa, $tipo, $idOrigen) {
        return 'Exito';
    }

    /**
     * Función que genera un numero de orden ya sea consecutivo
     * o que rellena los numeros faltantes
     * @return type
     */
    public function generarNumero() {
        return Yii::app()->almacen->createCommand("SELECT MAX(numero) "
                        . "FROM notaborrador where eliminado=false")->queryScalar() + 1;
    }

    /**
     * Esta función actualiza el precio unitario de OrdenRecetaProducto
     */
    public function actualizarPrecioUnitarioOrdenRecetaProducto() {
        //El estado de la orden de produccion deb estar en estado iniciado=2, 
        $orden = new WSOrden;
        $docid=$this->iddocumento;
        $respuesta=$orden->updatePrecioUnitarioOrdenRecetaProducto($docid,$this->id);        
    }
    
    /**
     * Registro de la notaborrador y productonotaborrador al realizar el traspaso, este registro ocurre por salida del almacen de origen
     * @param type $idalmacenorigen
     * @param type $idalmacendestino
     * @param type $productosorigen
     * @param type $productosdestino
     * @param type $glosa
     * @param type $idnota
     * @return array
     */
    public function registroIngresoTraspasoEntreAlmacenes($arrayParametros){
        $idalmacenorigen = $arrayParametros['idalmacenorigen'];
        $idalmacendestino = $arrayParametros['idalmacendestino'];
        $productosorigen = $arrayParametros['productosorigen'];
        $productosdestino = $arrayParametros['productosdestino'];
        $glosa = $arrayParametros['glosa'];
        $idnota = $arrayParametros['idnota'];
        $numeroNota = $arrayParametros['numeroNota'];

        $model = new Notaborrador;
        $model->setScenario("TraspasoEntreAlmacenes");
        $model->idalmacen = $idalmacendestino;
        $idAlmacenProductosEnProceso = Almacen::model()->idAlmacenProductosEnProceso;
        $model->idcontracuenta = Almacen::model()->findBySql('select idcuenta from almacen where id = ' . $idAlmacenProductosEnProceso)->idcuenta;
        
        $model->glosa = 'TRASPASO ENTRE ALMACENES POR NOTA N° '.$numeroNota.' - ' . $glosa;
        $model->idtipo = Tipo::model()->INGRESO;
        $model->idtipodocumento = Tipodocumento::model()->TRASPASO;
        $model->idorigen = Origen::model()->ALMACEN;
        $model->numero = Notaborrador::model()->generarNumero();
        $model->iddocumento = $idnota;//id nota por salida del almacen origen

        $model->total=0;                 
        for($k=1;$k<=count($productosdestino);$k++){            
            $model->total+=$productosorigen[$k]['cantidad'];
        } 
        
        if ($model->save()) {
            $cantidad = count($productosdestino);
            for ($index = 1; $index <= $cantidad; $index++) {
                $modelProductonotaborrador = new Productonotaborrador;
                $modelProductonotaborrador->setScenario("TraspasoEntreAlmacenes");
                $modelProductonotaborrador->glosa = "TRASPASO ENTRE ALMACENES - ".$glosa;
                if($productosdestino[$index]['costo'] != $productosdestino[$index]['costoHidden'])
                    $modelProductonotaborrador->costo = $productosdestino[$index]['costo'];
                
                $modelProductonotaborrador->ingreso = round($productosorigen[$index]['cantidad'], 4);
                $modelProductonotaborrador->salida = 0;
                $modelProductonotaborrador->idproducto = $productosdestino[$index]['idproducto'];
                $modelProductonotaborrador->idnotaborrador = $model->id;
                if (!$modelProductonotaborrador->save()) {
                    $error = 'Traspaso Entre Almacenes. No se registró producto nota borrador: numero nota borrador ' . $model->numero;
                    throw new CException($error);
                }
            }
            unset(Yii::app()->session['var']);
            $respuestaws = $model->id;
        } else {
            $error = 'No se registró la nota borrador. Traspaso Entre Almacenes';
            throw new CException($error);
        }
        return array('mensaje'=>'Sin errores','error'=>false);
    }
    
    public function registrarNotaBorradorTpv($glosa, $arrayProducto, $idalmacen, $iddocumento) {
        
//          glosa text

        $modelNotaborrador = new Notaborrador;
        $modelNotaborrador->setScenario('tpv');
        $modelNotaborrador->glosa = $glosa;
        $modelNotaborrador->numero = $this->generarNumero();
        $modelNotaborrador->idtipo = Tipo::model()->INGRESO;
        $modelNotaborrador->idorigen = 5;
        $modelNotaborrador->iddocumento = $iddocumento;
        $modelNotaborrador->idtipodocumento = Tipodocumento::TRASPASO;
        $modelNotaborrador->idalmacen= $idalmacen;
        $idcuenta = FtblMoodleCuentasespeciales::TRANSITO;
        $modelNotaborrador->idcontracuenta = Yii::app()->tpv->createCommand("select idcuenta from ftbl_moodle_cuentasespeciales where id = " . $idcuenta)->queryScalar();

        $modelNotaborrador->total=0;                 
        for($k=0;$k<count($arrayProducto);$k++){            
            $modelNotaborrador->total+=$arrayProducto[$k]['cantidadenviada']-$arrayProducto[$k]['cantidadsolicitada'];
        }
        if ($modelNotaborrador->save()) {
            $cantidad = count($arrayProducto);
            for ($index = 0; $index < $cantidad; $index++) {
                $modelProductonotaborrador = new Productonotaborrador;
                $modelProductonotaborrador->scenario = 'miUsuario';
                $modelProductonotaborrador->glosa = $glosa;
                $modelProductonotaborrador->ingreso = round($arrayProducto[$index]['cantidadenviada']-$arrayProducto[$index]['cantidadsolicitada'], 4);
                $modelProductonotaborrador->salida = 0;
                $modelProductonotaborrador->idproducto = $arrayProducto[$index]['idproducto'];
                $modelProductonotaborrador->idnotaborrador = $modelNotaborrador->id;
                if (!$modelProductonotaborrador->save()) {
                    $error = 'No se registró producto nota borrador: numero nota borrador ' . $modelNotaborrador->numero;
                    throw new CException($error);
                }
            }
        }else{
            $error = 'No se registró la nota borrador';
            throw new CException($error);
        }
        return array('mensaje'=>'Sin errores','error'=>false);
    }
}
