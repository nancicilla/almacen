<?php
/*
 * ProduccionOrdenrecetaproducto.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 09/04/2019
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
 
 * This is the model class for table "ordenrecetaproducto".
 *
 * The followings are the available columns in table 'ordenrecetaproducto':
 * @property string $cantidad
 * @property string $preciounitario
 * @property string $devolucion
 * @property integer $idproducto
 * @property integer $idordenreceta
 * @property string $fecha
 * @property string $usuario
 * @property boolean $eliminado
 * @property string $fechadevolucion
 * @property boolean $coeficiente
 * @property integer $seguimientoinsumo
 * @property integer $numero
 * @property string $cantidadoriginalreceta
 * @property integer $idtemp
 * @property integer $idnotaborrador
 * @property boolean $reprocesado
 *
 * The followings are the available model relations:
 * @property Devolucionproducto[] $devolucionproductos
 * @property Ordenreceta $idordenreceta0
 * @property Producto $idproducto0
 */
class ProduccionOrdenrecetaproducto extends CActiveRecord
{
    public $coduniversal;
    public $codigo;
    public $nombre;
    public $idunidad;
    public $simbolo;
    public $cantidaddevolucion;
    public $solicitud;
    public $conforme;
    public $cantidadreceta;
    /**
     * Crea un ámbito por defecto que permite añadir condiciones al modelo
     */
    public function defaultScope() {
        return array(
            'condition' => $this->getTableAlias(false, false) .
            '.eliminado = false',
        );
    }
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'ordenrecetaproducto';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idproducto, idordenreceta', 'required'),
                    array('idproducto, idordenreceta, seguimientoinsumo, numero, idnotaborrador', 'numerical', 'integerOnly'=>true),
                    array('cantidad, devolucion, cantidadoriginalreceta', 'length', 'max'=>18),
                    array('preciounitario', 'length', 'max'=>12),
                    array('usuario', 'length', 'max'=>30),
                    array('fecha, eliminado, fechadevolucion, coeficiente, reprocesado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('cantidad, preciounitario, devolucion, idproducto, idordenreceta, fecha, usuario, eliminado, fechadevolucion, coeficiente, seguimientoinsumo, numero, cantidadoriginalreceta, idtemp, idnotaborrador, reprocesado', 'safe', 'on'=>'search'),
            );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
            // NOTE: you may need to adjust the relation name and the related
            // class name for the relations automatically generated below.
            return array(
                    'devolucionproductos' => array(self::HAS_MANY, 'Devolucionproducto', 'idordenrecetaproducto'),
                    'idordenreceta0' => array(self::BELONGS_TO, 'Ordenreceta', 'idordenreceta'),
                    'idproducto0' => array(self::BELONGS_TO, 'Producto', 'idproducto'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'cantidad' => 'Cantidad',
                    'preciounitario' => 'Preciounitario',
                    'devolucion' => 'Devolucion',
                    'idproducto' => 'Idproducto',
                    'idordenreceta' => 'Idordenreceta',
                    'fecha' => 'Fecha',
                    'usuario' => 'Usuario',
                    'eliminado' => 'Eliminado',
                    'fechadevolucion' => 'Fechadevolucion',
                    'coeficiente' => 'Coeficiente',
                    'seguimientoinsumo' => 'Seguimientoinsumo',
                    'numero' => 'Numero',
                    'cantidadoriginalreceta' => 'Cantidadoriginalreceta',
                    'idtemp' => 'Idtemp',
                    'idnotaborrador' => 'Idnotaborrador',
                    'reprocesado' => 'Reprocesado',
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
    public function search()
    {
            // @todo Please modify the following code to remove attributes that should not be searched.

            $criteria=new CDbCriteria;

		$criteria->addSearchCondition('t.cantidad',$this->cantidad,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.preciounitario',$this->preciounitario,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.devolucion',$this->devolucion,true,'AND','ILIKE');
		$criteria->compare('t.idproducto',$this->idproducto);
		$criteria->compare('t.idordenreceta',$this->idordenreceta);
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fechadevolucion != Null) {
		$criteria->addCondition("t.fechadevolucion::date = '" . $this->fechadevolucion. "'");
		 }
		$criteria->compare('t.coeficiente',$this->coeficiente);
		$criteria->compare('t.seguimientoinsumo',$this->seguimientoinsumo);
		$criteria->compare('t.numero',$this->numero);
		$criteria->addSearchCondition('t.cantidadoriginalreceta',$this->cantidadoriginalreceta,true,'AND','ILIKE');
		$criteria->compare('t.idtemp',$this->idtemp);
		$criteria->compare('t.idnotaborrador',$this->idnotaborrador);
		$criteria->compare('t.reprocesado',$this->reprocesado);

            return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                    ), 
                    'criteria'=>$criteria,
            ));
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->produccion;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ProduccionOrdenrecetaproducto the static model class
     */
    public static function model($className=__CLASS__)
    {
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
		$this->fecha= new CDbExpression('NOW()');
		$this->usuario= Yii::app()->user->getName();
        return parent::beforeSave();            
    }

    public function obtenerinsumos($idproducto){
        $criteria = new CDbCriteria;
        
        $criteria->select = 't.idproducto, p.codigo, p.nombre, p.reserva, p.saldo, t.cantidad as cantidadreceta,  p.idunidad, u.simbolo,false as conforme';
        $criteria->join = ' inner join ordenreceta o on t.idordenreceta = o.id
        inner join producto p on t.idproducto = p.id
        inner join receta r on o.id = r.id and r.idreceta is null
        inner join unidad u on p.idunidad = u.id';
        
        $criteria->addCondition("o.idproducto = ".$idproducto);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            'sort' => array(
                        'defaultOrder' => 'p.codigo asc',                            
                        ),               
            ));
    }

}
