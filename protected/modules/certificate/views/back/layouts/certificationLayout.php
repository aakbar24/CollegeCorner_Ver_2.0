<?php
/* @var $this Controller */
/* @var Yii::app()->user WebUser */

Yii::app()->clientScript->registerCssFile($this->module->getAssetsUrl().'/certification.css');

$this->beginContent('//layouts/column2'); 

Yii::log("test");

?>   

<?php echo $content ?>


<?php  $this->endContent();  ?>


