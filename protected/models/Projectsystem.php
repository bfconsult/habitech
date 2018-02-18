<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 */
class Projectsystem extends CActiveRecord
{


    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'projectsystem';
    }

    /**
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array(
                'project_id, system_id,create_user',
                'required'
            ),
            array(
                'project_id, system_id,create_user',
                'numerical',
                'integerOnly' => true
            ),

            array(
                'description',
                'safe'
            ),

            array(
                'id, project_id, system_id, create_user,description',
                'safe',
                'on' => 'search'
            )
        );
    }

    /**
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            // 'labelRegions' => array(self::HAS_MANY, 'LabelRegion', 'label_id'),




            'system' => array(
                self::BELONGS_TO,
                'System',
                'system_id'
            ),

            'project' => array(
                self::BELONGS_TO,
                'Project',
                'project_id'

            ),


        );
    }

    /**
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
           'project_id' => 'Project',
            'system_id' => 'System',
            'description'=> 'Description',
            'create_user' => 'Create User',
            'create_date' => 'Create Date'
        )
        ;
    }

    public function behaviors()
    {
        return array(


        );
    }







    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('company_id', $this->company_id);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria
        ));
    }






}
