<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<?php $this->widget('bootstrap.widgets.TbAlert', array(
				'block'=>true, // display a larger alert block?
				'fade'=>true, // use transitions?
				'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
				'alerts'=>array( // configurations per alert type
						'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
						'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
						'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
						'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'),
				),
    		));?>
<div class="row-fluid">
    <div class="span3">
        <div id="sidebar">
        <?php
            $this->widget('bootstrap.widgets.TbMenu', array(
            	'type'=>'list',
                'items'=>$this->menu,
                'encodeLabel'=> false,
            	'htmlOptions'=>array('class'=>'admin-menu'),
            ));
        ?>
        </div><!-- sidebar -->
    </div>
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
    
</div>
<?php $this->endContent(); ?>