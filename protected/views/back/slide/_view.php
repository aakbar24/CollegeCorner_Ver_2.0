<div class="view">

    <hr/>

    <div class="row-fluid" id="area_slide">

        <h1 class="ordinal"><?php echo Formatter::formatOrdinal($index + 1); ?></h1>

        <?php  $this->widget('bootstrap.widgets.TbLinkCarousel', array(
            'items' => array(
                array('image' => Slide::generateImagePath($data->slide_image, $data->slide_id), 'label' => $data->label, 'caption' => $data->caption, 'link' => array('view', 'id' => $data->slide_id))),
            'htmlOptions' => array('id' => 'viewSlider'),
            'options' => array('interval'=>false)
        )); ?>

    </div>




</div>