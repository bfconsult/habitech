<?php

/**
 * This is the model class for table "uses".
 *
 * The followings are the available columns in table 'uses':
 * @property integer $uses
 * @property integer $usedby
 *
 * The followings are the available model relations:
 * @property Usecase $usedby0
 * @property Usecase $uses0
 */
class Uses extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'uses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uses, usedby', 'required'),
			array('uses, usedby', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('uses, usedby', 'safe', 'on'=>'search'),
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
			'usedby0' => array(self::BELONGS_TO, 'Usecase', 'usedby'),
			'uses0' => array(self::BELONGS_TO, 'Usecase', 'uses'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'uses' => 'Uses',
			'usedby' => 'Usedby',
		);
	}

         public function getUses($id)
    {
        $user= Yii::app()->user->id;   
              
        $sql="SELECT `u`.`name`, `u`.`id`
            FROM  `usecase` `u`
            JOIN `uses` `x`
            on `u`.`id`=`x`.`uses`
           WHERE `x`.`usedby`=".$id;
		$connection=Yii::app()->db;
		$command = $connection->createCommand($sql);
		$projects = $command->queryAll();
		return $projects;
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

		$criteria->compare('uses',$this->uses);
		$criteria->compare('usedby',$this->usedby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Uses the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
