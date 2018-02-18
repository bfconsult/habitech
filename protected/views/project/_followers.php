




	<script
		src="https://code.jquery.com/jquery-3.2.1.min.js"
		integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
		crossorigin="anonymous"></script>

	<div id="employee-grid">

		<?php echo Follower::model()->projectFollowsGrid(); ?>


	</div>

	<form id="add-component-form" />
	<table>
		<tr>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Email</th>

	</tr>
	<tr>
		<td >
			<input type="text" name="firstname" style="width:80px;"/>
		</td>
		<td>    <input type="text" name="lastname" style="width:80px;"/></td>
		<td >  <input type="text" name="email"/></td>
		<td >

			<input type="submit" value="Add"/>
		</td>


	</tr>

	</table>

	</form>



	<script type="text/javascript">

		$('#add-component-form').submit(function(e) {
			e.preventDefault();

			const firstname = e.target.firstname.value;
			const lastname = e.target.lastname.value;
			const email = e.target.email.value;


			$.ajax('/follower/followeraction',{
					type: "POST",
					data: "employee[firstname]=" + firstname
					+ "&employee[lastname]=" + lastname
					+ "&employee[email]=" + email,
					// contentType: "application/json; charset=utf-8",
					dataType: "html",
					success: (data) => {
					console.log('update', data)
			$('#employee-grid').html(data);

		},
			error: (error) => {
				console.log(error)
				$('#add-component-content').html(error.responseText);
			},
		})
		});

	</script>








<?php
	/*
	?>






	<table class="table tooltipster" >
	<thead >
	<tr>

		<th>Name</th>
		<th>Email</th>
		<th>Actions</th>

	</tr>
	</thead>

	<tbody>


	<?php foreach($followers as $item) {?>
		<tr class="odd">
			<td>
				<?php if($item['admin']==1) { ?>
					<i class="icon-user" rel="tooltip" title="Administrator"></i>

				<?php } ?>
			</td>
			<td>
				<?php echo $item['firstname']." ".$item['lastname'];?>
			</td>
			<td>
				<?php echo $item['email'];?>
			</td>
			<td>

				<?php    if($user->id==$item['id'] && $user->admin!=1) {?>
					<a href="<?php echo UrlHelper::getPrefixLink('/user/view/id/')?><?php echo $item['id'];?>"><i class="icon-eye-open" rel="tooltip" title="View"></i></a>

				<?php }?>
				<?php    if($user->admin==1) {?>
					<?php    if($item['link']!=0) {?>
						<a href="<?php echo UrlHelper::getPrefixLink('/user/reinvite/id/')?><?php echo $item['id'];?>"><i class="icon-envelope" rel="tooltip" title="Resend Invitation Email"></i></a>
					<?php }?>
					<a href="<?php echo UrlHelper::getPrefixLink('/user/view/id/')?><?php echo $item['id'];?>"><i class="icon-eye-open" rel="tooltip" title="View"></i></a>

					<?php if($item['admin']==1 && count($admin)>1) {?>
						<a href="<?php echo UrlHelper::getPrefixLink('/user/demote/id/')?><?php echo $item['id'];?>"><i class="icon-circle-arrow-down" rel="tooltip" title="Remove Administrator Rights"></i> </a>
					<?php }?>
					<?php if($item['admin']!=1) {?>
						<a href="<?php echo UrlHelper::getPrefixLink('/user/promote/id/')?><?php echo $item['id'];?>"><i class="icon-circle-arrow-up" rel="tooltip" title="Promote to Administrator"></i> </a>

						<a href="<?php echo UrlHelper::getPrefixLink('/user/sack/id/')?><?php echo $item['id'];?>"><i class="icon-remove-sign" rel="tooltip" title="Remove user from company"></i></a>
					<?php }?>
				<?php }?>

			</td>
		</tr>
	<?php } ?>
	</tbody>
</table>

<?php
endif;
$this->endWidget();

	*/

	?>




