<?php 
    if(!isset($addressmodel)){
        $addressmodel = new Addresses;   
    }
?> 
<div class="row" style="margin-bottom:10px">
    <div class="span1"></div>
    <div class="span2"><a class="btn pull-right" id="addDres" style="margin:10px 0px">Add Address</a></div>
    <div style="clear:both"></div>
    
    <div class="addDres clearfix well" style="display:none">
        <?php echo $form->textFieldRow($addressmodel, 'name', array('class'=>'span3')); ?>
        <?php echo $form->textFieldRow($addressmodel, 'address1', array('class'=>'span3')); ?>
        <?php echo $form->textFieldRow($addressmodel, 'address2', array('class'=>'span3')); ?>
        <?php echo $form->textFieldRow($addressmodel, 'city', array('class'=>'span3')); ?>
        <?php echo $form->textFieldRow($addressmodel, 'postcode', array('class'=>'span3')); ?>
        <div class="control-group ">
            <label class="control-label" for="Addresses_country_id">Country:</label>
            <div class="controls">
                <?php echo $form->dropDownList($addressmodel, 'country_id',CHtml::listData(Countries::model()->findAll(), 'id', 'country'), array('class'=>'span2')); ?>
            </div>
        </div> 
        <div class="control-group ">
            <label class="control-label" for="Addresses_state_id">State:</label>
            <div class="controls">
                <?php echo $form->dropDownList($addressmodel, 'state_id', array(), array('class'=>'span2')); ?>
            </div>
        </div>  
        
        <input type="hidden" id="Addresses_type" name="Addresses[type]" value="<?php echo $type?>" />
        
        <?php if(!isset($no_ajax)): ?>
            <a id="addAddressClick" class="btn pull-right" style="margin-right:280px">Create</a>
        <?php endif ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('#addAddressClick').click(function(){
        $('#addDres').parent().parent().append('<img src="/req/themes/bootstrap/img/loading.gif" id="loading"/>');
        var url = '<?php echo CController::createUrl("/addresses/quickAdd")?>';
        var name = $('#Addresses_name').val();
        var add1 = $('#Addresses_address1').val();
        var add2 = $('#Addresses_address2').val();
        var city = $('#Addresses_city').val();
        var postcode = $('#Addresses_postcode').val();
        var country_id = $('#Addresses_country_id').val();
        var state_id = $('#Addresses_state_id').val();
        var type = $('#Addresses_type').val();
        var url_callback = '<?php echo $_SERVER["REQUEST_URI"] ?>';
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                name: name,
                address1: add1,
                address2: add2,
                city: city,
                postcode: postcode,
                state_id: state_id,
                country_id: country_id,
                type: type,
                <?php if(!empty($foreign_key)): ?>
                foreign_key: <?php echo $foreign_key?>
                <?php endif ?>
            },
            success: function(response) {
                window.location.reload();
                
                /* var obj = JSON.parse(response);
                $('.addDres').hide();
                var html = '<div class="row well"><div class="span1"><b>name</b><br/>' +obj.name+'</div>';
                html = html + '<div class="span2"><b>address1</b><br/>' +obj.address1+'</div>';
                html = html + '<div class="span2"><b>address2</b><br/>'+obj.address2+'</div>';
                html = html + '<div class="span2"><b>city</b><br/>'+obj.city+'</div>';
                html = html + '<div class="span1"><a href="/addresses/delete?id='+obj.id+'&returnUrl='+url_callback+'" class="icon-remove"></a></div>';
                html = html + '</div>';

                $('#addDres').parent().parent().append(html);
                $('#loading').remove(); */
            }
        });
    });
    
    //
    $('#Addresses_country_id').change(function(){
        $('#Addresses_state_id').html('<option>Loading ...</option>');
        $.ajax({
            url: '<?php echo CController::createUrl("/addresses/stateOptions?country_id=")?>' + this.value,
            type: 'GET',
            success: function(response) {
                $('#Addresses_state_id').html(response);
            }
        });
    })
    $('#Addresses_country_id').change();
})
</script>