
<?php $project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;

echo ' <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>';

echo '<h2>'.$system->name;

echo ' <a href = "/system/edit/id/'.$system->id.'"><i class="icon-edit"></i></a>';

echo ' <a href = "/system/remove/id/'.$system->id.'"><i class="icon-remove-sign"></i></a>';

echo ' <a href = "/system/delete/id/'.$system->id.'"><i class="icon-trash"></i></a>';

echo '</h2>';


$data = $system->configs;


$box = $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => 'Recent Projects',
    'headerIcon' => 'icon-briefcase',
    // when displaying a table, if we include bootstra-widget-table class
    // the table will be 0-padding to the box
    'htmlOptions' => array('class' => 'bootstrap-widget-table'),
    'headerButtons' => array(



        array(
            'class' => 'bootstrap.widgets.TbButton',
            'type' => 'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'label' => 'Add Config  +',

            'url' => UrlHelper::getPrefixLink('/config/create/id/'.$system->id),
        ),

    )
));
if (!empty($data)) {

    ?>
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>


        </tr>
        </thead>
        <tbody>
        <?php if (count($data)): ?>


            <?php foreach ($data as $itemIdx => $item): ?>



                <tr class="odd">
                    <td>
                        <a href="/config/view/id/<?php echo $item['id']; ?>"><?php echo $item['name']; ?></a>
                        - <?php echo $item['description']; ?>
                    </td>


                </tr>
            <?php endforeach ?>


        <?php endif; ?>


        </tbody>
    </table>

<?php }
$this->endWidget();




$data = $project->systems;


