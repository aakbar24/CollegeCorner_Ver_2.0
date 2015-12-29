<?php
/* @var $this ProfileController */
?>

<div class="page-header">
    <h1>
        <small>
            <?php echo Yii::t('view', 'student.index.whats_new_lb'); ?>
            <strong>
                <?php echo College::getUserCollege()->college_name . " " . Yii::t('model', 'collegeAdmin.college_id'); ?>
            </strong>
        </small>
    </h1>
</div>


<?php


$this->renderPartial('/layouts/_snippetWorkshop');

$this->renderPartial('/layouts/_snippetEvents');

$this->renderPartial('/layouts/_snippetTopics');

$this->renderPartial('/layouts/_snippetReplies');


?>
