<?php

/* @var $this DefaultController */
?>

<?php

$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $forumGridData,
    'template' => "{items}",
    'columns' => $gridColumns,
    'type' => 'bordered',
    'rowCssClass' => array('forum_gridview'),
    'htmlOptions' => array('class' => 'forumGrid')
));
?>


