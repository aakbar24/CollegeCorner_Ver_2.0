<?php
/* @var $this SiteController */
$this->layout = '//layouts/resource';
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('model', 'news.news');
$this->pageNoPadding = false;
?>

<?php

//$this->renderPartial("//layouts/_post_items_header", array('type'=>Article::POST_TYPE_NEWS));

?>

<div class="container">
    <div class="row-fluid">

        <?php
        /** @var $articleData Article */
        $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $newsData,
    'itemView' => '//layouts/_article_listing',
    'emptyText' => "<p>No articles</p>",
    'template' => '{sorter}{items}{pager}',
    'ajaxUpdate' => false,
    'htmlOptions' => array('class' => 'listView_articles'),
));
?>
        
    </div>
</div>

