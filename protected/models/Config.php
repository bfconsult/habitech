<?php

class Config extends CActiveRecord {

  /**
   * @return string the associated database table name
   */
  public function tableName() {
    return 'config';
  }




    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
  /**
   * @return array validation rules for model attributes.
   */
  public function rules() {
    // NOTE: you should only define rules for those attributes that
    // will receive user inputs.
    return array(
        array('name', 'required'),
         array('name', 'length', 'max' => 255),
        array('description, name, system_id', 'safe'),
        // The following rule is used by search().
        // @todo Please remove those attributes that should not be searched.
        array('id, name, system_id, create_date, create_user, number', 'safe', 'on' => 'search'),
    );
  }


  public function relations() {

    return array(

        'parent_system' => array(
            self::BELONGS_TO,
            'System',
            'system_id'
        ),
        'creator' => array(
            self::BELONGS_TO,
            'User',
            'create_user'
        ),
    );
  }

 

  /**
   * @return array customized attribute labels (name=>label)
   */
  public function attributeLabels() {
    return array(
        'id' => 'ID',
       
        'system_id' => 'System',
        'name' => 'Name',
        'create_user' => 'Creator',

        'create_date' => 'Date',


    );
  }

    public function getNextNumber($id) {
        $result = 0;
        $max = Config::model()->findAll(array('order'=>'number DESC','limit'=>'1', 'condition'=>'system_id=:x', 'params'=>array(':x'=>$id)));

        if (isset($max[0]['number'])) {

            $result = $max[0]['number'] +1;

        }
        return $result;


    }

    public function getRecentConfigs() {
        /*

        $project=Project::model()->findbyPK(Yii::App()->session['project']);
       $systemList='(-2,';
        foreach ($project->systems as $system) {
            $systemList .= $system['id'].",";
        }
$systemList=rtrim($systemList, ",").')';

        */


        $project = Project::model()->findByPk(Yii::App()->session['project']);
//$data =
        $systems= $project->systems;
        $systemlist='';
        foreach ($systems as $system) {
            $systemlist.=$system->id.',';
        }
        //$systemlist=rtrim($systemlist,',');
        $systemlist='('.$systemlist.'-2)';


            $configs = Config::model()->findAll(array('order' => 'create_date DESC', 'limit'=>10, 'condition' => 'system_id in '.$systemlist.' and deleted =0 '));



        return $configs;


    }

}
