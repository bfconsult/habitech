<div  style="min-height: 400px!important;">
    
<div  style="clear:both; text-align:center; margin: 0 auto; float: none!important; padding: 0px 5px 0px 5px;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-resend-form',
	'enableAjaxValidation'=>true,
        //'enableClientValidation' => true,
        //'clientOptions'=>array('validateOnSubmit'=>true,'validateOnChange'=>true)
)); ?>

	<p class="note">Please enter the following details</p>

	<?php echo $form->errorSummary($model); ?>
<div id="reset_password_body">
	<div class="row" style="position: relative;margin-bottom: 2px;height:50px;">
		<?php //echo $form->labelEx($model,'New Password'); ?>
            <div class="w100">
		<?php echo $form->passwordField($model,'password', array('class' => 'login-input border-box', 'placeholder' => 'New Password','style'=>'margin:0px')); ?>
		<?php echo $form->error($model,'password', array('style' => 'font-size:12px;margin:0px;padding:0px;')); ?>
            </div>
	</div>
        
        <div class="row">
		<?php //echo $form->labelEx($model,'Confrim Password'); ?>
            <div class="w100" style="position: relative;margin-bottom: 2px;height:50px;">
		<?php echo $form->passwordField($model,'cpassword', array('class' => 'login-input border-box', 'placeholder' => 'Confrim Password','style'=>'margin:0px')); ?>
		<?php echo $form->error($model,'cpassword', array('style' => 'font-size:12px;margin:0px;padding:0px;')); ?>
            </div>
	</div>

	<div class="row buttons">
            
		<?php echo CHtml::ajaxSubmitButton('Submit', $form->action, array(
                    'dataType' => 'JSON',
                    'success' => "js:function(data) {
                
                        if(data.success) {
                            
                            $('.note').html(data.message);
                            $('#reset_password_body').hide();
                        }
                        jQuery.each(data, function(key, value) {
                            jQuery('#'+key+'_em_').show().html(value.toString());
                            jQuery('#'+key).parent('div').addClass('error');
                        });
                    }"
                ), array('class' => 'btn btn-primary')); ?>
	</div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->
</div>