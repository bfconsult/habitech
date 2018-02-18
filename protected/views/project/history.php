<?php

$project = Project::model()->findByPk(Yii::App()->session['project']);
//$data =
$systems= $project->systems;
$systemlist='';
foreach ($systems as $system) {
    $systemlist.=$system->id.',';
}
$systemlist=rtrim($systemlist,',');
$systemlist='('.$systemlist.')';
$deleted = ($del==1)? '(0,1)' :'(0)';
$delFlag = true;
if ($del==1) $delFlag=false;
$data = Config::model()->findAll('system_id in '.$systemlist.' and deleted in '.$deleted);



$project=Project::model()->findbyPK(Yii::App()->session['project']);

echo '<h1>'.$project->name;
?>
    <a href = "/project/view"><i class="icon-arrow-left"></i></a></h1>
<?php
    $box = $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => 'Recent Configuration Changes',
        'headerIcon' => 'icon-briefcase',
        // when displaying a table, if we include bootstra-widget-table class
        // the table will be 0-padding to the box
        'htmlOptions' => array('class' => 'bootstrap-widget-table'),
        'headerButtons' => array(


            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Show deleted',
                'visible' => $delFlag,
                'url' => UrlHelper::getPrefixLink('/project/history/del/1'),
            ),
            array(
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'label' => 'Show current',
                'visible' => !$delFlag,
                'url' => UrlHelper::getPrefixLink('/project/history/del/0'),
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


            <?php foreach ($data as $item): ?>


                <tr class="odd">
                    <td>
                        <a href="/config/view/id/<?php echo $item->id; ?>"><?php echo $item->name; ?></a>
                        - <?php echo $item->description; ?>
                    </td>
                    <td>
                        <?php echo $item->creator->firstname . ' ' . $item->creator->lastname . ' ' . $item->create_date; ?>
                    </td>

                    <td>
                <?php if ($item->deleted == 0){ ?>
                        <a href="/config/delete/id/<?php echo $item->id; ?>"><i class="icon-remove-sign"></i></a>
                <?php } else { ?>

                    <a href="/config/delete/id/<?php echo $item->id; ?>"><i class="icon-refresh"></i></a>
                    <?php } ?>
                    </td>

                </tr>
                <?php

            endforeach;
        endif;

        ?>

        </tbody>
    </table>

    <?php
}

$this->endWidget();

?>