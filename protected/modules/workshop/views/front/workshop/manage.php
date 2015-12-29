<?php
/* @var $this ProfileRelatedController */
$this->menu=array(
	//array('label'=>'List Workshop','url'=>array('index')),
	array('label'=>'Create Workshop','url'=>array('create')),
	array('label'=>'Manage Category','url'=>array('/workshop/workshopCat/admin')),
	array('label'=>'Manage Facilitator','url'=>array('/workshop/workshopFacilitator/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('workshop-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

//$catListData=CHtml::listData(WorkshopCat::getAllCategories(), 'workshop_cat_id', 'workshop_cat_name');

$this->pageTitle='My Workshops';
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-wrench',);
?>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('workshop.views.common.workshop._search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<br/>
<br/>

<div id="alert-div"></div>

<?php $this->renderPartial('gridviews/_manage',array('model'=>$model));?>
