
<tr>
<td><?php echo CHtml::encode($data->id); ?></td>
<td><?php echo CHtml::encode($data->name); ?></td>
<td><?php echo CHtml::encode($data->number); ?></td>
<td>
    <?php echo CHtml::link('<i class="icon-folder-open" rel="tooltip" title="" data-original-title="view batch files"></i>', array('/iface/index', 'id'=>$data->id)); ?>
    <?php
    if (Batch::model()->hasUnprocessed($data->id)){
        echo CHtml::link('<i class="icon-cogs" rel="tooltip" title="" data-original-title="OCR the Batch"></i>', array('/batch/ocr', 'id'=>$data->id));
    } ELSE {

        echo CHtml::link('<i class="icon-download" rel="tooltip" title="" data-original-title="download batch"></i>', array('download', 'id' => $data->id));
    }
    ?>
    <?php echo CHtml::link('<i class="icon-remove-sign" rel="tooltip" title="" data-original-title="delete batch and files"></i>', array('delete', 'id'=>$data->id)); ?>
</td>
</tr>
