<?php
/*
 * Caracteristica.php
 *
 * Version 0.$Rev: 680 $
 *
 * Creacion: 17/03/2015
 *
 * Ultima Actualizacion: $Date: 2017-04-21 18:33:12 -0400 (vie 21 de abr de 2017) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 *
 * This is the model class for table "caracteristica".
 *
 * The followings are the available columns in table 'caracteristica':
 * @property integer $id
 * @property string $nombre
 * @property string $fecha
 * @property string $usuario
 * @property integer $idgenero
 * @property integer $idcaracteristica
 *
 * The followings are the available model relations:
 * @property Productocaracteristica[] $productocaracteristicas
 * @property Genero $idgenero0
 * @property Caracteristica $idcaracteristica0
 * @property Caracteristica[] $caracteristicas
 */
class Caracteristica extends CActiveRecord
{
    public $nombrecaracteristica;
    public $nombresubcaracteristica;
    public $idsubcaracteristica;
    public $valor;
    const FOTOGRAFIA = 40;

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
        return 'caracteristica';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nombre,idgenero', 'required','on' => array('insert', 'update')),
            array('nombre', 'unico','on' => array('insert', 'update')),
            array('idgenero, idcaracteristica', 'numerical', 'integerOnly' => true),
            array('nombre, usuario', 'length', 'max' => 30),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, nombre, fecha, usuario, idgenero,idcaracteristica', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'idgenero0' => array(self::BELONGS_TO, 'Genero', 'idgenero'),
            'productocaracteristicas' => array(self::HAS_MANY, 'Productocaracteristica', 'idcaracteristica'),
            'idcaracteristica0' => array(self::BELONGS_TO, 'Caracteristica', 'idcaracteristica'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'nombre' => 'Nombre',
            'fecha' => 'Fecha',
            'usuario' => 'Usuario',
            'idgenero' => 'Tipo',
            'idcaracteristica' => 'Característica padre',
            'orden' => 'Ordenar',
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
        $criteria->with = array('idcaracteristica0');

        $criteria->compare('t.id', $this->id);
        $criteria->addSearchCondition('t.nombre', $this->nombre, true, 'AND', 'ILIKE');
        if ($this->fecha != Null) {
            $criteria->addCondition("t.fecha::date = '" . $this->fecha . "'");
        }
        $criteria->addSearchCondition('t.usuario', $this->usuario, true, 'AND', 'ILIKE');
        $criteria->compare('t.idgenero', $this->idgenero);
        $criteria->compare('t.eliminado',0);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Yii::app()->user->getState('pageSize', Yii::app()->params['defaultPageSize']),
            ),
            'sort' => array(
                'defaultOrder' => 't.nombre asc',
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
     * @return Caracteristica the static model class
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
        if($this->scenario == "personalizar")
            return parent::beforeSave();
        
        if ($this->isNewRecord) {
            $this->fecha = new CDbExpression('NOW()');
            $this->usuario = Yii::app()->user->getName();
        }
        return parent::beforeSave();
    }

    /**
     * Verifica si una caracteristica puede ser eliminada o no, verifica que no
     * existan dependencios con producto ni con características hijas
     * @param string $cid id de la caracteristica a verificar
     * @return resultado de la funcion, devuelve true o false
     */
    public function isEliminable($pid) {
        $command = Yii::app()->almacen->createCommand("select caracteristica_es_eliminable(".$pid.")");
        return $command->queryScalar();
    }

    /**
     * Antes de borrar verificar que el almacen no tenga asociado productos, otros
     * almacenes o cuentas contables, en caso de no cumplir con las condiciones
     * se muestra una excepción y no se lleva a cabo la eliminación.
     */
    protected function beforeSafeDelete() {
        $aux =$this->isEliminable($this->id);
        if ($aux!=='exito') {
            echo System::messageError($aux);
            return;
        } else {
            return parent::beforeSafeDelete();
        }
    }

    /**
     *
     * Antes de validar cambia el campo nombre a mayúsculas  
     * 
     */
    public function beforeValidate() {
       // $this->nombre = strtoupper($this->nombre);
        return parent::beforeValidate();
    }

    /**
     * Verifica si la caracteristica es padre de ser asi devuelve true
     * @param string $pid id del almacen a verificar
     * @return resultado de la funcion, devuelve true o false
     */
    public function isPadre($pid) {
        $command = Yii::app()->almacen->createCommand("select exists (select * from caracteristica where idcaracteristica =:pid)");
        $command->bindValue(":pid", $pid, PDO::PARAM_INT);
        return $command->queryScalar();
    }

    /**
     *
     * Verifica si el nombre  y la caracteristica padre son unicos para las 
     * caracteristicas de tipo general y si el nombre es único para las 
     * caracteristicas de tipo imagen         
     * @param modelAttribute $attribute Atributo a validar
     */
    public function unico($attribute) {
        if ($this->idgenero == Genero::model()->GENEROGENERAL) {
            $condicionAdicional = 'and idgenero=' . Genero::model()->GENEROGENERAL;
            if (!empty($this->idcaracteristica)) {
                $condicionAdicional .= ' and idcaracteristica=' . $this->idcaracteristica;
            } else {
                $condicionAdicional .= ' and idcaracteristica is null';
            }
            $respuestaAdicional = ' y Caraterística padre ya existen.';
        } else {
            $condicionAdicional = 'and idgenero=' . Genero::model()->GENEROARCHIVO;
            $respuestaAdicional = ' ya existe.';
        }
        if (!empty($this->id)) {
            $condicionAdicional .= ' and id<>' . $this->id;
        }
        $cantidad = count(Caracteristica::model()->findAll(array('condition' => 'nombre=\'' . $this->nombre . '\'' . $condicionAdicional)));

        if ($cantidad > 0) {
            $this->addError($attribute, "Este Nombre" . $respuestaAdicional);
        }
    }
          /**
     * Verifica si la caracteristica tiene hijos
     * @param Integer $pid id de la caracteristica a verificar
     * @return boolean true si tiene hijos
     */
    public function tieneHijo($pid) {
        $retorno=true;
        $criteria = new CDbCriteria;
        $criteria->compare('idcaracteristica', $pid);
        
        if(!count($this->model()->findAll($criteria))>0){
            $retorno= false;
        }
        return $retorno;
    }
    
    public function obtieneCaracteristica($idalmacen)
    {
        $criteria = new CDbCriteria;
        $criteria->select = "t.id, t.nombre as nombrecaracteristica, t.usuario, "
                            ."x.pidcaracteristica as idcaracteristica, x.psubcaracteristica as nombresubcaracteristica, x.pidsubcaracteristica as idsubcaracteristica,"
                            ."t.ordeninsumo, t.ordenterminado ";
        $criteria->join = "INNER JOIN
        (
            select pid, pidcaracteristica, psubcaracteristica, pidsubcaracteristica, pordeninsumo, pordenterminado
            from obtienecaracteristicasporalmacen(".$idalmacen.")
        )x ON t.id = x.pid
        ";
        $criteria->compare('t.idgenero', 2);

        return new CActiveDataProvider($this, array(
            'pagination' => false,
            'criteria' => $criteria,
            
            'sort' => array(
                'defaultOrder' => $idalmacen == 3? 
                    "x.pordenterminado asc, idsubcaracteristica asc" : "x.pordeninsumo asc, idsubcaracteristica asc",
            ),
        ));
    }

}
