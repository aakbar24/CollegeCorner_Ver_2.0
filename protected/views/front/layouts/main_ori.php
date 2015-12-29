<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1">
	<meta name="keywords" content="collegecornerstone, college cornerstone, college, employer, internship, volunteer, placement, centennial, seneca, humber, resume, connection, Mohamed Khan, Wenbin Cai, Matthew Trentadue">
	<meta name="description" content="At College Cornerstone, we want to help bridge the gap between students and employers. Everyone wants success. The College Cornerstone service can offer success in many different ways. Student Academic Success: College Cornerstone will provide connections and techniques by creating academic communities for a student's institution. Student Career Success: Gain the competitive edge required to secure a job! Employers Success: Modern day employers seek to add potential to their workforce in order to help their businesses grow and prosper. College Cornerstone can instantly get your resume in the hands of thousands of local employers! College Cornerstone is made up of a small team of dedicated students with a love for academic excellence. This talented team is headed by Mohamed Khan, an ICT professor and industry liaison. He has provided job opportunities to countless students.">
    <?php if (BETA): ?>
        <meta name="robots" content="noindex, nofollow"/>
    <?php endif; ?>
    <META NAME="copyright" CONTENT="&copy; 2013 by College CornerStone. All Rights Reserved.">
    <META NAME="author" CONTENT="College CornerStone">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <title><?php echo CHtml::encode($this->pageTitle); ?></title>

    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->baseUrl; ?>/css/sunny_style.css?v=1.1"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->baseUrl; ?>/css/front-view.css?v=1.1"/>
		  
		 <!--added by Akbar --> 
		  <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->baseUrl; ?>/css/engine1/style.css?v=1.1"/>
		  

          <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->baseUrl; ?>/css/utility.css?v=1.1"/>
    <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/holder.js'); ?>
    <link rel="icon" type="image/x-icon" href="<?php echo Yii::app()->baseUrl; ?>/files/icon/favicon.png">
</head>

<body>

<?php
$userNavItems = Yii::app()->user->getState('mainNavItems', array());
array_push($userNavItems, array('label' => Yii::t('view', 'menu.logout_lb'), 'url' => array('/account/auth/logout')));
$this->widget('bootstrap.widgets.TbNavbar', array(
    'collapse' => true,
    'brand' => CHtml::image(Yii::app()->getBaseUrl().'/files/images/logo.png'),
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            //'activateParents'=>true,
            'items' => array(
                array('label' => Yii::t('view', 'menu.home_lb'), 'url' => array('/site/index')),
                array('label' => 'Learn1', 'items' => array(
                    array('label' => Yii::t('view', 'articles.articles'), 'url' => array('/site/articles')),
                    array('label' => Yii::t('view', 'news.news'), 'url' => array('/site/news')),
                    array('label' => Yii::t('view', 'events.events'), 'url' => array('/event/event/index')),
                    array('label' => Yii::t('view', 'workshop.workshop'), 'url' => array('//site/workshops')),
                    array('label' => Yii::t('view', 'certifications_lb'), 'url' => array('//certificate/certification/index')),
                )),
                array(
                    'label' => Yii::app()->user->getState('user_group_name', ''), 'visible' => !Yii::app()->user->isGuest,
                    'items' => Yii::app()->user->getState('mainNavItems', array()),
                ),
                array('label' => Yii::t('view', 'menu.about_lb'), 'url' => array('/site/page', 'view' => 'about')),
                array('label' => Yii::t('view', 'menu.testimonials_lb'), 'url' => array('/site/page', 'view' => 'testimonials')),
                array('label' => Yii::t('view', 'menu.contact_lb'), 'url' => array('/site/contact')),
            ),
        ),
        array(
            'htmlOptions' => array('class' => 'pull-right'),
            'class' => 'bootstrap.widgets.TbMenu',
            //'activateItems'=>false,
            'items' => array(
                array('icon' => 'user', 'label' => Yii::t('view', 'menu.login_lb'), 'url' => array('/account/auth/login'), 'visible' => Yii::app()->user->isGuest),
                array('icon' => 'user', 'label' => Yii::app()->user->getState('username', ''), 'visible' => !Yii::app()->user->isGuest,
                    'items' => $userNavItems,
                )
            ),
        ),
    ),
));
?>
<!--NEW-->
	<div class='csslider1 autoplay '>
		<input name="cs_anchor1" id='cs_slide1_0' type="radio" class='cs_anchor slide'  autocomplete="off">
		<input name="cs_anchor1" id='cs_slide1_1' type="radio" class='cs_anchor slide'  autocomplete="off">
		<input name="cs_anchor1" id='cs_slide1_2' type="radio" class='cs_anchor slide'  autocomplete="off">
		<input name="cs_anchor1" id='cs_play1' type="radio" class='cs_anchor' checked autocomplete="off">
		<input name="cs_anchor1" id='cs_pause1_0' type="radio" class='cs_anchor pause' autocomplete="off">
		<input name="cs_anchor1" id='cs_pause1_1' type="radio" class='cs_anchor pause' autocomplete="off">
		<input name="cs_anchor1" id='cs_pause1_2' type="radio" class='cs_anchor pause' autocomplete="off">
		<ul>
			<div>
				<img src="/files/images/data1/images/equality_and_diversity.jpg" style="width: 100%; height:500px;">
				
			</div>
			<li class='num0 img'>
				
				<?php
				$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/data1/images/equality_and_diversity.jpg ';
				$WIDHEI_STR=" width=100% height=500px ";
				
				?>
				<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
			</li>
			<li class='num1 img'>
				<!--<img src='dsc03006.jpg' alt='DSC03006' title='DSC03006' /> -->
				<?php
				$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/data1/images/soft_skills_edit.jpg'; 
				$WIDHEI_STR=" width=100% height=500px";
				
				?>
				<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
			</li>
			
			<li class='num2 img'>
				<!--<img src='dsc03006.jpg' alt='DSC03006' title='DSC03006' /> -->
				<?php
				$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/data1/images/homepageheader.jpg'; 
				$WIDHEI_STR=" width=100% height=500px";
				
				?>
				<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
			</li>
		
		</ul>
		<a class="cs_lnk" href="http://cssslider.com">image slider</a>
		<div class='cs_description'>
			<label class='num0'>
				<span class="cs_title"><span class="cs_wrapper">DSC03005</span></span>
				
			</label>
			<label class='num1'>
				<span class="cs_title"><span class="cs_wrapper">DSC03006</span></span>
				
			</label>
		</div>
		<div class='cs_play_pause'>
			<label class='cs_play' for='cs_play1'><span><i></i></span></label>
			<label class='cs_pause num0' for='cs_pause1_0'><span><i></i></span></label>
			<label class='cs_pause num1' for='cs_pause1_1'><span><i></i></span></label>
			
		</div>
		<div class='cs_arrowprev'>
			<label class='num0' for='cs_slide1_0'><span><i></i></span></label>
			<label class='num1' for='cs_slide1_1'><span><i></i></span></label>
		</div>
		<div class='cs_arrownext'>
			<label class='num0' for='cs_slide1_0'><span><i></i></span></label>
			<label class='num1' for='cs_slide1_1'><span><i></i></span></label>
		</div>
		
		<div class='cs_bullets'>
			<label class='num0' for='cs_slide1_0'>
				<span class='cs_point'></span>
				<span class='cs_thumb'><img src='data1/tooltips/dsc03005.jpg' alt='DSC03005' title='DSC03005' /></span>
			</label>
			<label class='num1' for='cs_slide1_1'>
				<span class='cs_point'></span>
				<span class='cs_thumb'><img src='data1/tooltips/dsc03006.jpg' alt='DSC03006' title='DSC03006' /></span>
			</label>
		</div>
		
		</div>
		<!-- End cssSlider.com -->
<div class="container shadow-wrap">
    <div id="main-content"
         class="<?php echo $this->mainContainer ? 'container ' : '' ?> <?php echo $this->pageNoPadding ? 'pageNoPadding' : 'pageFullPadding' ?>">
        <?php if (isset($this->breadcrumbs)): ?>
            <?php
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                'links' => $this->breadcrumbs,
            ));
            ?>
            <!-- breadcrumbs -->
        <?php endif ?>

        <?php echo $content; ?>
        <div class="clearfix"></div>


    </div>
    <!-- page -->
    <div id="push"></div>

    <footer id="cc_footer">

        <div class="row-fluid">
            
            <div class="span12">
            <div class="span7">
						<div class="span5">
							<div id="footer-sitemap">
								<div class="footer-nav-title">Sitemap</div>
								<br />
								<ul class="unstyled">
									<li><?php echo CHtml::link(Yii::t('view', 'articles.articles'), array('/site/articles'))?>
									</li>
									<li><?php echo CHtml::link(Yii::t('view', 'news.news'), array('/site/news'))?>
									</li>
									<li><?php echo CHtml::link(Yii::t('view', 'events.events'), array('/event/event/index'))?></li>
									<li><?php echo CHtml::link(Yii::t('view', 'workshop.workshop'), array('//site/workshops'))?></li>
									<li><?php echo CHtml::link(Yii::t('view', 'certifications_lb'), array('//certificate/certification/index'))?></li>
									
								</ul>
							</div>
						</div>
						<div class="span5 offset1">
							<div id="footer-about">
								<div class="footer-nav-title">About</div>
								<br />
								<ul class="unstyled">
									<li><?php echo CHtml::link(Yii::t('view', 'menu.about_lb'), array('/site/page', 'view' => 'about'))?>
									</li>
									<li><?php echo CHtml::link(Yii::t('view', 'menu.testimonials_lb'), array('/site/page', 'view' => 'testimonials'))?>
									</li>
									<li><?php echo CHtml::link(Yii::t('view', 'menu.contact_lb'), array('/site/contact'))?>
									</li>
									<li><?php echo CHtml::link('Terms of Service', array('/site/page', 'view' => 'policy'))?>
								</ul>
							</div>
						</div>
					</div>
            <div class="span5">
            	<div id="footer-company" >
	            	<div class="span12">
	            		<div id="footer-logo"  style="max-width:300px"><?php echo CHtml::image(Yii::app()->getBaseUrl().'/files/images/logo.png');?></div>
	            		<div id="footer-contact" ><ul class="unstyled"><li><span><i class="icon-phone"></i> Tel:</span>+1 (416) 750-1652</li><li><span><i class="icon-envelope-alt"></i> Email:</span> <a href="mailto:success@collegecornerstone.com">success@collegecornerstone.com</a></li></ul></div>
	            	</div>
            	</div>
            </div>
        	
        </div>
        </div>
        <br class="clearfix"/>
        <div class="row-fluid bottom_nav_bar">
            <div class="span12">
              <span class="pull-left"><?php echo CHtml::link('<i class="icon-arrow-up"></i> Back to Top', "#"); ?></span>
              <span class="pull-right"><?php //echo CHtml::link("Terms of Service", array('/site/page', 'view' => 'policy')); ?>
                    <small>&copy; <?php echo date('Y');?> by College CornerStone. All
                        Rights Reserved. Powered by Yii Framework.
                    </small>
              </span>
            </div>
        </div>
    </footer>

</div>

</body>
</html>
