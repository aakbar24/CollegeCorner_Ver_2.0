<?php /* @var $this Controller */
use yii2Config\bootstrap\Modal;
include_once('/../../modules/account/models/forms/LoginForm.php');

// for student register
include_once('/../../modules/account/models/forms/RegisterForm.php');
include_once('/../../modules/account/models/forms/StudentRegisterForm.php');
//test 222llll
?>
<!DOCTYPE html>
<html>
<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta name="description" content="Jobseek - Job Board Responsive HTML Template">
		<meta name="author" content="Coffeecream Themes, info@coffeecream.eu">
		<title>College Corner Stone</title>
		<link rel="shortcut icon" href="images/favicon.png">

		<!-- Main Stylesheet -->
<!--		<link href="css/style.css" rel="stylesheet">-->
<link rel="stylesheet" type="text/css" 
	href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

		<!-- HTML5 shiv and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<script src="js/respond.min.js"></script>
		<![endif]-->

	</head>

<body id="home">
    <!-- ============ PAGE LOADER START ============ -->

<!--		<div id="loader">
			<i class="fa fa-cog fa-4x fa-spin"></i>
		</div>-->

		<!-- ============ PAGE LOADER END ============ -->
    	<!-- ============ NAVBAR START ============ -->

		<div class="fm-container">
			<!-- Menu -->
			<div class="menu">
				<div class="button-close text-right">
					<a class="fm-button"><i class="fa fa-close fa-2x"></i></a>
				</div>
                                                <div id="mainmenu">
	<?php $this->widget('ext.AjaxMenu',array(
  'items'=>array(
      array('label'=>'Home', 'url'=>array('/site'), 'linkOptions' => array('id' => 'idname'), 'ajax' => false),
      array('label'=>'About', 'url'=>array('/site/page', 'view'=>'about')),//, 'ajax' => array('update' => '#content')),
      array('label'=>'Jobs', 'url'=>array('/site/page', 'view'=>'Jobs')),
      array('label'=>'Post a job', 'url'=>array('/site/page', 'view'=>'Post a job')),
      array('label'=>'post-a-resume', 'url'=>array('/site/page', 'view'=>'post-a-resume')),
      array('label'=>'Pages', 'url'=>array('/site/page', 'view'=>'Pages')),
      
      array('label'=>'Contact', 'url'=>array('/site/contact')),
    // array('label'=>'Register', 'url'=>array(''),'linkOptions'=>array('class' => 'link-register','id'=>'register')),
     // array('label'=>'Login', 'url'=>array('#'),'itemOptions'=>array('class' => 'login'),  'visible'=>Yii::app()->user->isGuest),
     // array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
  ),
  'optionalIndex'=>true,
  'ajax'=>array(
      'update' => '#main-content',
  ),
  'randomID'=>true,
)); ?>
                                                    
                                                    

		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				array('label'=>'Register','url'=>array("#"),'items'=>array(
                                 array('label'=>'Student Register', 'url'=>array('#'),'linkOptions'=>array('class' => 'link-register')),
                                  array('label'=>'Employer Register', 'url'=>array('#'),'linkOptions'=>array('class' => 'link-register'))  
                                    )),
				array('label'=>'Login', 'url'=>array('#'), 'linkOptions'=>array('class' => 'link-login'),'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/auth/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	
	</div><!-- mainmenu -->
				
				
	
			</div>
				
			</div>
        
        <!-- ============ NAVBAR END ============ -->

<div  id="main-content">

<!--	<div id="header">
		<div id="logo"><?php //echo CHtml::encode(Yii::app()->name); ?></div>
	</div> header -->

	
	<?php //if(isset($this->breadcrumbs)):?>
		<?php //$this->widget('zii.widgets.CBreadcrumbs', array(
			//'links'=>$this->breadcrumbs,
		//)); ?><!-- breadcrumbs -->
	<?php //endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

<!--	<div id="footer">
		Copyright &copy; <?php //echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php //echo Yii::powered(); ?>
	</div> footer -->

</div><!-- page -->




<!-- ============ FOOTER START ============ -->

		<footer>
			<div id="prefooter">
				<div class="container">
					<div class="row">
						<div class="col-sm-6" id="newsletter">
							<h2>Newsletter</h2>
							<form class="form-inline">
								<div class="form-group">
									<label class="sr-only" for="newsletter-email">Email address</label>
									<input type="email" class="form-control" id="newsletter-email" placeholder="Email address">
								</div>
								<button type="submit" class="btn btn-primary">Sign up</button>
							</form>
						</div>
						<div class="col-sm-6" id="social-networks">
							<h2>Get in touch</h2>
							<a href="#"><i class="fa fa-2x fa-facebook-square"></i></a>
							<a href="#"><i class="fa fa-2x fa-twitter-square"></i></a>
							<a href="#"><i class="fa fa-2x fa-google-plus-square"></i></a>
							<a href="#"><i class="fa fa-2x fa-youtube-square"></i></a>
							<a href="#"><i class="fa fa-2x fa-vimeo-square"></i></a>
							<a href="#"><i class="fa fa-2x fa-pinterest-square"></i></a>
							<a href="#"><i class="fa fa-2x fa-linkedin-square"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div id="credits">
				<div class="container text-center">
					<div class="row">
						<div class="col-sm-12">
							&copy; 2015 CollegeCornerStone - Helping hand to job seekers<br>
							Designed &amp; Developed by <a href="http://collegecornerstone.com" target="_blank">College Corner Stone</a>
						</div>
					</div>
				</div>
			</div>
		</footer>

		<!-- ============ FOOTER END ============ -->
                <!-- ============ LOGIN START ============ -->

		<div class="popup" id="login">
			<div class="popup-form">

					 <?php $model=new LoginForm;?>
                <?php echo $this->renderPartial('application.modules.account.views.common.login',array('model'=>$model));  // I need $productId to by dynamic related to link 
                ?>
					
			</div>
		</div>

		<!-- ============ LOGIN END ============ -->
                
                <!-- ============ REGISTER START ============ -->

		<div class="popup" id="register">
                    
			<div class="popup-registerForm">
                          
                <?php echo $this->renderPartial('application.modules.account.views.front.register.student')//,array('model'=>$model));?>
			</div>
		</div>

		<!-- ============ REGISTER END ============ -->

<!-- Modernizr Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/modernizr.custom.79639.js"></script>

		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-1.11.2.min.js"></script>-->

		<!-- Bootstrap Plugins -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.min.js"></script>

		<!-- Retina Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/retina.min.js"></script>

		<!-- ScrollReveal Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/scrollReveal.min.js"></script>

		<!-- Flex Menu Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.flexmenu.js"></script>

		<!-- Slider Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-cond.min.js"></script>
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.slitslider.js"></script>

		<!-- Carousel Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/owl.carousel.min.js"></script>

		<!-- Parallax Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/parallax.js"></script>

		<!-- Counterup Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.counterup.min.js"></script>
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/waypoints.min.js"></script>

		<!-- No UI Slider Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.nouislider.all.min.js"></script>

		<!-- Bootstrap Wysiwyg Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap3-wysihtml5.all.min.js"></script>

		<!-- Flickr Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/jflickrfeed.min.js"></script>

		<!-- Fancybox Plugin -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/fancybox.pack.js"></script>

		<!-- Magic Form Processing -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/magic.js"></script>

		<!-- jQuery Settings -->
		<script src="<?php echo Yii::app()->baseUrl; ?>/js/settings.js"></script>
</body>
</html>
