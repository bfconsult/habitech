<?php if ($model):?>
<?php if (!isset($is_not_form)):?>
<form method="POST" action="<?php echo UrlHelper::getPrefixLink('/contentStatus/create')?><?php echo isset($history)?'?history=1':''?>" id="form-<?php echo $model->tableName()?>-<?php echo $model->id?>">
<?php endif;?>
    <input name="ContentStatus[content_type]" type="hidden" value="<?php echo $model->tableName()?>" />
    <input name="ContentStatus[foreign_key]" type="hidden" value="<?php echo $model->id?>" />
    
    <a id="<?php echo $model->tableName()?>-<?php echo $model->id?>" href="javascript:void(0)">
        <img class="imgStatus" src="<?php echo Yii::app()->themeManager->baseUrl.'/bootstrap/img/'.$model->content->Publish->icon; ?>" width="16" height="16"/>
    
        <?php echo $model->content->Publish->status?>
    </a>
    
    <script type="text/javascript">
    $(document).ready(function(){
        $('#<?php echo $model->tableName()?>-<?php echo $model->id?>').tooltip({
            html: true,
            title : '<h4>Status - <?php echo $model->content->Publish->status?></h4>'+
                    '<p style="text-align:left">Note: <?php echo str_replace("
", '<br/>', nl2br($model->content->status_note))?></p>'+
                    '<p style="text-align:left">By <?php echo isset($model->content->User)?$model->content->User->FirstName:''?> <?php echo isset($model->content->User)?$model->content->User->LastName:''?></p>'+
                    '<p style="text-align:left">On <?php echo $model->content->create_date?></p>'
        }).popover({
            html: true,
            placement: '<?php echo isset($placement)?$placement:'bottom'?>',
            title : 'Update Status',
            content: '<?php 
              $html_select = CHtml::activeDropDownList($model->content, 'status',CHtml::listData(
                   PublishStatus::model()->findAll(), 'id', 'status'),
                   array('options' => array($model->content->Publish->id =>array('selected'=>true)),
                                                'id'=>'PublishStatus','class'=>'clearfix'
              ));
            echo str_replace("\n", ' ', $html_select);
            echo '<textarea name="ContentStatus[status_note]"></textarea>';
            echo '<div class="btn-group"><button type="button" onclick="saveStatus(this)" class="btn btn-primary save-status" object_id="'.$model->tableName().'-'.$model->id.'">Save</button>';
            echo '<button type="button" class="btn close-status" onclick="closeStatus(this)" object_id="'.$model->tableName().'-'.$model->id.'">Close</button></div>';
            ?>'
        });
        
        $('#<?php echo $model->tableName()?>-<?php echo $model->id?>').click(function(){
            $('.carousel-inner').css("overflow","inherit");
        });
        
    })
    </script>
    
    <?php if (isset($history) && $history){  
      $this->renderPartial('../elements/status_history', array('model' => $model))  ;
    }
    ?>
<?php if (!isset($is_not_form)):?>
</form>
<?php endif;?>


<?php endif;?>