<?php
$data = Follower::model()->getMyProjectFollows(1);

        if (count($data)):

$box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => 'Projects I am following',
	'headerIcon' => 'icon-briefcase',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'bootstrap-widget-table')
));?>

<table class="table">
	<thead>
	<tr>
	<th>Company</th>	
        <th>Project</th>
	<th>Actions</th>
	</tr>
	</thead>
        <tbody>

        <?php foreach($data as $item) {?>
        <tr class="odd"> 
            <td>
        <a href="<?php echo UrlHelper::getPrefixLink('/company/view?id=')?><?php echo $item['cid'];?>"><?php echo $item['cname'];?></a>
                
            </td>    
        <td>   
        <a href="<?php echo UrlHelper::getPrefixLink('/project/view?id=')?><?php echo $item['id'];?>&tab=documents"><?php echo $item['name'];?></a>
        </td>
         
        <td>
         <a href="<?php echo UrlHelper::getPrefixLink('/follower/delete?id=')?><?php echo $item['id'];?>"><i class="icon-remove-sign" rel="tooltip" title="Ignore"></i></a> 
       
            
            </td>
        </tr>
       <?php }?>
   	</tbody>
</table>

<?php
$this->endWidget();
endif;
?>
