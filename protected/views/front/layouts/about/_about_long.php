<div id="about_top_attract" class="row-fluid">
    <div class="span10 offset1">
        <h1><?php echo Yii::t('about', 'about.title');?></h1>

        <hr/>


        <blockquote class="modify">
            <p>We Inspire, Inform, and Connect students/candidates </p>
        </blockquote>

        <br/>

        <blockquote class="modify">
            <p>We Arm employers with the tools to grow their business </p>
        </blockquote>


        <hr/>
    </div>
</div>

<div id="about_content" class="row-fluid">
    <div class="span10 offset1">

        <dl>
            <dt id="heading_goal"><?php echo Yii::t('about', 'about.heading.goal');?></dt>
            <dd><?php echo Yii::t('about', 'about.content.goal');?></dd>

            <dd><?php echo Yii::t('about', 'about.success');?></dd>

            <dt><a class="anchor"
                   id="student_success"></a><?php echo Yii::t('about', 'about.heading.academic_success');?></dt>
            <dd><?php echo Yii::t('about', 'about.content.academic_success');?></dd>

            <dt><?php echo Yii::t('about', 'about.heading.career_success');?></dt>
            <dd><?php echo Yii::t('about', 'about.content.career_success');?></dd>

            <dt><a class="anchor"
                   id="employer_success"></a> <?php echo Yii::t('about', 'about.heading.employer_success');?></dt>
            <dd><?php echo Yii::t('about', 'about.content.employer_success');?></dd>

            <dt><?php echo Yii::t('about', 'about.heading.workshop_success');?></dt>
            <dd><?php echo Yii::t('about', 'about.content.workshop_success');?></dd>

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

        <blockquote>
            <p><?php echo Yii::t('about', 'about.team.mohamed') ?></p>
            <small><?php echo Yii::t('about', 'about.team.mohamed.title') ?></small>
            <small><?php echo Yii::t('about', 'about.team.mohamed.title2') ?></small>
        </blockquote>

        <blockquote>
            <p><?php echo Yii::t('about', 'about.team.lyza') ?></p>
            <small><?php echo Yii::t('about', 'about.team.lyza.title') ?></small>
            <small><?php echo Yii::t('about', 'about.team.lyza.title2') ?></small>
        </blockquote>

        <blockquote>
            <p><?php echo Yii::t('about', 'about.team.ahmad') ?></p>
            <small><?php echo Yii::t('about', 'about.team.ahmad.title') ?></small>
            <small><?php echo Yii::t('about', 'about.team.ahmad.title2') ?></small>
        </blockquote>

        <blockquote>
            <p><?php echo Yii::t('about', 'about.team.wenbin') ?></p>
            <small><?php echo Yii::t('about', 'about.team.wenbin.title') ?></small>
        </blockquote>

        <blockquote>
            <p><?php echo Yii::t('about', 'about.team.matthew') ?></p>
            <small><?php echo Yii::t('about', 'about.team.matthew.title') ?></small>
        </blockquote>



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
