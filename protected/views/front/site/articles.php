<?php
/* @var $this SiteController */
$this->layout = '//layouts/resource';
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('view', 'articles.articles');
$this->pageNoPadding = false;
?>

<?php

//$this->renderPartial("//layouts/_post_items_header", array('type'=>Article::POST_TYPE));

?>

<div class="container">
    <div class="row-fluid">

        <?php
        /** @var $articleData Article */
        $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $articleData,
    'itemView' => '//layouts/_article_listing',
    'emptyText' => "<p>No articles</p>",
    'template' => '{sorter}{items}{pager}',
    'ajaxUpdate' => false,
    'htmlOptions' => array('class' => 'listView_articles'),
));
?>
        
    </div>
</div>

