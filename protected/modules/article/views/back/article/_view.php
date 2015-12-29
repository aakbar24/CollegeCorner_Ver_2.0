<div class="view">
        
        <fieldset>
    <legend>
        <h1 class="pull-left"><?php echo $data->postItem->title; ?></h1>
        <h5 class="pull-right">
            Posted On: <?php echo CHtml::tag('span', array('class' => 'view_date_text'), $data->postItem->date_created); ?><br/>
            Updated: <?php echo CHtml::tag('span', array('class' => 'view_date_text'), $data->postItem->date_updated != '' ? $data->postItem->date_updated : "N / A"); ?>
        </h5>
    </legend>

    <?php
    $this->widget('bootstrap.widgets.TbBox', array(
        'title' => "ID: " . $data->post_item_id,
        'headerIcon' => 'icon-tag',
        'content' => $data->postItem->description
    ));
    ?>

    <h5>Source: <?php echo CHtml::link($data->getSource(), $data->source) ?></h5>

</fieldset>

    <hr/>

</div>