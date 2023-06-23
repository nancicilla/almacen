<?php

/*
 * Pedidoespecial.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 09/11/2015
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

 * This is the model class for table "pedidos".
 *
 * The followings are the available columns in table 'pedidos':
 * @property integer $id
 * @property integer $numero
 * @property integer $idestado
 * @property string $fecha
 * @property string $estado
 * @property string $nombrecliente
 * @property string $almacen
 * @property integer $idalmacen
 * @property boolean $almacenconfirm
 */

class Pedidoespecial extends CActiveRecord {

    public $fechaDesde;
    public $fechaHasta;
    public $fechaentregaDesde;
    public $fechaentregaHasta;
    public static $ESTADOVENTA=6;
    public static $ESTADOVENTAESPECIAL=11;
    public static $ESTADOANULADO=3;
    public $producto;

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'pedidoespecial';
    }

    public function primaryKey() {
        return 'id';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('id, numero, idalmacen', 'numerical', 'integerOnly' => true),
            array('estado, almacen', 'length', 'max' => 50),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('usuario,fechaDesde,fechaHasta,fechaentregaDesde,fechaentregaHasta,id, numero, fecha, estado, nombrecliente, almacen, idalmacen, almacenconfirm, producto', 'safe', 'on' => 'search'),
            array('fechaDesde', 'type', 'type' => 'date', 'message' => 'Fecha inicio no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium')),
            array('fechaHasta', 'type', 'type' => 'date', 'message' => 'Fecha fin no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium')),
            array('fechaHasta', 'compareDateRange', 'type' => 'date', 'message' => 'Fecha fin no es una fecha válida.', 'dateFormat' => Yii::app()->locale->getDateFormat('medium')),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
           //'estado0' => array(self::BELONGS_TO, 'Estado_Venta', 'idestado')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'numero' => 'Nº',
            'fecha' => 'Fecha. Sol. Pedido',
            'nombre' => 'Nombre',
            'nombrecliente' => 'Cliente',
            'almacen' => 'Almacén',
            'idalmacen' => 'Almacén',
            'almacenconfirm' => 'Confirmado',
            'usuario'=> 'Usuario',
            'fechaentrega'=> 'Fecha Entrega',
            'idestado'=> 'Estado',
            'fechaDesde'=> 'Desde',
            'fechaHasta'=> 'Hasta',
            'fechaentregaDesde'=> 'Desde',
            'fechaentregaHasta'=> 'Hasta',
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
        
        if ($this->validate()) {
            //$criteria->with = array('estado0','cliente0');
            $criteria->addCondition('t.idestado = '.Estado::model()->idEspecial);
            $criteria->compare('t.id', $this->id);
            $criteria->compare('t.numero', $this->numero);
            $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
            $criteria->addSearchCondition('t.nombrecliente', $this->nombrecliente, true, 'AND', 'ILIKE');
            if ($this->fechaDesde != Null) {
                if ($this->fechaHasta == Null) {
                    $this->fechaHasta = new CDbExpression('NOW()');
                }
                $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaDesde' AND '$this->fechaHasta'");
            }
            
            if ($this->fechaentregaDesde != Null) {
                if ($this->fechaentregaHasta == Null) {
                    $this->fechaentregaHasta = new CDbExpression('NOW()');
                }
                $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaentregaDesde' AND '$this->fechaentregaHasta'");
            }
            
            if ($this->producto != Null) {
                $criteria->join = 'inner join documentoproducto dp on t.id = dp.idpedido
                                   inner join producto p on dp.idproducto = p.id';
                $criteria->addCondition("p.nombre ilike '%" . $this->producto ."%' or p.codigo ilike '%" . $this->producto ."%' ");
            }
            
        } else {
            $criteria->compare('t.id', -1);
        }
        

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,            
            'sort' => array(
                'defaultOrder' => 't.numero desc',
                    'attributes' => array(
                        'fecha' => array(
                            'asc' => 't.fecha::timestamp without time zone',
                            'desc' => 't.fecha::timestamp without time zone DESC',
                        ),
                        'fechaentrega' => array(
                            'asc' => 't.fechaentrega::timestamp without time zone',
                            'desc' => 't.fechaentrega::timestamp without time zone DESC',
                        ),
                        'estado' => array(
                            'asc' => 't.estado',
                            'desc' => 't.estado DESC',
                        ),
                        'nombrecliente' => array(
                            'asc' => 't.nombrecliente',
                            'desc' => 't.nombrecliente DESC',
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
        return Yii::app()->venta;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Pedidoespecial the static model class
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
        return parent::beforeSave();
    }

    /**
     *
     * Sirve para comparar un rango de fechas, verifica que la fecha posterior
     * sea mayor a la fecha inicial, de no ser asi, se añade un error
     * 
     */
    public function compareDateRange($attribute, $params) {
        if (!empty($this->fechaHasta)) {
            if (strtotime($this->fechaHasta) < strtotime($this->fechaDesde)) {
                $this->addError($attribute, 'Fecha fin no puede ser menor a la fecha de inicio.');
            }
        }
    }
    
    /**
     *
     * Verifica si un producto tiene productos faltantes
     * 
     */
    public function getVerificarPedidoProductoFaltante() {
        $connection = Yii::app()->venta;
        $q="select * from documentoproducto where "
                . "idpedido=".$this->id." and eliminado=false and "
                . "faltante is not null ";
        $command = $connection->createCommand($q);
        $tabla = $command->query();
        return sizeof($tabla)>0?1:0;      
    }
    
    public function getDiasentrega(){
        
        if($this->idestado==self::$ESTADOVENTA || $this->idestado==self::$ESTADOVENTAESPECIAL)return 'ENTREGADO';
        
        if($this->idestado==self::$ESTADOANULADO)return 'ANULADO';
        
        return System::dateGetDifDays($this->fechaentrega,date('Y-m-d'));
    }
    
    public function getEstadoHtmlPedido(){
        $html = '';
        $blanco_html = $this->getDivHtmlEstadoPedido('','pedesOculto');
        $sinOP_html = $this->getDivHtmlEstadoPedido('P. E. sin Orden de produccion','pedesSinOP');
        $planificada_html = $this->getDivHtmlEstadoPedido('O. P. planificada','pedesPlanificada');
        $iniciada_html = $this->getDivHtmlEstadoPedido('O. P. iniciada','pedesIniciada');
        $enproceso_html = $this->getDivHtmlEstadoPedido('O. P. en proceso','pedesEnProceso');
        $entrega_html = $this->getDivHtmlEstadoPedido('O. P. en entrega','pedesEntrega');
        //$anulada_html = $this->getDivHtmlEstadoPedido('P. E. anulada','pedesAnulada');
        $cerrada_html = $this->getDivHtmlEstadoPedido('O. P. cerrada','pedesCerrada');
        
        $idpedido = $this->id;
        
        /*variables booleans para verificad los estados de las ordenes*/
        //para verificar los pedidos sin orden de produccion, comparamos la tabla de documentoproducto
        //con las que esten relacionadas en la tabla orden de la BD de Produccion
        $sinOP_bool = false;        
        $numProductos = Yii::app()->venta->createCommand("SELECT count(id) FROM documentoproducto WHERE idpedido = ".$idpedido)
                ->queryScalar();        
        $numOrdenes = Orden::model()->count("idpedido = ".$idpedido);
        if($numProductos != $numOrdenes){            
            $sinOP_bool = true;
        }
                
        $planificada_bool = false;
        $iniciada_bool = false;
        $enproceso_bool = false;
        $entrega_bool = false;
        //$anulada_bool = false;
        $cerrada_bool = false;
        
        $itemsop = Orden::model()->findAll("idpedido = ".$idpedido);
        foreach ($itemsop as $value) {
            switch ($value->idultimoestado){
                case 1://planificada
                    $planificada_bool = true;
                    break;
                case 2://iniciada
                    $iniciada_bool = true;
                    break;
                case 3://en proceso
                    $enproceso_bool = true;
                    break;
                case 4://entrega
                    $entrega_bool = true;
                    break;
                case 7://cerrada
                    $cerrada_bool = true;
                    break;                   
            }
        }
        
        if($sinOP_bool){
            $html .= $sinOP_html;
        }else{
            $html .= $blanco_html;
        }
        
        if($planificada_bool){
            $html .= $planificada_html;
        }else{
            $html .= $blanco_html;
        }
        
        if($iniciada_bool){
            $html .= $iniciada_html;
        }else{
            $html .= $blanco_html;
        }
        
        if($enproceso_bool){
            $html .= $enproceso_html;
        }else{
            $html .= $blanco_html;
        }
        
        if($entrega_bool){
            $html .= $entrega_html;
        }else{
            $html .= $blanco_html;
        }
        
        if($cerrada_bool){
            $html .= $cerrada_html;
        }else{
            $html .= $blanco_html;
        }
        
        return $html;
    }
    
    public function getDivHtmlEstadoPedido($title,$clase){
        return '<div title="'.$title.'" class="'.$clase.'"></div>';
    }
    
}
