
<?php echo $form->textAreaRow($model,'description',array('class'=>'span3', 'cols'=>50)); ?>
<?php echo $form->hiddenField($model,'companyowner_id',array('value'=>User::model()->myCompany())); ?>

<?php echo $form->dropDownListRow($model,'organisationtype',
                CHtml::listData(Organisationtype::model()->findAll(),'id','name'),array('class'=>'span3'));  ?>


<script type="text/javascript">
    $(document).ready(function(){
        $('#Company_organisationtype').change(function(){
            var valOrg = $('#Company_organisationtype').val();
            if(valOrg == 1 || valOrg == 2){
                $('.selectThis').css('display','block');
            } else {
                $('.selectThis').css('display','none');
            }
        })
    })
</script>

