<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-forgot-pass-form',
	'enableAjaxValidation'=>false,
        'enableClientValidation' => true,
        'clientOptions'=>array('validateOnSubmit'=>true,
            'afterValidate' => 'js:function(form, data, hasError) {
                if(hasError)
                    return;
                
                $.ajax({
                    url: "'.UrlHelper::getPrefixLink("/site/forgotpassword").'",
                    type: "POST",
                    data: form.serialize(),
                    dataType: "JSON",
                    success: function(data) {
                       
                        if(data.success) {
                            $("#forgot_password_msg").html(data.message);
                            $("#forgot_password_body").hide();
                            $("#forgot_password_msg").show();
                        }
                        $.each(data, function(key, value) {
                            $("#serversideError").show();
                            $("#serversideError").html(data.message);
                             setTimeout(function(){$("#serversideError").hide();}, 10000);
                        });
                    }
                });
            }'
        )
)); ?>
    
    <div id="forgot_password_body">
        <div class="row">
	<p class="span6 offset1">Enter your email, a reset link will be sent to this email</p>
    </div>
	<div class="row">
            <div class="span6 offset1">
                <?php  echo $form->labelEx($model,'email'); ?>
		<?php  echo $form->textField($model,'email'); ?>
		<?php  echo $form->error($model,'email'); ?>
            </div>
		
	</div>
        <div class="row">
            <div class="span6 offset1" id="serversideError" style="color:red">
                
            </div>
		
	</div>
	<div class="row">
            <div class="span6 offset1">
                <?php echo CHtml::submitButton('Submit',  array('class'=>'btn btn-primary')); ?>
            </div>
		
	</div>
    </div>
    <div id="forgot_password_msg"> 
        
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->