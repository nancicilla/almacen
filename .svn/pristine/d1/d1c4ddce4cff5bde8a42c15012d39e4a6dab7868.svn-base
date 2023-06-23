<?php
/*
 * Alerta.php
 *
 * Version 0.$Rev: 244 $
 *
 * Creacion: 18/11/2015
 *
 * Ultima Actualizacion: $Date: 2015-03-17 10:26:19 -0400 (Tue, 17 Mar 2015) $:
 * 
 * Copyright 2015 SOLUR SRL.
 * Monteagudo esq. Los Sauces, Sucre, Bolivia.
 * Todos los derechos reservados.
 *
 * Este software es información confidencial y de propiedad de SOLUR SRL.
 * Usted no podrá divulgar dicha Información Confidencial y la utilizará 
 * únicamente de acuerdo con los términos del acuerdo de licencia con SOLUR SRL.
 
 * This is the model class for table "alerta".
 *
 * The followings are the available columns in table 'alerta':
 * @property integer $id
 * @property string $descripcion
 * @property string $usuario
 * @property string $fecha
 * @property boolean $eliminado
 * @property integer $idalertatipo
 * @property string $usuarios
 * @property boolean $activadoaccion
 * @property integer $iddocumento
 *
 * The followings are the available model relations:
 * @property Alertatipo $idalertatipo0
 */
class Alerta extends CActiveRecord
{
    public $fechaDesde;
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
    public function tableName()
    {
            return 'alerta';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('idalertatipo, iddocumento', 'numerical', 'integerOnly'=>true),
                    array('usuario', 'length', 'max'=>30),
                    array('descripcion, fecha, eliminado, usuarios', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, descripcion, usuario, fecha, eliminado, idalertatipo, usuarios, iddocumento,fechaHasta,fechaDesde', 'safe', 'on'=>'search'),
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
                    'idalertatipo0' => array(self::BELONGS_TO, 'Alertatipo', 'idalertatipo'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'ID',
                    'descripcion' => 'Descripcion',
                    'usuario' => 'Usuario',
                    'fecha' => 'Fecha',
                    'eliminado' => 'Eliminado',
                    'idalertatipo' => 'Idalertatipo',
                    'usuarios' => 'Usuarios',
                    'iddocumento' => 'Iddocumento',
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

		$criteria->compare('t.id',$this->id);
		$criteria->addSearchCondition('t.descripcion',$this->descripcion,true,'AND','ILIKE');
		$criteria->addSearchCondition('t.usuario',$this->usuario,true,'AND','ILIKE');
		 if ($this->fecha != Null){
		$criteria->addCondition("t.fecha::date = '" . $this->fecha. "'");
		 }
                 
                 if ($this->fechaDesde != Null) {
                    if ($this->fechaHasta == Null) {
                        $this->fechaHasta = new CDbExpression('NOW()');
                    }
                    $criteria->addCondition("t.fecha::date BETWEEN '$this->fechaDesde' AND '$this->fechaHasta'");
                } 
                 
                
		$criteria->compare('t.idalertatipo',$this->idalertatipo);
		$criteria->addSearchCondition('t.usuarios',$this->usuarios,true,'AND','ILIKE');
		
		$criteria->compare('t.iddocumento',$this->iddocumento);

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
    
    public function getFunction(){
        $function="alert('No tiene Accion')";
                if($this->idalertatipo==Alertatipo::$PRODUCTO_NO_DISPONIBLE){
                    $function="Orden.create();";
                }
        return $function;     
    }
    
    public function getRevisado(){
        return str_replace('][', ']<br>[', $this->revusuarios);
    }
    
    public function getshowHtmlTipo(){
        $html='<div style="margin-left:5px;float:left; width:30px; text-align:center; background:'.$this->idalertatipo0->idalertanivel0->color.' ;color:#ffffff;">'
                .$this->idalertatipo0->refnombre. '</div>'
                . '<div style="float:left;margin-left:3px;">'.$this->idalertatipo0->nombre.'</div>';
        return $html;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Alerta the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
    
    
    public function findAlerta($data=array()){
        $idalertatipo=  isset($data['idalertatipo'])?$data['idalertatipo']:-1;
        $iddocumento=  isset($data['iddocumento'])?$data['iddocumento']:-1;
        if($iddocumento!=-1)
           return $this->findByAttributes(array('idalertatipo'=>$idalertatipo,'iddocumento'=>$iddocumento)); 
        else 
           return $this->findByAttributes(array('idalertatipo'=>$idalertatipo,'iddocumento'=>$iddocumento,'desactivado'=>false)); 
    }
    
    public function registerView($data=array()){
        $finalizar=  isset($data['finalizar'])?$data['finalizar']:false;
        
        if($this==null || !isset($data['idalertatipo']))return false;
        if($this->id==null){
            $model=  $this->findAlerta ($data);
            if($model==null) return false;
        }else $model=$this;
        
        
        if($model==null)return;
        $user=Yii::app()->user->getName();
        $fecha = date("d-m-Y H:m:s");
        if(!$finalizar)$model->revusuarios=($model->revusuarios==null?'':$model->revusuarios).'['.$user.','.$fecha.'] ';
        else $model->finalizadousuario=$user.','.$fecha;
        
        return $model->save();
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
		$this->descripcion=strtoupper($this->descripcion);
		
		if($this->id==null){$this->fecha= new CDbExpression('NOW()');
                                    $this->usuario= Yii::app()->user->getName();
                }
		
        return parent::beforeSave();            
    }


}
