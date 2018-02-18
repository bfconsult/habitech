<?php
$baseUrl = Yii::app()->baseUrl;
?>

<div class="form"> 
	<div class="row">
		<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		        'id'=>'follower-form',
		        'enableAjaxValidation'=>false,
		        'type'=>'horizontal',
		)); ?>
		
		<?php echo $form->errorSummary($model); ?>
		<?php echo $form->hiddenField($model,'type',array('value'=>$type)); ?>
		<?php echo $form->hiddenField($model,'foreign_key',array('value'=>$fk)); ?>
        
	    <p>Choose an existing contact:<p>
        <?php if(isset($error) and $error==1){?>
	 	<div class="alert alert-error">Please select any contact</div>
        <?php } ?>
                    <?php 
		
			//print_r($models);
			
			
			
			//$this->widget('bootstrap.widgets.TbTypeahead', array('model'=>'Contact','name'=>'contact_id','options'=>array('source'=>json_encode($data)))); 
			//echo $form->dropDownListRow($model, 'contact_id', $data ,array('prompt' => 'Select'));?>
            
            <div class="control-group "><label for="Follower_role" class="control-label">Contact</label><div class="controls">
          
            
		            <input type="hidden" id="contact_id" name="Follower[contact_id]" />
   					<input type="text" data-provide="typeahead" class="typeahead" autocomplete="off" required="required">
                    
                    <a href="#" class="btn btn-danger" id="NEdit" style="display:none;"><i class="icon-pencil icon-white"></i></a>
                    <a href="#" class="btn btn-success" id="NContact"><i class="icon-plus icon-white"></i> New</a>
            
            </div></div>

            		
                  

        
                    
                    <?php
					//echo $form->dropDownListRow($model, 'contact_id', array() ,array('prompt' => 'Select','class'=>'js-example-data-ajax'));
					
					  // user can pick between approver, contributor and tester
	    		//$type = array('3'=>'Contributor','3'=>'Viewer','2'=>'Approver','4'=>'Tester');
	    		
                        echo $form->dropDownListRow($model, 'role', Follower::$type);
                        //$upload = array('0'=>'View Only','1'=>'Document Upload');
                        //echo $form->dropDownListRow($model, 'upload', $upload);
                       ?>


                
	    <div class="form-actions">
	        <?php $submit = $model->isNewRecord ? 'Create' : 'Save' ?>
	        <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary','label'=>$submit)); ?>
	    </div>	    

	    <?php $this->endWidget(); ?>
 	</div>
</div>
<!-- form -->
<div class="row">
    <a href="<?php echo UrlHelper::getPrefixLink('contact/create/follow?id=')?><?php echo $fk; ?>">Create contact and invite</a>
</div>

<div id="ContactPopup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="Add Form" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3>New Contact</h3>
  </div>
  <div class="modal-body">
  <form id="NewContactForm" class="form-horizontal" method="post" action="<?php echo Yii::app()->getBaseUrl();  ?>/contact/create/follow?id=<?php echo $fk; ?>">
  	<div class="control-group">
  		<label class="required control-label">First Name<span class="required">*</span></label>
        <div class="controls">
        	<input type="text" name="Contact[firstname]" required="required" />
        </div>
  	</div>
    <div class="control-group">
  		<label class="required control-label">Last Name<span class="required">*</span></label>
        <div class="controls">
        	<input type="text" name="Contact[lastname]" required="required" />
        </div>
  	</div>
    <div class="control-group">
  		<label class="required control-label">Email<span class="required">*</span></label>
        <div class="controls">
        	<input type="email" name="Contact[email]" required="required" />
        </div>
  	</div>
    <div class="control-group">
  		<label class="required control-label">Phone</label>
        <div class="controls">
        	<input type="text" name="Contact[phone]" />
        </div>
  	</div>
    <div class="control-group">
  		<label class="required control-label">Mobile</label>
        <div class="controls">
        	<input type="text" name="Contact[mobile]" />
        </div>
  	</div>
    <div class="control-group">
  		<label class="required control-label">Company<span class="required">*</span></label>
        <div class="controls"> 	
       		<input type="text" name="Company[name]" autocomplete="off" id="companyid" required="required" />
        </div>
  	</div>
    <input type="submit" id="NContactSubmit" value="Submit" style="opacity:0" />
  </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" id="saveContactBtn" >Save</button>
  </div>
</div>

<script type="text/javascript">
$(".typeahead").typeahead({
        minLength: 3,
        source: function(query, process) {
			$(".typeahead")[0].setCustomValidity('Please select any contact');
            $.post('<?php echo Yii::app()->baseUrl;?>/contact/typeahead', { keyword: query, fk:<?php echo $fk; ?> ,type:'<?php echo $type;?>'}, function(response) {
				$('#contact_id').val('');
				$(".typeahead")[0].setCustomValidity('Please select any contact');
				var data = [];
				response=JSON.parse(response);
                for (var i in response) {
                    data.push(response[i].id + "#" + response[i].name);
                }
				
                process(data);
            });

        },
		highlighter: function (item) {
            	var parts = item.split('#');
                html = '<div class="typeahead">';
				html += '<div class="pull-left margin-small">';
				html += '<div class="text-left"><strong>' + parts[1] + '</strong></div>';
				html += '</div>';
				html += '<div class="clearfix"></div>';
				html += '</div>';	
            return html;
        },
        updater: function (item) {
            var parts = item.split('#');
			$(".typeahead")[0].setCustomValidity('');
			$('#contact_id').val(parts[0]);
			$('.typeahead').addClass('disabled');
			$('.typeahead').attr('disabled','disabled');
			$('#NEdit').show();
            return parts[1];
        },

    });
</script>
<script type="text/javascript">
$(document).on('ready',function(){
	$("#companyid").typeahead({
        minLength: 1,
        source: function(query, process) {

            $.post('<?php echo Yii::app()->baseUrl;?>/company/Typeahead', { keyword: query}, function(response) {
				
				var data = [];
				response=JSON.parse(response);
                for (var i in response) {
                    data.push(response[i]);
                }
				if(response.length==0)
				{
					$("span.help-block").remove();
					$('<span class="help-block">New company will be created</span>').insertAfter('#companyid');
				}
				
                process(data);
            });

        },
		highlighter: function (item) {
            	
                html = '<div class="typeahead">';
				html += '<div class="pull-left margin-small">';
				html += '<div class="text-left"><strong>' + item + '</strong></div>';
				html += '</div>';
				html += '<div class="clearfix"></div>';
				html += '</div>';	
            return html;
        },
        updater: function (item) {
			$("span.help-block").remove();
			
            return item;
        },

    });
	
	$('#NContact').on('click',function(e){
		e.preventDefault();
		$('#ContactPopup').modal('show');
	});
	$('#saveContactBtn').on('click',function(e){
		e.preventDefault();
		$('#NContactSubmit').trigger('click');
	});
	
	$('#NEdit').on('click',function(e){
		e.preventDefault();
		$('.typeahead').removeClass('disabled');
		$('.typeahead').removeAttr('disabled');
		$(this).hide();
	});	
	
	
	$('#NewContactForm').on('submit',function(e){
		e.preventDefault();
		$.post($(this).attr('action'),$(this).serialize(),function(res){
			$('#ContactPopup').modal('hide');
			$('#NewContactForm input').val('');
			res=$.parseJSON(res);
			if(typeof(res.id) !='undefined')
			{
				$('#contact_id').val(res.id);
				$('.typeahead').val(res.name);
				$('.typeahead').addClass('disabled');
				$('.typeahead').attr('disabled','disabled');
				$('#NEdit').show();
			}
		});
	});
});
</script>