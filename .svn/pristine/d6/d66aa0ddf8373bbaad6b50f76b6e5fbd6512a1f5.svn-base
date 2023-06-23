<?php
/*
 * Cuenta.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 03/05/2016
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
 
 * This is the model class for table "cuenta".
 *
 * The followings are the available columns in table 'cuenta':
 * @property integer $id
 * @property string $numero
 * @property string $nombre
 */
class Cuenta extends CActiveRecord
{
    /**
     * Establece la llave primaria
     */
    public function primaryKey() {
        return array('id');
    }
   
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'cuenta';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('id', 'numerical', 'integerOnly'=>true),
                    array('nombre', 'length', 'max'=>70),
                    array('numero', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, numero, nombre', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'numero' => 'Cuenta',
                    'nombre' => 'Nombre',
            );
    }

    /**
     * @return CDbConnection the database connection used for this class
     */
    public function getDbConnection()
    {
            return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cuenta the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }

    
    /*
     * Filtra las cuentas
     */
    public function searchCuenta($numero) {         
        $criteria = new CDbCriteria;        
        
        if ($numero != ''){
            $criteria->addCondition("t.numero ilike '" . $numero . "%' ");
        }
        
        return $this->findAll($criteria);
    }

}
