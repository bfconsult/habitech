<?php //echo $this->renderPartial('/project/head'); ?>

<h3><?php echo CHtml::encode($model->name); ?></h3>
<div class="view">

	


	



<b><?php echo CHtml::encode($model->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($model->description); ?>
	<br />


	<?php //echo CHtml::encode($model->getAttributeLabel('owner_id')); ?>
	<?php //echo CHtml::encode($model->owner->firstname).' '.CHtml::encode($model->owner->lastname); ?>
	<br />

</div>

<?php 

$data = Contact::model()->findAll('company_id='.$model->id.' and companyowner_id='.User::model()->myCompany());
if (count($data)):

    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Employees',
        'headerIcon' => 'icon-user',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class'=>'bootstrap-widget-table')
    ));

?>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>   
            <th>Title</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    
    <tbody>

        <?php foreach($data as $item):?>
        <tr class="odd"> 
            <td>
                <?php echo $item['firstname'];?>
            </td>    
            <td>   
                <?php echo $item['lastname'];?>
            </td>
            <td>   
               
            </td>          
            <td>
                <a href="<?php echo UrlHelper::getPrefixLink('/contact/delete?id=')?><?php echo $item['id'];?>"><i class="icon-remove-sign" rel="tooltip" title="Delete"></i></a> 
            </td>
        </tr>
       <?php endforeach; ?>
    </tbody>
</table>

<?php
$this->endWidget();
endif;
?>

