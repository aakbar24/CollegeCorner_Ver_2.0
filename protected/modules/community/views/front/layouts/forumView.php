<?php
/* @var $this Controller */
/* @var Yii::app()->user WebUser */

$cs = Yii::app()->getClientScript();

$cs->registerCssFile(Yii::app()->baseUrl . '/css/forum.css');
Yii::log(Yii::app()->baseUrl . '/protected/modules/community/assets/forum.css');

$this->beginContent('//layouts/profile'); 

?>

<div class="page-header">
	<h1>
		<?php echo $this->areaLarge;?> <small><?php echo $this->areaSmall ?></small>
	</h1>
</div>

<?php 
if(isset($this->forumBreadcrumb) && !empty($this->forumBreadcrumb))
    $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->forumBreadcrumb,
        'homeLink'=>false,
    ));
?>


<?php 
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
'id'=>'searchForm',
'type'=>'search',
)); 
?>

<?php
echo $form->textFieldRow($this->search, 'searchString',
array('class'=>'input-medium', 'prepend'=>'<i class="icon-search"></i>'));
?>
<?php 
$this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); 
echo $form->error($this->search, 'searchString');
echo $form->hiddenField($this->search, 'programId');
echo $form->hiddenField($this->search, 'semesterId');
?>

<!--<div id="forum-topics-top-bar">-->
  
    <?php 
if ($this->canPost)
{
$this->widget('bootstrap.widgets.TbButton',array(
'label' => 'New Post',
'type' => 'primary',
'url'=>$this->createAbsoluteUrl('post/create', array('programId'=>$this->programId, 'semesterId'=>$this->semesterId)),
'htmlOptions'=>array('class'=>'pull-right')    
)); 
}
?>  
    
<!--</div>-->



 
<?php 
$this->endWidget(); 

$this->widget('bootstrap.widgets.TbAlert', array(
    'block' => true, // display a larger alert block?
    'fade' => true, // use transitions?
    'closeText' => '×', // close link text - if set to false, no close link is displayed
    'alerts' => array(// configurations per alert type
        'error' => array('block' => true, 'fade' => true, 'closeText' => '×'),
         'success' => array('block' => true, 'fade' => true, 'closeText' => '×'),// success, info, warning, error or danger
    ),
    'htmlOptions' => array('class' => 'forum-alert-topics')
));

?>
      

<?php echo $content ?>


<?php  $this->endContent();  ?>


