<?php
/* @var $this Controller */
/* @var Yii::app()->user WebUser */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/back-slides.css');

$this->beginContent('//layouts/column2'); 

Yii::log("test");

?>   

<?php echo $content ?>


<?php  $this->endContent();  ?>


