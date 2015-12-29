<?php
/**@var Slide $model */
$this->breadcrumbs = array(
    'Migrations'
);

$this->menu = array(
    array('label' => 'Manage Migrations', 'url' => array('manage'))
);
?>

<h1>Database Migration Management</h1>

<br/>

<div class="row-fluid" id="area_migration_manage">

    <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'buttons'=>array(
            array('label' => '<i class="icon-minus"></i> &nbsp; Migrate Down',
                'url' => array('migrate', 'type' => 'down'),
                'type' => 'danger',),
            array('label' => 'Migrate',
                'url' => array('migrate'),
                'type' => 'primary',),
            array('label' => 'Migrate Up &nbsp;  <i class="icon-plus"></i>',
                'url' => array('migrate', 'type' => 'up'),
                'type' => 'success',)
        ),
        'encodeLabel' => false,
        'size' => 'large',
    )); ?>

       <!-- --><?php /*$this->widget('bootstrap.widgets.TbButton',array(
            'label' => 'Migrate',
            'type' => 'primary',
            'size' => 'large',
            'url' => array('migrate')
        )); */?>

    <?php if (Yii::app()->user->hasFlash('results')): ?>

        <div id="results_area" class="well">
            <legend>Results</legend>

            <?php
            echo Yii::app()->user->getFlash('results');
            ?>
        </div>

    <?php endif; ?>


</div>




