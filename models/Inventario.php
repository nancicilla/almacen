<?php
/*
 * Inventario.php
 *
 * Version 0.$Rev: 1073 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2020-12-04 09:21:16 -0400 (vie, 04 dic 2020) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "inventario".
 *
 * The followings are the available columns in table 'inventario':
 * @property integer $id
 * @property string $descripcion
 * @property string $fechainicio
 * @property string $fechafin
 * @property boolean $eliminado
 * @property string $usuario
 * @property integer $idestado
 * @property integer $numero
 * @property boolean $gestional
 *
 * The followings are the available model relations:
 * @property Estado $idestado0
 * @property Productoinventario[] $productoinventarios
 */
class Inventario extends CActiveRecord {

    public $idAlmacen; // almacen al que pertenece el producto
    public $fechaInicioDel; //limite inferior para busqueda entre rangos 
    //para el campo fecha Inicio
    public $fechaInicioAl; //limite superior para busqueda entre rangos 
    //para el campo fecha Inicio
    public $fechaFinDel; //limite inferior para busqueda entre rangos 
    //para el campo fecha fin
    public $fechaFinAl; //limite superior para busqueda entre rangos para 
    public $fechaHasta;

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
    public function tableName() {
        return 'inventario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('descripcion', 'required','on' => array('insert', 'update')),
            array('fechainicio', 'type', 'type' => 'date', 'dateFormat' => Yii::app()->locale->getDateFormat('medium'), 'on' => 'create'),
//                        array('idAlmacen','readOnly'=>true, 'on'=>'update'),
            array('numero', 'numerical', 'integerOnly' => true),
            array('usuario', 'length', 'max' => 30),
            array('gestional,numero,idAlmacen,descripcion, fechafin, idestado,verificar_saldo_negativo'
                . ' eliminado,fechaInicioDel,fechaInicioAl, fechaFinDel,fechaFinAl', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('numero,id,idAlmacen, descripcion, fechainicio, '
                . 'fechafin, idestado, eliminado, usuario,'
                . 'fechaInicioDel,fechaInicioAl, fechaFinDel,'
                . 'fechaFinAl', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idestado0' => array(self::BELONGS_TO, 'Estado', 'idestado'),
            'productoinventarios' => array(self::HAS_MANY, 'Productoinventario', 'idinventario'),
            'inventarios' => array(self::HAS_ONE, 'Inventarios', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'fechainicio' => 'Fecha Inicio',
            'fechafin' => 'Fecha Finalización',
            'idestado' => 'Estado',
            'eliminado' => 'Eliminado',
            'usuario' => 'Usuario',
            'idAlmacen' => 'Almacén',
            'numero' => 'Nº',
            'fechaInicioDel' => 'Fecha Inicio desde',
            'fechaInicioAl' => 'Fecha Inicio hasta',
            'fechaFinDel' => 'Fecha Finalización desde',
            'fechaFinAl' => 'Fecha Finalización hasta',
            'gestional' => 'Gestional',
            'verificar_saldo_negativo' => 'Verificar Saldo Negativo al Cierre'
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
        $criteria->with = array('inventarios');

        $criteria->compare('t.id', $this->id);

        $criteria->addSearchCondition('t.descripcion', $this->descripcion, true, 'AND', 'ILIKE');

        if ($this->fechainicio != Null) {
            $criteria->addCondition("t.fechainicio::date = '" . $this->fechainicio . "'");
        }

        if ($this->fechafin != Null) {
            $criteria->addCondition("t.fechafin::date = '" . $this->fechafin . "'");
        }

        if ($this->fechaInicioDel != Null) {
            if ($this->fechaInicioAl == Null) {
                $this->fechaInicioAl = new CDbExpression('NOW()');
            }
            $criteria->addCondition("t.fechainicio::date BETWEEN '$this->fechaInicioDel' AND '$this->fechaInicioAl'");
        }

        if ($this->fechaFinDel != Null) {
            if ($this->fechaFinAl == Null) {
                $this->fechaFinAl = new CDbExpression('NOW()');
            }
            $criteria->addCondition("t.fechafin::date BETWEEN '$this->fechaFinDel' AND '$this->fechaFinAl'");
        }

        if ($this->numero != Null) {
            $criteria->addCondition("t.numero = " . (int) $this->numero . "");
        }

        $criteria->compare('t.idestado', $this->idestado);
        $criteria->compare('t.eliminado',0);
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');

        if ($this->idAlmacen != Null) {
            $criteria->compare('inventarios.idalmacen', $this->idAlmacen);
        }

        return new CActiveDataProvider($this, array(
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.fechainicio desc',
                'attributes' => array(
                    'idAlmacen' => array(
                        'asc' => 'inventarios.nombre',
                        'desc' => 'inventarios.nombre DESC',
                    ),
                    'idestado' => array(
                        'asc' => 'inventarios.estado',
                        'desc' => 'inventarios.estado DESC',
                    ),
                    '*',
                ),
            )
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
     * @return Inventario the static model class
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
        $this->descripcion = strtoupper($this->descripcion);
        $this->usuario = Yii::app()->user->getName();
        $this->idestado = Estado::model()->idEstadoIniciado;
        if ($this->scenario == 'create')
            $this->fechainicio = new CDbExpression('NOW()');
        return parent::beforeSave();
    }

    /**
     * Registra todos los productos propios del almacen para su inventario 
     * @param int $pidinventario id del inventario
     * @param int $pidalmacen id del almacen	 
     */
    public function aniadirProductosInventario($pidinventario, $pidalmacen) {
        $command = Yii::app()->almacen->createCommand("select inventario_aniadir_productos(:pidinventario,:pidalmacen)");
        $command->bindValue(":pidinventario", $pidinventario, PDO::PARAM_INT);
        $command->bindValue(":pidalmacen", $pidalmacen, PDO::PARAM_INT);
        $command->execute();
    }

    /**
     * Obtiene el id del almacen a partir de su nombre
     */
    public function getIdAlmacen() {
        $inventarios = Inventarios::model()->
                findByAttributes(array('id' => $this->id));
        $almacen = Almacen::model()->findByAttributes(array('nombre' => $inventarios->nombre));
        return $almacen->id;
    }

    /**
     * Cambia el estado del inventario a anulado
     */
    public function anularInventario() {
        $command = Yii::app()->almacen->createCommand
                ('select "'.getGestionSchema().'".inventario_anular(' . $this->getPrimaryKey() . ');');
        return $command->queryScalar();
    }

    /**
     * Cambia el estado del inventario a cerrado 
     */
    public function cerrarInventario() {
        $command = Yii::app()->almacen->createCommand
                ('select "'.getGestionSchema().'".inventario_cerrar(' . $this->getPrimaryKey() . ');');
        return $command->queryScalar();
    }

    /**
     * Cambia el estado del inventario a iniciado 
     */
    public function reabrirInventario() {
        $command = Yii::app()->almacen->createCommand
                ('select "'.getGestionSchema().'".inventario_reabrir(' . $this->getPrimaryKey() . ');');
        return $command->queryScalar();
    }

    /**
     * Ejecuta la funcion que desencadena el proceso de confirmacion de 
     * diferencias de inventario 
     */
    public function confirmarDiferenciasInventario() {
        $command = Yii::app()->almacen->createCommand('select "'.getGestionSchema().'".inventario_confirmar_diferencias(' . $this->getPrimaryKey() . ',\'' . Yii::app()->user->getName() . '\');');
        return $command->queryScalar();
    }

}