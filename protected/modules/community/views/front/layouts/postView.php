<?php
/* @var $this Controller */
/* @var Yii::app()->user WebUser */

$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->baseUrl . '/css/forum.css');
Yii::log(Yii::app()->baseUrl . '/protected/modules/community/assets/forum.css');

$this->beginContent('//layouts/profile'); 

?>

<div class="page-header">
	<h1>
		<?php echo $this->areaLarge;?> <small><?php echo $this->areaSmall ?></small>
	</h1>
</div>

<?php 
if(isset($this->forumBreadcrumb) && !empty($this->forumBreadcrumb))
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->forumBreadcrumb,
        'homeLink'=>false,
    ));
?>
      
<?php echo $content ?>


<?php  $this->endContent();  ?>


