<?php
/* @var $this ComplaintController */
/* @var $model Complaint */
/* @var $form CActiveForm */
?>
<div class="relational">
<?php

echo CHtml::tag('h3',array(),'Reported Messages for Thread '.$id.'');
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
'type' => 'condensed',
'dataProvider' => $gridDataProvider,
'template' => "{items}",
'columns' => $gridColumns
));

?>

</div>
