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



        <div id="content">

            <div class="wedge">

            <?php echo $content; ?>

            <div class="clearfix"></div>

                </div>

        </div><!-- content -->

</div>

<?php $this->endContent(); ?>