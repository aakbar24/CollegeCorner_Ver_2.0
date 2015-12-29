<?php 
/* @var $this Controller */
/* @var Yii::app()->user WebUser */
$cs = Yii::app()->getClientScript();

//$cs->registerCssFile(Yii::app()->baseUrl . '/css/profile.css');
?>

<?php $this->beginContent('//layouts/column1'); ?>

<?php if(isset($this->tabMenus) && $this->tabMenus!=null):?>
<?php $this->widget('bootstrap.widgets.TbTabs', array(
	'type'=>'tabs', // 'tabs' or 'pills'
	'tabs'=>$this->tabMenus,
));?>
<?php endif;?>
			<?php echo $content; ?>

<?php $this->endContent(); ?>
