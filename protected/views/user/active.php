<?php
$limit=50;

$data = User::model()->mostActive(0);

        if (count($data)):

$box = $this->beginWidget('bootstrap.widgets.TbBox', array(
	'title' => 'Users',
	'headerIcon' => 'icon-person',
	// when displaying a table, if we include bootstra-widget-table class
	// the table will be 0-padding to the box
	'htmlOptions' => array('class'=>'bootstrap-widget-table')
));
            $moods = User::model()->overallMood();
           // print_r($moods);die;
            //$moods = json_decode($moods, true);
            $moodScore=0;
            $count=0;
            //echo $moods; die;
            foreach ($moods as $mood){
                if (isset ($mood['meta_value'])) $value=$mood['meta_value'];
                $value = json_decode($value, true);
              //  print_r($value);//echo 'values is: '.$value;

                $thisScore = (isset($value['id'])) ?$value['id']: 0 ;

                $moodScore=$moodScore+$thisScore;
                $count++;
//echo 'meta_value is :'.$mood['meta_value'].'<br />';
            }
            $score=round($moodScore/$count,0);
            if($score==0) $score=1;
           echo 'Total Scores: '.$count.' result '. User::$mood_name[$score];

            ?>


<table class="table">
	<thead>
	<tr>
        <th>User</th>
        <th>Active</th>
	<th>Company(Projects)</th>
	<th>Actions</th>
	</tr>
	</thead>
        <tbody>

        <?php foreach($data as $item) {?>
        <tr class="odd"> 
   
        <td>   
        <a href="<?php echo UrlHelper::getPrefixLink('/user/detail?id=')?><?php echo $item['id'];?>">
        <?php echo $item['firstname'].' '.$item['lastname'];?>(id <?php echo $item['id'];?>)
        </a>
        </td>
        
        <td>
            <?php echo $item['email'];?>
        </td> 
 
    
        
        <td>
        <a href="<?php echo UrlHelper::getPrefixLink('/company/view?id=')?><?php echo $item['name']?>">



        </td>  
        
        <td>

         </a>
       
            
            </td>
        </tr>
       <?php }?>
                <tr><td>
          
            </td></tr>
        
   	</tbody>
</table>

<?php




$this->endWidget();
endif;



?>

