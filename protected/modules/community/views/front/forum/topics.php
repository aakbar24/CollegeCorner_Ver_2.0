<?php
/* @var $this DefaultController */

?>

<?php 

    if (!isset($filtersForm))
    {
        $filtersForm = NULL;
        Yii::log("No Search Filter configured. Searching disabled for this page");
    }
    else
        Yii::log("Filter Found");

    $this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$forumGridData,
    'template'=>"{items}{pager}",
    'columns'=>$gridColumns,
    'filter'=>$filtersForm,
    'emptyText'=>$this->emptyText,  
    'type'=>'bordered',
    'enableSorting' => true,
    'rowCssClass' => array('forum_gridview'),
     'htmlOptions'=>array('class'=>'forumGrid')
    ));

?>


