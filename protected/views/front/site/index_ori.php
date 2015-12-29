<?php
/* @var $this SiteController */
$this->layout = '//layouts/index';
$this->pageTitle = Yii::app()->name;
$this->pageNoPadding = true;
?>

<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
$MOBILE_PHONE_ACCESS = 'Y';
else $MOBILE_PHONE_ACCESS = 'N';
?>

<div class="slider-sec drop-shadow curved curved-hz-1">

    <div id="carousel" class="container wrap">
        <div class="row-fluid">
		<br>
		<!--
		<table width="70%" align="center">
		<tr>
         <td><font size=4 color=#0088CC><b>ICT Careers</b></font></td>

                                      <td><?php
                   $this->widget('bootstrap.widgets.TbButton', array(
                   	'label' => Yii::t('view', 'Colleges and Universities'),
                   	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                   	'size' => 'null', // null, 'large', 'small' or 'mini'
                   	'url' => array('/auth/login'),
                   	));
                   ?></td>
		<?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</tr><tr><td> </td>"; ?>
                                   <td><?php
                   $this->widget('bootstrap.widgets.TbButton', array(
                   	'label' => Yii::t('view', 'ICTC/IEPs'),
                   	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                   	'size' => 'null', // null, 'large', 'small' or 'mini'
                   	'url' => array('/auth/login'),
                   	));
                   ?>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        </td>
		<?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</tr><tr><td> </td>"; ?>
                                   <td><?php
                   $this->widget('bootstrap.widgets.TbButton', array(
                   	'label' => Yii::t('view', 'Other Institutions'),
                   	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                   	'size' => 'null', // null, 'large', 'small' or 'mini'
                   	'url' => array('/auth/login'),
                   	));
                   ?></td>
		</tr>
                </table> -->	

        <TABLE WIDTH="100%">
        <TR>
		<!--
        <TD width="130px">
       	   <font color=#0088CC>
       	   &nbsp;<br><br>
       	   A <b><u>Free</u></b> Service<br><br>
       	   Easy registration for employers and students/candidates<br><br>

                   <?php 
           $BROWSER_NAME=Yii::app()->browser->getBrowser();
           if ($BROWSER_NAME=="Internet Explorer") {
           	$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/ArrowBulletSmall.png'; 
           	$WIDHEI_STR=" width=10 height=10 ";
           }
           else {
           	$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/ArrowBullet.png'; 
           	$WIDHEI_STR=" width=18 height=18 ";
           }
           ?>

       	   <IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> > Experienced<br>
       	   <IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> > Entry-level<br>
       	   <IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> > Co-op<br>
       	   <IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> > Internship<br><br><br><br>&nbsp;
       	   </font>
        </TD>
-->
        <TD width="1000px">  
          <!-- Start cssSlider.com -->
	
	<!--[if IE]><link rel="stylesheet" href="engine1/ie.css"><![endif]-->
	<!--[if lte IE 9]><script type="text/javascript" src="engine1/ie.js"></script><![endif]-->
	


	</TD>
	<!--
	<TD width="150px"> 
              <font color=#0088CC>
              <b><u>Unique website</u></b> that connects you with Employers.<br><br>
              With No Ads, we unlock the hidden job market.<br><br><br>
              </font>
       </TD>
	   -->
        </TR>
        </TABLE>  
		
		
		
		<!---NEW GUI -->
		<TABLE WIDTH="100%">
        <TR>
		
        <TD width="130px">
		<?php
		$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/Employee.png'; 
		$WIDHEI_STR=" width=100% height=500 ";
		
		?>
		<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
        </TD>

        <TD width="130px">  
           <!-- <div class="span12 offset0"> -->
 
               <?php
               
               $BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/Student.png'; 
               $WIDHEI_STR=" width=100% height=500 ";
               ?>
				<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
           <!-- </div> -->

	</TD>
	
	<TD width="130px"> 
	
	<?php
	$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/News.png'; 
	$WIDHEI_STR=" width=100% height=500 ";
	
	?>
		<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
              
       </TD>
	   
        </TR>
        </TABLE>  
		
				<TABLE WIDTH="100%">
        <TR>
		
        <TD width="260px">
		<?php
		$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/Video.png'; 
		$WIDHEI_STR=" width=100% height=500 ";
		
		?>
		<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
        </TD>

        <TD width="130px">  
           <!-- <div class="span12 offset0"> -->
 
               <?php
               
               $BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/Testimony.png'; 
               $WIDHEI_STR=" width=100% height=500 ";
               ?>
				<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
           <!-- </div> -->

	</TD>
	
	   
        </TR>
        </TABLE>  
		
		
		<TABLE WIDTH="100%">
        <TR>
		
        <TD width="260px">
		<?php
		$BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/Workshop.png'; 
		$WIDHEI_STR=" width=100% height=500 ";
		
		?>
		<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
        </TD>

        <TD width="130px">  
           <!-- <div class="span12 offset0"> -->
 
               <?php
               
               $BULLET_IMAGE_FILE=Yii::app()->getBaseUrl() . '/files/images/certifiction.png'; 
               $WIDHEI_STR=" width=100% height=500 ";
               ?>
				<IMG SRC="<?php echo $BULLET_IMAGE_FILE . '"' . $WIDHEI_STR; ?> >
           <!-- </div> -->

	</TD>
	
	   
        </TR>
        </TABLE>  
		
		<!----END NEW GUI -->

        </div>

    </div>
	
</div>
<!--
<div id="main" class="wrap">

<div class="wedge">
<div class="row-fluid">

    <div class="span6 student bump">
        <div class="well well-large">
            <hgroup class="text-center">
                <?php echo CHtml::image(Yii::app()->getBaseUrl().'/files/images/icon_student.png'); ?>
                <h1>Students/Candidates</h1>
            </hgroup>
            <p><?php echo Yii::t('view', 'index.student.description') ?></p>

            <p>
                <?php echo CHtml::link(Yii::t('view', 'index.learn_more'), array('/site/page', 'view' => 'about', '#' => 'student_success')); ?>
            </p>

            <div class="text-center">
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                	'label' => Yii::t('view', 'index.community_btn'),
                	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                	'size' => 'large', // null, 'large', 'small' or 'mini'
                	'url' => array('/community/forum/index'),
                	));
                ?>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                	'label' => Yii::t('view', 'index.resume_btn'),
                	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                	'size' => 'large', // null, 'large', 'small' or 'mini'
                	'url' => array('/resume/resumePost/post'),
                	));
                ?>
            </div>
        </div>
    </div>
    <div class="span6 employer bump">
        <div class="well well-large">
            <hgroup class="text-center">
                <?php echo CHtml::image(Yii::app()->getBaseUrl().'/files/images/icon_employer.png'); ?>
				<br />
                <h1>Employers</h1>
            </hgroup>
            <p><?php echo Yii::t('view', 'index.employer.description') ?></p>

            <p>
                <?php echo CHtml::link(Yii::t('view', 'index.learn_more'), array('/site/page', 'view' => 'about', '#' => 'employer_success')); ?>
            </p>

            <div class="text-center">

                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                	'label' => Yii::t('view', 'index.request_workshop_btn'),
                	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                	'size' => 'large', // null, 'large', 'small' or 'mini'
                	'url' => array('/workshop/workshop/create'),
                	));
                ?>
                <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                	'label' => Yii::t('view', 'index.fill_position_btn'),
                	'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                	'size' => 'large', // null, 'large', 'small' or 'mini'
                	'url' => array('/resume/employer/index'),
                	));
                ?>
            </div>
        </div>
    </div>


</div>
-->
<!--
<div class="row-fluid"> -->
    <!-- Quote -->
	<!--
    <div class="span12 bump text-center catchy-quote">
        <blockquote class="modify">
            <p><?php echo Yii::t('view','index.attain') ?></p>
        </blockquote>
    </div>
</div>

<div id="resource_area" class="row-fluid">-->

    <!-- Resources, Workshops & Certifications -->
	<!--
    <div class="span4 bump">
        <div class="rect">
            <div class="rect-header text-center">
                <h3><?php echo Yii::t('view', 'events_lb'); ?></h3>
            </div>
            <div class="rect-body">
                <p><?php echo Yii::t('view', 'index.text.events') ?></p>
				<br />
                <em><?php echo Yii::t('view', 'index.text.events.i') ?></em>


                    <?php echo CHtml::link('View Details &raquo;', array('event/event/index')); ?>
            </div>
        </div>
    </div>
    <div class="span4 bump">
        <div class="rect">
            <div class="rect-header text-center">
                <h3><?php echo Yii::t('view', 'workshop_lb'); ?></h3>
            </div>
            <div class="rect-body">
                <p><?php echo Yii::t('view', 'index.text.workshops') ?></p>
				<br />
                <em><?php echo Yii::t('view', 'index.text.workshops.i') ?></em>

                <?php echo CHtml::link('View Details &raquo;', array('site/workshops')); ?>
            </div>
        </div>
    </div>
    <div class="span4 bump">
        <div class="rect">
            <div class="rect-header text-center">
                <h3><?php echo Yii::t('view', 'Certifications / Sponsors');  ?></h3>
            </div>
            <div class="rect-body">
                <p><?php echo Yii::t('view', 'index.text.certifications') ?></p>
				<br />
                <em><?php echo Yii::t('view', 'index.text.certifications.i') ?></em>

                    <?php echo CHtml::link('View Details &raquo;', array('certificate/certification/index')); ?>
            </div>
        </div>
    </div>
</div>

<hr/>


<div class="row-fluid partner"> -->
    <!-- Partners -->
	<!--
    <div class="span12 text-center">
        <h2>Partners</h2>
        <a href="http://www.cips.ca/" class="logo">
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/cips.jpg', "CIPS"); ?>
        </a>
        <a href="http://www.baylaan.com/" class="logo"><?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/baylaan.png', "Baylaan Technologies"); ?></a>
        
        <a href="http://www-03.ibm.com/certify/" class="logo"><?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/ibm.jpg', "IBM"); ?></a>
        <a href="http://www.cga-ontario.org/" class="logo"><?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/CGA.jpg', "Certified General Accounting (CGA)"); ?></a>
        <a href="http://www.microsoft.com/learning/en-us/certification-overview.aspx" class="logo"><?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/Microsoft.jpg', "Microsoft"); ?></a>
        <a href="http://www.oacett.org/page.asp?P_ID=98" class="logo"><?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/Oacett.jpg', "OACETT"); ?></a>
        <a href="http://www.payroll.ca/" class="logo"><?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/partners/Canadian Payroll.png', "Canadian Payroll Association"); ?></a>

	</div>
</div>

</div>

-->
