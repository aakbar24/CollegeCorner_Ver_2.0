<?php
/**@var Slide $model */
$this->breadcrumbs = array(
    'Slides' => array('index'),
    Formatter::formatOrdinal($model->position + 1),
);

$this->menu = array(
    array('label' => 'List Slides', 'url' => array('index')),
    array('label' => 'Create Slide', 'url' => array('create')),
    array('label' => 'Update Slide', 'url' => array('update', 'id' => $model->slide_id)),
    array('label' => 'Delete Slide', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->slide_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Slides', 'url' => array('admin')),
);
?>

<h1><?php echo Formatter::formatOrdinal($model->position + 1) . " Slide"; ?></h1>

<div class="row-fluid" id="area_slide">
    <?php  $this->widget('bootstrap.widgets.TbCarousel', array(
        'items' => array(
            array('image' => Slide::generateImagePath($model->slide_image, $model->getPrimaryKey()), 'label' => $model->label, 'caption' => $model->caption),),
        'htmlOptions' => array('id' => 'viewSlider'),
        'options' => array('interval'=>false)
    )); ?>
</div>




