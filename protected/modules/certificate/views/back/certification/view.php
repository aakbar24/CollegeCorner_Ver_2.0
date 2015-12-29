<?php
/* @var $model Certification */
$this->breadcrumbs=array(
	'Certifications'=>array('index'),
	$model->post_item_id,
);

$this->menu=array(
	array('label'=>'List Certification','url'=>array('index')),
	array('label'=>'Create Certification','url'=>array('create')),
	array('label'=>'Update Certification','url'=>array('update','id'=>$model->post_item_id)),
	array('label'=>'Delete Certification','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->post_item_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Certification','url'=>array('admin')),
);
?>

<div>
    <div class="page-header clearfix">
        <div class="span8"><h1><?php echo $model->postItem->title; ?></h1></div>
        <div class="span4"><h5 class="pull-right">
            Provider: <?php echo CHtml::tag('span', array('class' => 'view_provider_text'), $model->provider); ?><br/>
            Category: <?php echo CHtml::tag('span', array('class' => 'view_category_text'), $model->certification_cat_name); ?>
        </h5></div>
        <br class="clearfix"/>
    </div>

    <?php if (!empty($model->cert_image)): ?>

        <div class="thumbnail cert-image-full-size" title="<?php echo $model->title;?> - Image" >
            <?php echo CHtml::image($model->getCertImageUrl()) ?>
        </div>
        <br/>
    <?php endif; ?>
	
    <?php
    $this->widget('bootstrap.widgets.TbBox', array(
        'title' => "Description",
        'headerIcon' => 'icon-edit-sign',
        'content' => $model->postItem->description
    ));
    ?>

    <div>
    <!-- <div class="page-header">
    	<h4>Provider:</h4>
    </div> -->
    <div>
    <b>Posted On:</b> <?php echo CHtml::tag('span', array('class' => 'view_date_text'), Yii::app()->format->datetime($model->postItem->date_created)); ?><br/>
    <b>Updated:</b> <?php echo CHtml::tag('span', array('class' => 'view_date_text'), $model->postItem->date_updated != '' ? Yii::app()->format->datetime($model->postItem->date_updated) : "N / A"); ?>
    </div>
	</div>
</div>
<br/>