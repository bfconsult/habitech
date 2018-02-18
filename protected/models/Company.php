<?php

class Company extends CActiveRecord
{



    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }


    public function tableName()
    {
        return 'company';
    }


    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description, owner_id', 'required'),
            array('owner_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('logo_id', 'file', 'types' => 'jpg,jpeg,gif,icon,png', 'maxSize' => 10 * 1024 * 1024, 'allowEmpty' => true),

            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, owner_id', 'safe', 'on' => 'search'),
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
            'owner' => array(self::HAS_ONE, 'User', 'owner_id'),

            'project' => array(self::HAS_MANY, 'Project', 'company_id'),
              );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'foreignid' => 'External Reference',
            'name' => 'Name',
            'description' => 'Description',
            'logo_id' => 'Logo',
            'owner_id' => 'Owner',

        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('owner_id', $this->owner_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }


    public function behaviors()
    {
        return array(
            'company_meta' => array(
                'class' => 'ext.yiiext.behaviors.model.eav.EEavBehavior',
                'tableName' => 'company_meta',
                'entityField' => 'company_id',
                'attributeField' => 'meta_name',
                'valueField' => 'meta_value',
                'modelTableFk' => 'company_id',
                'safeAttributes' => array(),
            )
        );
    }






    public function MetaLoad($key,$default) // key is keyname, default is an array of default values
    {
        $company=User::model()->myCompany();
        //$user = Yii::app()->user->id;


        $metaModel = Company::model()->findByPk($company);
        $meta_key = 'company_'.$metaModel->id.'_'.$key;
        $metaData = $metaModel->getEavAttributes(array($meta_key));
        // print_r($metaData); die;
        if (!empty($metaData[$meta_key])) {
            $metaJson = $metaData[$meta_key];
            // echo $metaJson; die;
            $meta = json_decode($metaJson, true);
            //print_r($meta); die;
        } ELSE {
            $this->MetaErase($key,$default);

           // $metaData = $metaModel->getEavAttributes(array($meta_key));
           // $metaJson = $metaData[$meta_key];
            $meta = $default;//json_decode($metaJson, true);
        }


        return $meta;
    }


    public function MetaSave($key,$meta) // key is keyname, default is an array of default values
    {
        $company = User::model()->myCompany();
        $companyMeta = Company::model()->findByPk($company);
        $meta_key = 'company_' . $companyMeta->id . '_' . $key;
        $companyMeta->setEavAttribute($meta_key, json_encode($meta));
        if($companyMeta->save()){
            return true;
        } ELSE {
      return false;
        }

    }

    public function MetaErase($key,$default)
    {
        $company = User::model()->myCompany();
        $companyMeta = Company::model()->findByPk($company);
        //$user = Yii::app()->user->id;
        $meta_key = 'company_' . $companyMeta->id . '_' . $key;
        $meta = array();
        foreach ($default as $key => $value) {
        $meta[$key] = $value;
         }

        $companyMeta->setEavAttribute($meta_key, json_encode($meta));
        $companyMeta->save();
        return $meta;
    }


}

