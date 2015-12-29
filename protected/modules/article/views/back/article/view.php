<?php
/* @var $model Article */

$this->breadcrumbs = array(
    'Articles' => array('index'),
    $model->post_item_id,
);

$this->menu = array(
    array('label' => 'List Articles', 'url' => array('index')),
    array('label' => 'Create Article', 'url' => array('create')),
    array('label' => 'Update Article', 'url' => array('update', 'id' => $model->post_item_id)),
    array('label' => 'Delete Article', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->post_item_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Articles', 'url' => array('admin')),
);
?>

<div>
    <div class="page-header clearfix">
        <div class="span8"><h1><?php echo $model->postItem->title; ?></h1></div>
        <div class="span4"><h5 class="pull-right">
            Posted On: <?php echo CHtml::tag('span', array('class' => 'view_date_text'), $model->postItem->date_created); ?><br/>
            Updated: <?php echo CHtml::tag('span', array('class' => 'view_date_text'), $model->postItem->date_updated != '' ? $model->postItem->date_updated : "N / A"); ?>
        </h5></div>
        <br class="clearfix"/>
    </div>

    <?php if (!empty($model->article_image)): ?>

        <a href="#" class="thumbnail" rel="tooltip">
            <?php echo CHtml::image($model->getImageSrc()) ?>
        </a>

    <?php endif; ?>

    <?php
    $this->widget('bootstrap.widgets.TbBox', array(
        'title' => "Content",
        'headerIcon' => 'icon-edit-sign',
        'content' => $model->postItem->description
    ));
    ?>

    <h5>Source: <?php echo CHtml::link($model->getSource(), $model->source) ?></h5>

</div>
