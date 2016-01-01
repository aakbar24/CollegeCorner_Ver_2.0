<?php
/* @var $this SiteController */
$this->layout = '//layouts/main';
$this->pageTitle = Yii::app()->name;
$this->pageNoPadding = true;
?>

<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
     $MOBILE_PHONE_ACCESS = 'Y';
else $MOBILE_PHONE_ACCESS = 'N';
?>
<!-- ============ HEADER START ============ -->

		<header>
			<div id="header-background"></div>
			<div class="container">
				<div class="pull-left">
<!--					<div id="logo"><a href="index.html"><img src="images/logo.png" alt="Jobseek - Job Board Responsive HTML Template" /></a></div>-->
				</div>
				<div id="menu-open" class="pull-right">
					<a class="fm-button"><i class="fa fa-bars fa-lg"></i></a>
				</div>
				<div id="searchbox" class="pull-right">
					<form>
						<div class="form-group">
							<label class="sr-only" for="searchfield">Searchbox</label>
							<input type="text" class="form-control" id="searchfield" placeholder="Type keywords and press enter">
						</div>
					</form>
				</div>
				<div id="search" class="pull-right">
					<a><i class="fa fa-search fa-lg"></i></a>
				</div>
			</div>
		</header>

		<!-- ============ HEADER END ============ -->
<div id="about_top_attract" class="row-fluid">
    <div class="span10 offset1">
        <h1><?php echo Yii::t('about', 'about.title');?></h1>

        <hr/>


        <blockquote class="modify">
            <p>We Inspire, Inform, and Connect ICT students/candidates</p>
        </blockquote>

        <br/>

        <blockquote class="modify">
            <p>We Empower employers with the skills to grow their businesses </p>
        </blockquote>


        <hr/>
    </div>
</div>

<div id="about_content" class="row-fluid">
    <div class="span10 offset1">

        <dl>
            <dt id="heading_goal" class="heading"><?php echo Yii::t('about', 'about.heading.goal');?></dt>
            <dd>At College Cornerstone, we want to help bridge the gap between <strong>students/candidates and employers</strong>.</dd>

            <dd><?php echo Yii::t('about', 'about.success');?></dd>

            <dt><a class="anchor"
                   id="student_success"></a><?php echo Yii::t('about', 'about.heading.academic_success');?></dt>
            <dd>College Cornerstone provides a forum.</dd>
            <dd><ul><strong>
                    <li>Tap into the experiences, knowledge and skills of your fellow colleagues.</li>
                    <li>You are not alone. Meet and chat with student who go to your school.</li>
                    <li>Achieve greater success by helping one another on tests, assignments and projects!</li></strong>
            </ul></dd>


            <dt><?php echo Yii::t('about', 'about.heading.career_success');?></dt>
            <dd>Gain the competitive edge required to secure a job!</dd>
            <dd><ul><strong>
			<li>Post resume for thousands of employers to access.</li>
<li>Select the specific job titles to narrow the search.</li>
<li>Attain workplace experience through volunteering, internships placements and coop.</li>
<li>Learn soft skills and identify and remove barriers to job entry.</li>
<li>Enhance your job prospects by exploring certification that is relevant for your career development.</li>
<li>Get the right job for career development.</li>  </strong>           
</ul></dd>

            <dt><a class="anchor"
                   id="employer_success"></a> <?php echo Yii::t('about', 'about.heading.employer_success');?></dt>
            <dd>Modern day employers seek to add potential to their workforce in order to help their businesses
                grow and prosper.</dd>

            <dd><ul><strong>
                        <li>Download the student/candidate’s resumes by job titles.</li>
                        <li>Easily find the most suitable candidate.</li>
                        <li>Build effective and reciprocal relationship with institutions.</li>
						<li>Learn about the skills development of different institutions and programs.</li>
						<li>Schedule an interview with the student/candidate</li>
					</strong>
                </ul></dd>

            <dt><?php echo Yii::t('about', 'about.heading.workshop_success');?></dt>
            <dd>Enhance the soft-skills of ICT students/candidates <strong>getting a job and keeping it.</strong></dd>
            <dd>Learn key skills such as <strong>cultural awareness / accommodation, effective oral and written communication, team work, leadership and decision making.</strong></dd>
            <dd>Industry Certification for Professional Development
			<br />
			<br />
			<strong>
			Recognized Certifications are often crucial for career growth
Find a certification that can enhance your professional 
outlook.

			</strong>
			</dd>

        </dl>

        <hr/>

        <dl>
            <dt class="heading">Who are we?</dt>
            <dd>College Cornerstone is made up of a small team of dedicated students/candidates with a love for academic excellence.
            </dd>
            <dd> This talented team is headed by <strong>Mohamed Khan,</strong>  an ICT professor and industry liaison. He has provided job opportunities to countless students.
            </dd> 
            <dd>
                <blockquote class="modify">
                    <p>As an ICT professor with over 25+ years, my job satisfaction comes not only from teaching, but playing a significant role in assisting thousands of students/candidates in obtaining internships, placements, coop and career jobs. I provide them with opportunities in an industry that demands work experience. These students/candidates get their feet in the door, and ultimately, into a successful career.
					<br /><br />
My passion to help students is now incorporated into <strong>Collegecornerstone.com</strong>. This site is unique in providing a set of integrated services – designed to assist students/candidates to be more effective in achieving academic success in their studies and career development.
</p>
            <BR> 
            <TABLE width="60%" align="center">
            <TR>
            <TD> 
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_mohamed.jpg');?>
            </TD>
            <?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</TR><TR>"; ?>
            <TD>
            <p><?php echo Yii::t('about', 'about.team.mohamed') ?></p>
            <small><?php echo Yii::t('about', 'about.team.mohamed.title') ?></small>
            <small><?php echo Yii::t('about', 'about.team.mohamed.title2') ?></small>
            </TD>
            </TR>
            </TABLE>
            <!--  <small>Mohamed Khan</small>  --> </blockquote>
            </dd>

        </dl>

        <hr/>

        <dl id="about_not">
            <dt class="heading">College Cornerstone is NOT...</dt>
            <dd>
                <ul>
                    <li><p>Competing with any of the existing services offered by various colleges.</p>
                    <p class="lead">We are unique! We focus on creating more durable and lasting networks between students/candidates and employers.</p>
                    </li>
                    <li><p>Asking for payment.</p>
                        <p class="lead">The service is free to use and enjoy forever!</p>
                    </li>
                    <li><p>Associated with any government body or academic institution</p>
                        <p class="lead">Your information will not be stored and used for surveys and studies. <br/> Only employers will see your "posted" information.</p>
                    </li>
                </ul>
            </dd>

        </dl>


        <hr/>

    </div>
</div>

<div id="about_bottom" class="row-fluid">
    <div class="span10 offset1">

        <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/about_connect.jpg', Yii::t('about', 'about.footer.goal.alt'), array('class' => 'img-polaroid')); ?>
        <!--<img src="holder.js/490x326" class="">-->
        <p class="lead"><strong>
                <small><?php echo Yii::t('about', 'about.footer.goal');?></small>
            </strong></p>

        <hr/>

    </div>

    <div id="about_team" class="span12">

        <p><strong><?php echo Yii::t('about', 'about.footer.team'); ?></strong></p>

        <?php if ($MOBILE_PHONE_ACCESS=='Y') echo '<TABLE width="80%" border="2">'; 
                                        else echo '<TABLE width="100%">'; ?>

        <TR>

        <TD>
        <blockquote>
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_Mohammed_Ali_Akbar.jpg');?> 
            <p><?php echo Yii::t('about', 'Mohammed Ali Akbar') ?></p>
            <small><?php echo Yii::t('about', 'Director of Development') ?></small>
        </blockquote>
        </TD>

        <TD>
        <blockquote>
             <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_yonas.jpg');?> 
            <p><?php echo Yii::t('about', 'about.team.yonas') ?></p>
            <small><?php echo Yii::t('about', 'about.team.yonas.title') ?></small>
        </blockquote>
        </TD>

        <?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</TR><TR>"; ?>
		
		 <TD>
        <blockquote>
             <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_kevin.jpg');?> 
            <p><?php echo Yii::t('about', 'Kevin') ?></p>
            <small><?php echo Yii::t('about', 'Website Admin and Developer') ?></small>
        </blockquote>
        </TD>
		
		
		  <TD>
        <blockquote>
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_ahmad.jpg');?> 
            <p><?php echo Yii::t('about', 'about.team.ahmad') ?></p>
            <small><?php echo Yii::t('about', 'U of T') ?></small>
            <small><?php echo Yii::t('about', 'about.team.ahmad.title2') ?></small>
        </blockquote>
        </TD>



		
	<?php if ($MOBILE_PHONE_ACCESS=='N') echo "</TR><TR>"; ?>
        <TD>
        <blockquote>
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_lyza.jpg');?>
            <p><?php echo Yii::t('about', 'about.team.lyza') ?></p>
            <small><?php echo Yii::t('about', 'about.team.lyza.title') ?></small>
            <small><?php echo Yii::t('about', 'about.team.lyza.title2') ?></small>
        </blockquote>
        </TD>

        

        <TD>
        <blockquote>
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_wenbin.jpg');?>
            <p><?php echo Yii::t('about', 'about.team.wenbin') ?></p>
            <small><?php echo Yii::t('about', 'about.team.wenbin.title') ?></small>
        </blockquote>
        </TD>
        
        <?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</TR><TR>"; ?>

	<TD>	
        <blockquote>
             <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_fahmi.jpg');?> 
            <p><?php echo Yii::t('about', 'about.team.fahmi') ?></p>
            <small><?php echo Yii::t('about', 'about.team.fahmi.title') ?></small>
	    <small><?php echo Yii::t('about', 'about.team.fahmi.title2') ?></small>
        </blockquote>
        </TD>

        <TD>		
        <blockquote>
            <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_matthew.jpg');?>
            <p><?php echo Yii::t('about', 'about.team.matthew') ?></p>
            <small><?php echo Yii::t('about', 'about.team.matthew.title') ?></small>
        </blockquote>
        </TD>

        <?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</TR><TR>"; ?>
        <?php if ($MOBILE_PHONE_ACCESS=='N') echo "</TR><TR>"; ?>

        <TD>
        <blockquote>
             <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_nelly.jpg');?> 
            <p><?php echo Yii::t('about', 'about.team.nelly') ?></p>
            <small><?php echo Yii::t('about', 'about.team.nelly.title') ?></small>
            <small><?php echo Yii::t('about', 'about.team.nelly.title2') ?></small>
        </blockquote>
        </TD>

       
		
        <?php if ($MOBILE_PHONE_ACCESS=='Y') echo "</TR><TR>"; ?>

	<TD>
        <blockquote>
             <?php echo CHtml::image(Yii::app()->getBaseUrl() . '/files/images/team/team_ibrahim.jpg');?> 
            <p><?php echo Yii::t('about', 'Ibrahim') ?></p>
            <small><?php echo Yii::t('about', 'Marketing Analyst') ?></small>
        </blockquote>
        </TD>

        </TR>
        </TABLE>


        <!-- <ul class="thumbnails">
            <li class="span3">
                <div class="thumbnail">
                    <p class="lead"><?php /*echo Yii::t('about', 'about.team.wenbin') */?></p>
                    <p class="text-info"><?php /*echo Yii::t('about', 'about.team.wenbin.title') */?></p>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail">
                    <p class="lead"><?php /*echo Yii::t('about', 'about.team.matthew') */?></p>
                    <p class="text-info"><?php /*echo Yii::t('about', 'about.team.matthew.title') */?></p>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail">
                    <p class="lead"><?php /*echo Yii::t('about', 'about.team.mohamed') */?></p>
                    <p class="text-info"><?php /*echo Yii::t('about', 'about.team.mohamed.title') */?></p>
                    <p class="text-info"><?php /*echo Yii::t('about', 'about.team.mohamed.title2') */?></p>
                </div>
            </li>
            <li class="span3">
                <div class="thumbnail">
                    <p class="lead"><?php /*echo Yii::t('about', 'about.team.lyza') */?></p>
                    <p class="text-info"><?php /*echo Yii::t('about', 'about.team.lyza.title') */?></p>
                    <p class="text-info"><?php /*echo Yii::t('about', 'about.team.lyza.title2') */?></p>
                </div>
            </li>
        </ul>-->
    </div>

</div>
