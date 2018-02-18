<?php

/**
 * This is the model class for table "project".
 *
 * The followings are the available columns in table 'project':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 */
class Project extends CActiveRecord
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
        return 'project';
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
                'name, company_id',
                'required'
            ),
            array(
                'company_id',
                'numerical',
                'integerOnly' => true
            ),
            array('description', 'safe'),
            array(
                'name, icon',
                'length',
                'max' => 255
            ),

            array(
                'extlink',
                'length',
                'max' => 50
            ),
            array(
                'stage',
                'length',
                'max' => 4
            ),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array(
                'id, name, description, icon, company_id,stage',
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
            'company' => array(
                self::BELONGS_TO,
                'Company',
                'company_id'
            ),

            'follower' => array(
                self::HAS_MANY,
                'Follower',
                'project_id'

            ),

            'systems' => array(self::MANY_MANY, 'System', 'projectsystem(project_id, system_id)','condition'=>'systems_systems.deleted = 0'),


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
            'name' => 'Name',
            'description' => 'Description/Notes',
            'icon'=>'Icon',
            'company_id' => 'Company',
            'budget' => 'Budget',
            'stage' => 'Stage',
            'extlink' => 'External Link'
        )
        ;
    }

    public function behaviors()
    {
        return array(
            'user_meta' => array(
                'class' => 'ext.yiiext.behaviors.model.eav.EEavBehavior',
                'tableName' => 'project_meta',
                'entityField' => 'project_id',
                'attributeField' => 'meta_name',
                'valueField' => 'meta_value',
                'modelTableFk' => 'project_id',
                'safeAttributes' => array()
            )
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
