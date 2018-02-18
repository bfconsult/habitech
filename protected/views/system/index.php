<h1>CPP Batch Processing
<?php echo CHtml::link('<i class="icon-upload" rel="tooltip" title="" data-original-title="upload a new batch"></i>', array('/iface/upload')); ?></h1>
<table>

		<tr>
			<td>Batch Number</td>
			<td>Batch Name</td>
			<td>Number of Reports</td>
	<td>Actions</td>
		</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
</table>
