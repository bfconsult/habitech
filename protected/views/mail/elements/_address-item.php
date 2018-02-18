<div class="view">
    <div class="row">
        <h4><?php echo CHtml::encode($data->name); ?>
        <?php 
            echo "<a href=\"/req/addresses/update?id=".$data->id."\">
            <i class=\"icon-edit\" rel=\"tooltip\" title=\"Edit\"></i></a>&nbsp;&nbsp;";
            echo '<a href="/req/addresses/delete?id='.$data->id .'&returnUrl='.$_SERVER["REQUEST_URI"].'" class="icon-remove"></a>';
        ?>
        </h4>
    </div>
    <div>
        <div class="row">
         
          <div class="span4"><?php echo CHtml::encode($data->address1); ?></div>
        </div>
        <div class="row">
        
          <div class="span4">    <?php echo CHtml::encode($data->address2); ?></div> 
        </div>
        <div class="row">
             <div class="span2"> City : </div> 
               <div class="span4"> <?php echo CHtml::encode($data->city); ?></div> 
        </div>
        <div class="row">
           
            <div class="span4"> <?php echo CHtml::encode(isset($data->state)?$data->state->name:''); ?>   <?php echo CHtml::encode($data->postcode); ?></div> 
        </div>

        <div class="row">
        
              <div class="span4">  <?php echo CHtml::encode(isset($data->country)?$data->country->country:''); ?></div> 
        </div>
    </div>
</div>
