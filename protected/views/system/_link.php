
<div class="form">

    <?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'system-form',
        'enableAjaxValidation'=>false,


    ));
$project=Project::model()->findByPk(Yii::App()->session['project']);
    $user=User::model()->findByPk(Yii::App()->user->id);
    ?>

    <div class="row ">
        <select name="Link[system_id]" id="system_id">
            <?php
            $systems= System::model()->findAll('deleted=0 and type=1 and company_id='.$project->company_id);
            $alreadyLinked = $project->systems;
            $linkedSystems=array();

            foreach ($alreadyLinked as $item){
                if(!is_null($item->id)){
                array_push($linkedSystems,$item->id);
            }}

            foreach ($systems as $system){
                if (!in_array($system->id,$linkedSystems)){ ?>

                <option value="<?php echo $system->id?>"><?php echo $system->name?></option>
            <?php }} ?>
        </select>
    </div>
    <div class="row">
        Notes regarding the use of this system:
    </div>
    <div class="row">
       <input type="text" name = "Link[description]" size="80">
    </div>







    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
