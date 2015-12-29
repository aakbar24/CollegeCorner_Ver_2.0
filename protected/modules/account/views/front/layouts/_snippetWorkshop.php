<?php
/* @var $this ProfileController */
?>

<div class="row-fluid">

    <div class="span-12">

        <div class="snippet-header">
            <h1><?php echo Yii::t('view', 'workshop.latest'); ?></h1>
        </div>

        <?php

        $this->widget('bootstrap.widgets.TbExtendedGridView', array(
            'dataProvider' => Workshop::getLatestWorkshopsSnippet(Yii::app()->params['defaultLatestWorkshopsToGet'], Yii::app()->user->getId()),
            'selectableCells' => true,
            'columns' => array(
                array(
                    'name' => 'workshop_cat_name',
                    'header' => 'Category',),
                array('name' => 'title',
                    'header' => 'Title'),
                array('name' => 'city',
                    'header' => 'Location'),
                array(
                    'header' => 'Date',
                    'type' => 'raw',
                    'value' => '$data["start_date"] . "<br>" . $data["end_date"]'),
                array(
                    'header' => 'Time',
                    'type' => 'raw',
                    'value' => '$data["start_time"] . "<br>" . $data["end_time"]'),
                array(
                    'header' => 'Register',
                    'type' => 'raw',
                    'value' => 'generateWorkshopBtn($data["id"], $data["registered"])'),
                array(
                    'value' => 'Yii::app()->getController()->createAbsoluteUrl("/workshop/workshop/view", array("id" => $data["id"]))',
                    'headerHtmlOptions' => array('style' => 'display: none;'),
                    'htmlOptions' => array('class' => 'link', 'style' => 'display: none;'))
            ),
            'rowCssClassExpression' => '"link-row"',
            'selectableRows' => 1,
            'template' => "{items}",
            'emptyText' => "There are currently no Workshops",
            'type' => 'bordered',
            'htmlOptions' => array('class' => 'snippetWorkshopGrid')
        ));

        $btn = $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('view', 'workshop.more'),
            'type' => 'primary',
            'url' => array('/workshop/workshop/index'),
            'size' => 'large',
            'icon' => 'wrench'
        ), true);

        echo CHtml::tag('div', array('class' => 'snippet-more-area'), $btn);

        ?>

    </div>

</div>

<?php

Yii::app()->clientScript->registerScript('snippertWorkshop', <<<EOD
	$(document).ready(function (){

       $('.snippetWorkshopGrid tbody tr td').not(':has(a)').click(function(){
         var link = $(this).parent('tr').children("td.link").html();
           if(link!=null)
				window.location.assign(link);
       });

       $('.snippetWorkshopGrid .btn-primary').click(function(e){
       });

   });
EOD
,CClientScript::POS_READY);


function generateWorkshopBtn($workshopId, $registered = null)
{
    if (empty($registered))
    {
    $btn = Yii::app()->getController()->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('view', 'workshop.btn.join_now'),
        'type' => 'primary',
        'url' => array('/workshop/workshop/signup', 'id' => $workshopId),
        'htmlOptions' => array('submit' => array('/workshop/workshop/signup', 'id' => $workshopId) )
    ), true);
    }
    else{
        $btn = Yii::app()->getController()->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('view', 'workshop.btn.joined'),
            'type' => 'warning',
            'htmlOptions' => array('disabled' => 'true')
        ), true);
    }

    return $btn;
}

?>