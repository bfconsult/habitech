<div class="row">
    <div class="span1"><h2><i class="icon-ok-circle"></i></h2></div>
        <div class="span5">
<h3>Verify your account</h3>
</div></div>

  <?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'=>'warning',
    'label'=>'Re-send the Verification email',
   // 'block'=>true,
      'url'=>'/req/user/reverify'
)); 
  
  $user=User::model()->findbyPK(Yii::App()->user->id);
   
  ?>  

<br><br>
Your email is set as <strong><?php echo $user->username; ?></strong>. If this is incorrect, you will need to re-create your account.

<?php 
Yii::app()->user->setFlash('error', ''
        . '<h4>Thanks for joining ReqFire!</h4>
            You have not yet verified your account.
            
            <br />
            Click the link below to re-send the verification email.
            If you are having trouble recieving it, please contact us.'
        . '');
$this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true, // display a larger alert block?
        'fade'=>true, // use transitions?
        'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
        'alerts'=>array( // configurations per alert type
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        ),
    )); 
?>


<br />