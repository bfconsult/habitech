<?php

$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>

<?php

    echo '<h2>'.$configs->parent_system->name.'</h2>';




$data = $configs;
//echo '<pre>';
//print_r($data);

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

                'url' => UrlHelper::getPrefixLink('/config/create'),
            ),

        )
    ));
    if (!empty($data)) {

    ?>
    <table class="table">

        <tbody>


                <tr class="odd">
                    <td>
                        <?php echo
                        $data->name; ?>
                    </td>
                    <td>
                        <?php echo $data->creator->firstname; ?> : <?php echo $data->create_date; ?>
                    </td>


                </tr>

                <tr class="odd">
                  <td>
                        - <?php echo $data->description; ?>
                    </td>


                </tr>



        </tbody>
    </table>

    <?php }
$this->endWidget();



?>