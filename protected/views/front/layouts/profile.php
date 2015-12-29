<?php 

/* @var $this Controller */

/* @var Yii::app()->user WebUser */

$cs = Yii::app()->getClientScript();



$cs->registerCssFile(Yii::app()->baseUrl . '/css/profile.css');

?>

<?php $this->beginContent('//layouts/column1'); ?>



<?php if(!Yii::app()->user->isGuest):?>

	<div class="span3 profile-menu">

			<?php $this->widget('bootstrap.widgets.TbMenu', array(

				'type'=>'list',

				'htmlOptions'=>array('class'=>'profile-menu-bar'),

				'items'=>Yii::app()->user->getUserProfileMenu($this),

			)); ?>



</div>



<div id="profile-body" class=" span9 profile-content">

<div>



<!-- Profile page header START-->

			<?php if(isset($this->sectionTitle) && !empty($this->sectionTitle)): $sectionTitle=$this->sectionTitle;?>

	<div class="page-header">

	<h1>

				<?php echo (isset($sectionTitle['backLink'])?$sectionTitle['backLink']:'');?>

				<?php if(isset($sectionTitle['icon'])):?>

					<i class="<?php echo $sectionTitle['icon']?>"></i> 

					<?php endif;?>

				<?php echo (isset($sectionTitle['title'])?$sectionTitle['title']:'');?>

</h1></div>

			<?php endif;?>

<!-- Profile page header END-->



			<?php echo $content; ?>

</div>

</div>

<div class="clearfix"></div>

<?php else:?>

			<?php echo $content; ?>

<?php endif;?>

<?php $this->endContent(); ?>