<?php
/*
 * FtblMoodleCuentaasientointegrado.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 04/02/2019
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
 
 * This is the model class for table "ftbl_moodle_cuentaasientointegrado".
 *
 * The followings are the available columns in table 'ftbl_moodle_cuentaasientointegrado':
 * @property string $debe
 * @property string $haber
 * @property string $glosa
 * @property string $orden
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idasientointegrado
 * @property integer $idcuenta
 */
class FtblMoodleCuentaasientointegrado extends CActiveRecord
{
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
            return 'ftbl_moodle_cuentaasientointegrado';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idasientointegrado, idcuenta', 'numerical', 'integerOnly'=>true),
                    array('debe, haber', 'length', 'max'=>12),
                    array('glosa, orden, fecha, eliminado', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('debe, haber, glosa, orden, fecha, eliminado, idasientointegrado, idcuenta', 'safe', 'on'=>'search'),
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
                    'debe' => 'Debe',
                    'haber' => 'Haber',
                    'glosa' => 'Glosa',
                    'orden' => 'Orden',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idasientointegrado' => 'Idasientointegrado',
                    'idcuenta' => 'Idcuenta',
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

		$criteria->addSearchCondition('t.debe',$this->debe,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.haber',$this->haber,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.glosa',$this->glosa,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.orden',$this->orden,true,'AND','ILIKE');
		 if ($this->fecha != Null) {
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
		$criteria->compare('t.idasientointegrado',$this->idasientointegrado);
		$criteria->compare('t.idcuenta',$this->idcuenta);

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
            return Yii::app()->almacen;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return FtblMoodleCuentaasientointegrado the static model class
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
		$this->glosa=strtoupper($this->glosa);
		$this->fecha= new CDbExpression('NOW()');
        return parent::beforeSave();            
    }

    public function registrar($data=array())
    {
        $cuentaAsientoIntegrado = new FtblMoodleCuentaasientointegrado();
        $cuentaAsientoIntegrado->debe  = $data['debe'];
        $cuentaAsientoIntegrado->haber = $data['haber'];
        $cuentaAsientoIntegrado->glosa = strtoupper($data['glosa']);
        $cuentaAsientoIntegrado->orden = $data['orden'];
//        $cuentaAsientoIntegrado->idgrupo = $data['idgrupo'];
        $cuentaAsientoIntegrado->fecha = new CDbExpression('NOW()');
        $cuentaAsientoIntegrado->eliminado = false;
        $cuentaAsientoIntegrado->idasientointegrado = $data['idasientointegrado'];
        $cuentaAsientoIntegrado->idcuenta = $data['idcuenta'];
        $cuentaAsientoIntegrado->save();
    }

}
