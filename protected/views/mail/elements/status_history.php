<style>.grid-view{padding-top: 0px;}</style>
<?php if ($model):
    //change starts here
    $criteria=new CDbCriteria;
    
    $criteria->compare('content_type', $model->tableName(),true);
    $criteria->compare('foreign_key', $model->id);
    $criteria->order ='id';
    
    $model_status=new ContentStatus('search');
    $model_status->unsetAttributes();  // clear any default values
        
    $statuses = new CActiveDataProvider(get_class($model_status), array(
    	'criteria'=>$criteria,
    ));
    
    $this->widget('bootstrap.widgets.TbGridView', array(
        'type'=>'striped bordered condensed',
        'enableSorting' => false,
        'summaryText' => '',
        'dataProvider'=>$statuses,
        'columns'=>array(
            array('name'=>'status', 'header'=>'Status', 'value' => '$data->showStatus()', 'type'=> 'raw'),
            array('name'=>'status_note', 'header'=>'Note'),
            array('value'=>'$data->User->FirstName ." ". $data->User->LastName', 'header'=>'By'),
            array('name'=>'create_date', 'header'=>'Date')
        ),
    )); 
endif;?>