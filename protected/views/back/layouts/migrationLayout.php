<?php
/* @var $this Controller */
/* @var Yii::app()->user WebUser */

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/back-migration.css');

$this->beginContent('//layouts/column2'); 

?>   

<?php echo $content ?>


<?php  $this->endContent();  ?>


