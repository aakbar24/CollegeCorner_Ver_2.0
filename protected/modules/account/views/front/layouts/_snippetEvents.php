<?php
/* @var $this ProfileController */
?>

<div class="row-fluid">

    <div class="span-12">

        <div class="snippet-header">
            <h1><?php echo Yii::t('view', 'event.upcoming'); ?></h1>
        </div>

        <?php

        $this->widget('bootstrap.widgets.TbExtendedGridView', array(
            'dataProvider' => Event::getLatestEventsSnippet(Yii::app()->params['defaultLatestEventsToGet'], College::getUserCollege()->college_id),
            'selectableCells' => true,
            'selectableRows' => 1,
            'columns' => array(
                array(
                    'name' => 'title',
                    'header' => 'Title',),
                array('name' => 'city',
                    'header' => 'Location'),
                array(
                    'header' => 'Date',
                    'type' => 'raw',
                    'value' => '$data["start_date"] . CHtml::tag("br") . $data["end_date"]'),
                array(
                    'header' => 'Time',
                    'type' => 'raw',
                    /*'value' => '$data["start_time"] . CHtml::tag("span", array("class" => "dash-spacer"), "-") . $data["end_time"]'),*/
                    'value' => '$data["start_time"] . CHtml::tag("br") . $data["end_time"]'),
                array(
                    'value' => 'Yii::app()->getController()->createAbsoluteUrl("/event/event/view", array("id" => $data["id"]))',
                    'headerHtmlOptions' => array('style' => 'display: none;'),
                    'htmlOptions' => array('class' => 'link', 'style' => 'display: none;'))
            ),
            'template' => "{items}",
            'emptyText' => "There are currently no Events",
            'type' => 'bordered',
            'rowCssClassExpression' => '"link-row"',
            'htmlOptions' => array('class' => 'snippetEventGrid')
        ));

        $btn = $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('view', 'event.more'),
            'type' => 'primary',
            'url' => array('/event/event/index'),
            'size' => 'large',
            'icon' => 'flag'
        ), true);

        echo CHtml::tag('div', array('class' => 'snippet-more-area'), $btn);

        ?>

    </div>

</div>

<script>

   $(document).ready(function (){

       $('.snippetEventGrid tbody tr.link-row').click(function(){
         var link = $(this).children("td.link").html();
           window.location.assign(link);
       });

   });

</script>
<?php 
Yii::app()->clientScript->registerScript('snippertEvent', <<<EOD
	$(document).ready(function (){

       $('.snippetEventGrid tbody tr td').not(':has(a)').click(function(){
         var link = $(this).parent('tr').children("td.link").html();
           if(link!=null)
				window.location.assign(link);
       });

       $('.snippetWorkshopGrid .btn-primary').click(function(e){
       });

   });
EOD
		,CClientScript::POS_READY);
?>