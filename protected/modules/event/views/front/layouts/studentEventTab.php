<?php 
/* @var $this Controller */
/* @var Yii::app()->user WebUser */
Yii::app()->clientScript->registerCssFile($this->module->getAssetsUrl().'/workshop.css');
$this->sectionTitle=array('title'=>$this->pageTitle,'icon'=>'icon-flag');
?>
<?php $this->beginContent('//layouts/profile'); ?>

<?php if(isset($this->tabMenus) && $this->tabMenus!=null):?>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>$this->tabMenus,
));?>
<?php endif;?>
			<?php echo $content; ?>

<?php $this->endContent(); ?>