<?php
/* @var $this SiteController */
$this->layout = '//layouts/resource';
$this->pageTitle = Yii::app()->name . ' - ' . Yii::t('view', 'workshops.workshops');
$this->pageNoPadding = false;
?>

<?php

//$this->renderPartial("//layouts/_post_items_header", array('type'=>Article::POST_TYPE));

?>

<!--<div id="planned_workshops">

        <div class="page-header">
            <h1>
                Planned Workshops

                <?php /*$this->widget('bootstrap.widgets.TbButton', array(
                    'label' => "&nbsp; Workshop Calendar",
                    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'url' => array('/workshop/workshop/index'),
                    'icon' => 'calendar',
                    'encodeLabel' => false,
                    'htmlOptions' => array('class' => 'pull-right')
                )); */?>
            </h1>
        </div>

    <div class="row-fluid">
        <div class="span10 offset1">


        <?php
/*
        $this->widget('zii.widgets.CListView', array(
    'dataProvider' => $plannedWorkshopData,
    'itemView' => '//layouts/_planned_workshop_listing',
    'emptyText' => "<p>No Planned Workshops</p>",
    'template' => '<dl>{items}</dl>',
    'ajaxUpdate' => false,
    'htmlOptions' => array('class' => 'listView_planned_workshops'),
));
*/?>
        </div>
        
    </div>
</div>-->

<hr/>

<div id="scheduled_workshops">

    <div class="page-header">
        <h1>
            Scheduled Workshops
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                    'label' => "&nbsp; Calendar",
                    'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                    'url' => array('/workshop/workshop/index'),
                    'icon' => 'calendar',
                    'encodeLabel' => false,
                    'htmlOptions' => array('class' => 'pull-right calendar')
                )); ?>
        </h1>
    </div>

    <?php

    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $workshopData,
        'itemView' => '//layouts/_workshop_listing',
        'emptyText' => "<div class='alert alert-info'><p><strong>No Upcoming Workshops</strong> - Check back soon!</p></div>",
        'template' => '{pager}{items}{pager}',
        'ajaxUpdate' => false,
        'htmlOptions' => array('class' => 'listView_workshops'),
    ));

    ?>

</div>

