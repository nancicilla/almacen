<?php

/*
 * Vistaordenpedido.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 14/07/2017
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (mar, 17 mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.

 * This is the model class for table "vistaordenpedido".
 *
 * The followings are the available columns in table 'vistaordenpedido':
 * @property integer $id
 * @property integer $numero
 * @property string $fechaplanificada
 * @property string $duracion
 * @property double $multiplicador
 * @property integer $idpedido
 * @property boolean $costoconfirmado
 * @property double $valorcostoconfirmado
 * @property string $costostotales
 * @property string $costos
 * @property boolean $eliminado
 * @property integer $idresponsableorden
 * @property integer $idalmacen
 * @property integer $numerotrabajadores
 * @property double $horastrabajadas
 * @property string $merma
 * @property string $descripcionanulacion
 * @property string $fechaanulacion
 * @property string $usuarioanulacion
 * @property integer $idultimoestado
 * @property string $abrirordenlog
 * @property double $costobruto
 * @property double $costototal
 * @property string $fechaconfirmacioncosto
 * @property double $costounitario
 * @property string $sysnote
 * @property integer $metodocalculocosto
 * @property integer $iddocumentoproductoventa1
 * @property string $iddocumentoproductoventa
 * @property boolean $sincronizado
 * @property integer $productoalmacen
 */

class Vistaordenpedido extends CActiveRecord {
    public $fechaDel;
    public $fechaAl;
    public $idestado;
    public $idproducto;
    public $producto;
    public $usuario;
    //variables para la busqueda por cantidad
    public $cantidadHasta;
    public $cantidadDesde;
    public $idunidad;
    
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function primaryKey() {
        return 'id';
    }

    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'vistaordenpedido';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, numero, idpedido, idresponsableorden, idalmacen, numerotrabajadores, idultimoestado, metodocalculocosto, iddocumentoproductoventa1, productoalmacen', 'numerical', 'integerOnly' => true),
            array('multiplicador, valorcostoconfirmado, horastrabajadas, costobruto, costototal, costounitario', 'numerical'),
            array('duracion', 'length', 'max' => 12),
            array('usuarioanulacion', 'length', 'max' => 30),
            array('fechaplanificada, costoconfirmado, costostotales, costos, eliminado, merma, descripcionanulacion, fechaanulacion, abrirordenlog, fechaconfirmacioncosto, sysnote, iddocumentoproductoventa, sincronizado', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id,cantidadDesde,cantidadHasta,codigo,fechaDel,idestado,usuario,idproducto,producto,fechaAl, numero,idunidad, fechaplanificada,nombre', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
//            'id0' => array(self::BELONGS_TO, 'Ordenreceta', 'id'),
            'idultimoestado0' => array(self::BELONGS_TO, 'Estadoproduccion', 'idultimoestado'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'numero' => 'Nº',
            'fechaplanificada' => 'Fecha Planificada',
            'duracion' => 'Duración',
            'ultimoEstado' => 'Estado',
            'fechaDel' => 'Fecha Desde',
            'fechaAl' => 'Fecha Hasta',
            'idproducto' => 'Producto',
            'producto' => 'Producto',
            'usuario' => 'Usuario',
            'descripcion' => 'Descripción',
            'codigo' => 'Código',
            'nombre' => 'nombre',
            'idordenreceta' => 'idordenreceta',
            'idempleado' => 'idempleado',
            'cantidadDesde' => 'Desde',
            'cantidadHasta' => 'Hasta',
            'cantidadRegistradaOrden' => 'Cantidad',
            'cantidadRegistradaOrdenPorcentaje' => '%',
            'cantidadOrden' => 'Cantidad',
            'cantidadOrdenPorcentaje' => '%',
            'idunidad' => 'Unidad',
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
//        $criteria->with = array('idultimoestado0');
        $criteria->together = true;
//        $criteria->distinct = true;
        $criteria->select =array('t.id,t.numero,t.fechaplanificada,t.duracion,t.multiplicador,t.idpedido,t.costoconfirmado,t.valorcostoconfirmado,t.eliminado,t.idresponsableorden,t.numerotrabajadores,t.horastrabajadas,t.descripcionanulacion,t.fechaanulacion,t.usuarioanulacion,t.idultimoestado,t.costobruto,t.costototal,t.fechaconfirmacioncosto,t.costounitario,t.sysnote,t.metodocalculocosto,t.iddocumentoproductoventa1,t.iddocumentoproductoventa,t.sincronizado,t.codigo,t.nombre,t.simbolo,t.idunidad,t.fecha,t.cantidadproducir,t.usuario');
        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.idunidad', $this->idunidad);

        if ($this->codigo != Null)
            $criteria->addCondition("upper(t.codigo) LIKE '%" . strtoupper($this->codigo) . "%'");

        if ($this->numero != Null)
            $criteria->addCondition("CAST(t.numero AS text) LIKE '%" . $this->numero . "%'");
        if ($this->fechaplanificada != Null) {
            $criteria->addCondition("t.fechaplanificada::date = '" . $this->fechaplanificada . "'");
        }
        $casoCriteriaCantidad = ($this->cantidadDesde != Null && $this->cantidadHasta != Null) * 1 +
                ($this->cantidadDesde != Null && $this->cantidadHasta == Null) * 2 +
                ($this->cantidadDesde == Null && $this->cantidadHasta != Null) * 3;
        switch ($casoCriteriaCantidad) {
            case 1:
                $criteria->addBetweenCondition("t.cantidadproducir", $this->cantidadDesde, $this->cantidadHasta);
                break;
            case 2:
                $criteria->addCondition("t.cantidadproducir >= '" . $this->cantidadDesde . "'");
                break;
            case 3:
                $criteria->addCondition("t.cantidadproducir <= '" . $this->cantidadHasta . "'");
                break;
            default :
        }
        $casoCriteria = ($this->fechaDel != Null && $this->fechaAl != Null) * 1 +
                ($this->fechaDel != Null && $this->fechaAl == Null) * 2 +
                ($this->fechaDel == Null && $this->fechaAl != Null) * 3;
        switch ($casoCriteria) {
            case 1:
                $criteria->addBetweenCondition("t.fecha::date", $this->fechaDel, $this->fechaAl);
                break;
            case 2:
                $criteria->addCondition("t.fecha::date >= '" . $this->fechaDel . "'");
                break;
            case 3:
                $criteria->addCondition("t.fecha::date <= '" . $this->fechaAl . "'");
                break;
            default :
        }

        $criteria->compare('t.idultimoestado',$this->idultimoestado);

        if ($this->producto != Null) {

            $productval = strtoupper($this->producto);

            $criteria->addCondition("(t.nombre) ILIKE '%".$productval."%'");
        }
       
        if ($this->usuario != Null) {

            $criteria->addCondition("upper(t.usuario) LIKE '%" . strtoupper($this->usuario) . "%'");
        }

//        $criteria->addCondition('t.idalmacen not in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[]))');
        $criteria->addCondition('t.productoalmacen in (select unnest(\'{' . CrugeModule::checkAccessAlmacen() . '}\'::int[])) and t.id>0');
        $criteria->group = 't.id,t.numero,t.fechaplanificada,t.duracion,t.multiplicador,t.idpedido,t.costoconfirmado,t.valorcostoconfirmado,t.eliminado,t.idresponsableorden,t.numerotrabajadores,t.horastrabajadas,t.descripcionanulacion,t.fechaanulacion,t.usuarioanulacion,t.idultimoestado,t.costobruto,t.costototal,t.fechaconfirmacioncosto,t.costounitario,t.sysnote,t.metodocalculocosto,t.iddocumentoproductoventa1,t.iddocumentoproductoventa,t.sincronizado,t.codigo,t.nombre,t.simbolo,t.idunidad,t.fecha,t.cantidadproducir,t.usuario';
 
        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.fecha::date desc',
                'attributes' => array(
                    'numero' => array(
                        'asc' => 't.numero',
                        'desc' => 't.numero DESC',
                    ),
                    'ultimoEstado' => array(
                        'asc' => 'idultimoestado0.nombre',
                        'desc' => 'idultimoestado0.nombre DESC',
                    ),
                    'codigo' => array(
                        'asc' => 't.codigo',
                        'desc' => 't.codigo DESC',
                    ),
                    'cantidad' => array(
                        'asc' => 't.cantidadproducir',
                        'desc' => 't.cantidadproducir DESC',
                    ),
                    'usuario' => array(
                        'asc' => 't.usuario',
                        'desc' => 't.usuario DESC',
                    ),
                    'idunidad' => array(
                        'asc' => 't.simbolo',
                        'desc' => 't.simbolo DESC',
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
        return Yii::app()->produccion;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Vistaordenpedido the static model class
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
        $this->descripcionanulacion = strtoupper($this->descripcionanulacion);
        $this->usuarioanulacion = strtoupper($this->usuarioanulacion);
        $this->sysnote = strtoupper($this->sysnote);
        $this->iddocumentoproductoventa = strtoupper($this->iddocumentoproductoventa);
        return parent::beforeSave();
    }

}
