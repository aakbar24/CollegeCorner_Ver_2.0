<?php
$this->breadcrumbs = array(
    'Articles' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Articles', 'url' => array('index')),
    array('label' => 'Create Articles', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('article-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Articles</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button btn')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'article-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'name' => 'title_search',
            'header' => 'Title',
            'value' => '$data->postItem->title'
        ),
        array(
            'name' => 'post_item_id',
            'header' => 'Author',
            'value' => '$data->postItem->user->username'
        ),
        array(
            'name' => 'date_search',
            'header' => 'Post Date',
            'value' => '$data->postItem->date_created'
            ),
        array(
            'name' => 'postItem.date_updated',
            'header' => 'Date Updated',
            'value' => '!empty($data->postItem->date_updated) ? $data->postItem->date_updated : "N / A"'
        ),
        array('name' => 'source', 'type' => 'raw', 'filter' => array('Yes' => 'Yes', 'No' => 'No'), 'type' => 'html', 'value' => '!empty($data->source) ? CHtml::link(CHtml::tag("i", array("class" => "icon-link")), $data->source, array("class" => "source_link" , "target"=>"_blank")) : "N / A"'),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
        ),
    ),
));
?>
