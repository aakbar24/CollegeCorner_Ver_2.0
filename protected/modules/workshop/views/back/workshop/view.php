<?php
$this->breadcrumbs=array(
	'Workshops'=>array('admin'),
	$model->postItem->title,
);

$isHistory=$model->workshop->isHistory();

$this->menu=array(
	//array('label'=>'List Workshop','url'=>array('index')),
	array('label'=>'Create Workshop','url'=>array('create')),
	array('label'=>'Update Workshop','url'=>array('update','id'=>$model->postItem->post_item_id)),
	array('label'=>'Delete Workshop','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->postItem->post_item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Workshop','url'=>array('admin')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
    array('label'=>'Planned Workshops'),
    array('label'=>'Manage','url'=>array('/workshop/workshopPlanned/admin')),
    array('label'=>'New','url'=>array('/workshop/workshopPlanned/create')),
);

?>

<h1>View Workshop - <?php echo $model->postItem->title; ?> </h1>

<fieldset>
<legend><?php echo Yii::t('view', 'workshop.workshop_info_lb')?></legend>
<?php 
$this->widget('bootstrap.widgets.TbBox', array(
		'title' => $model->postItem->title,
		'headerIcon' => 'icon-flag-checkered',
		'content' => $model->postItem->description
));
?>
</fieldset>

<div class="row-fluid">
<fieldset class="span6">
<legend><?php echo Yii::t('view', 'workshop.location_info_lb')?></legend>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model->workshop,
	'type'=>array('bordered'),
	'attributes'=>array(
		'post_item_id',
        'company',
		'address',
		'city',
		'province',
		'postal_code',
		'countryName',
		'phone',
		'ext'=>array('visible'=>$model->workshop->ext!=''),
	),
)); ?>
</fieldset>

<fieldset class="span6">
<legend><?php echo Yii::t('view', 'workshop.datetime_info_lb')?></legend>
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model->workshop,
	'type'=>array('bordered'),
	'attributes'=>array(
			'start_date:date',
			'end_date:date',
			'start_time:time',
			'end_time:time',
	),
)); ?>

<?php if ($isHistory):?>
<span class="label label-info">This workshop is already past.</span>
<?php endif;?>
</fieldset>
</div>

<div class="row-fluid">
    <fieldset id="facilitator" class="span6">
        <legend><?php echo Yii::t('view', 'workshop.facilitator_info_lb')?></legend>

        <?php if (!empty($model->workshop->workshopFacilitator)): ?>

            <div class="offset1 span10">
                <ul class="thumbnails">
                    <li>
                        <div class="thumbnail">
                            <?php echo CHtml::image($model->workshop->workshopFacilitator->getImageUrl(), "Facilitator - " . $model->workshop->workshopFacilitator->getName()) ?>
                            <h3><?php echo $model->workshop->workshopFacilitator->getName(); ?></h3>

                            <div class="well well-small">
                                <p>
                                    <strong>Biography</strong><br/><?php echo $model->workshop->workshopFacilitator->biography; ?>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        <?php else: ?>

            <div class='alert alert-info empty'><p>Still pending</p></div>

        <?php endif; ?>

    </fieldset>

    <fieldset id="attachment" class="span6">
        <legend><?php echo Yii::t('view', 'workshop.attachment')?></legend>

        <?php if (!empty($model->workshop->workshop_file)): ?>

            <i class='icon-download-alt'></i>
           <?php
            echo CHtml::link($model->workshop->workshop_file, $model->workshop->generateWorkshopFileUrl());
            ?>

        <?php else: ?>

            <div class='alert alert-info empty'><p>No attachments</p></div>

        <?php endif; ?>

    </fieldset>

</div>





