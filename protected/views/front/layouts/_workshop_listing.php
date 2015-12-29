<?php
/* @var SiteController $this*/
?>

<div class="workshop_listing <?php if (!$data['is_running']) echo "muted"; ?>">
    <div class="span2">
        <span class="label label-info label-date">
            <?php
            if ($data['is_running'])
            echo $data['start_date'] . " &#8211; " . $data['end_date'];
            else
            echo Yii::t('view', 'workshop.not_running');
            ?>
        </span>
    </div>
    <div class="span10 rowspan">

        <?php
       $workshopContent = $this->widget('bootstrap.widgets.TbBox', array(
            'title' => $data['title'] . PostItemHelper::drawPostItemLabel(Workshop::POST_TYPE, $data['workshop_cat_name']),
            'content' => $this->renderPartial('//layouts/_workshop_content', array('data' => $data), true)
        ), true);
		if(!Yii::app()->user->isGuest)
		{
        echo CHtml::link($workshopContent, array('workshop/workshop/view', 'id'=>$data['id']), array('class' => 'posting-link'));
		}
		else if(Yii::app()->user->isGuest)
		{
		echo CHtml::link($workshopContent, array('/auth/login'), array('class' => 'posting-link'));
		}
        ?>


        <blockquote class="span3 facilitator">
            <p>
                <strong>Facilitator</strong>
                <small>
                    <?php
                    if (empty($data['facil_first_name']) && empty($data['facil_last_name']))
                        echo "TBA";
                    else
                        echo trim($data['facil_first_name'] . " " . $data['facil_last_name']);
                    ?>
                </small>
            </p>
        </blockquote>

        <blockquote class="span3 company">
            <p><strong>Hosted by</strong><small><?php echo $data['company'] ? $data['company'] : "TBA" ?></small> </p>
        </blockquote>

        <blockquote class="span3 location">
            <p><strong>Location</strong><small><?php echo $data['city'] ? $data['city'] : "TBA" ?></small> </p>
        </blockquote>

    </div>
</div>

