<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<meta name="robots" content="noindex, nofollow"/>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	
	<link rel="stylesheet" type="text/css"
	href="<?php echo Yii::app()->baseUrl; ?>/css/admin.css" />

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->baseUrl; ?>/css/utility.css" />
	
</head>

<body>

	<?php $this->widget('bootstrap.widgets.TbNavbar',array(
			'type'=>'inverse',
			'collapse'=>true,
			'items'=>array(
					array(
							'class'=>'bootstrap.widgets.TbMenu',
							'items'=>Yii::app()->user->getState('mainNavItems',array()),
					),
					
					array(
							'htmlOptions'=>array('class'=>'pull-right'),
							'class'=>'bootstrap.widgets.TbMenu',
							'activateItems'=>false,
							'items'=>array(
										
									array( 'icon'=>'user white', 'label'=>'Log in',  'url'=>array('/account/auth/index'), 'visible'=>Yii::app()->user->isGuest),
										
									array( 'icon'=>'user white', 'label'=>Yii::app()->user->name,  'visible'=>!Yii::app()->user->isGuest,
												
											'items'=>array(
													array('label'=>Yii::t('view', 'menu.dashboard_lb'),'url'=>array('/account/auth/index'),),
													array('label'=>Yii::t('view', 'auth.edit_account_title_lb'),'url'=>array('/account/user/editAccount'),),
													array('label'=>Yii::t('view', 'menu.logout_lb'),'url'=>array('/account/auth/logout'),),
											),
									)
							),
					),
			),
		)); ?>
	<div id="wrap">
		<div id="main-content"
			class="<?php echo $this->mainContainer?'container ':''?> <?php echo $this->pageNoPadding?'pageNoPadding':'pageFullPadding'?>">
			<?php if(isset($this->breadcrumbs)):?>
			<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
			)); ?>
			<!-- breadcrumbs -->
			<?php endif?>

			<?php echo $content; ?>

			<div class="clear"></div>
		</div>
		<!-- page -->
		<div id="push"></div>
	</div>
	<div class="footer">
		<div class="container">
			Copyright &copy;
			<?php echo date('Y'); ?>
			by College CornerStone.<br /> All Rights Reserved.<br />
			<?php echo Yii::powered(); ?>
		</div>
		<!-- footer -->
	</div>

</body>
</html>
