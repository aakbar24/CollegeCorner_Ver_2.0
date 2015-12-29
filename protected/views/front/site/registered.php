<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - Thank You';
$this->breadcrumbs = array(
    'Registered',
);
?>
<div id="registered_page">
    <h1><?php echo Yii::t('view', 'register.thank_you'); ?></h1>

    <hr/>

    <p>
        <?php if (isset($message)) echo $message; ?>
    </p>

    <p>
        <?php echo Yii::t('view', 'register.questions_concerns') . CHtml::link(Yii::t('view', 'register.contact_us'), array('site/contact')); ?>
    </p>


</div>