<?php

$this->beginContent('/layouts/mainView'); 

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
      
<?php echo $content ?>


<?php  $this->endContent();  ?>
