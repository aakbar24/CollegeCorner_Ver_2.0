<?php
/** @var $model WorkshopForm */
$this->breadcrumbs = array(
    'Workshops' => array('//site/workshops'),
    $model->postItem->title,
);
?>
<?php if ($model->workshop->is_approved != true): ?>
    <span class="label label-warning">Pending Approval</span>
<?php endif; ?>
<h1><?php echo $model->postItem->title; ?>
    <small>
        Provider: <?php echo ($model->workshop->company != null ? $model->workshop->company : "TBA");?></small>
</h1>

<fieldset>
    <legend>
        <?php echo Yii::t('view', 'workshop.workshop_info_lb')?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => "&nbsp; Calendar",
            'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'url' => array('/workshop/workshop/index'),
            'icon' => 'calendar',
            'encodeLabel' => false,
            'htmlOptions' => array('class' => 'pull-right calendar')
        )); ?>
    </legend>
    <?php
    $this->widget('bootstrap.widgets.TbBox', array(
        'title' => $model->postItem->title,
        'headerIcon' => 'icon-flag-checkered',
        'content' => $model->postItem->description
    ));
    ?>
</fieldset>

<div class="row-fluid">
    <fieldset class="span6">
        <legend><?php echo Yii::t('view', 'workshop.location_info_lb')?></legend>
        <?php $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model->workshop,
            'type' => array('bordered'),
            'attributes' => array(
                'address',
                'city',
                'province',
                'postal_code',
                'countryName',
                'phone',
                'ext' => array('name' => 'ext', 'visible' => $model->workshop->ext != null),
            ),
        )); Yii::log($model->workshop->ext);?>
    </fieldset>

    <fieldset id="date-time" class="span6">
        <legend><?php echo Yii::t('view', 'workshop.datetime_info_lb')?></legend>
        <?php $this->widget('bootstrap.widgets.TbDetailView', array(
            'data' => $model->workshop,
            'type' => array('bordered'),
            'attributes' => array(
                'start_date:date',
                'end_date:date',
                'start_time:time',
                'end_time:time',
            ),
        )); ?>
        <?php if ($alreadySignup): ?>
            <span class="label label-success">You already signed-up for this workshop.</span>
            <br/>
        <?php endif;?>
        <?php if (!$model->workshop->is_running): ?>
            <span class="label label-important">This workshop is not running.</span>
        <?php elseif ($model->workshop->isHistory()): ?>
            <span class="label label-info">This workshop is over.</span>
        <?php else: ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label' => Yii::t('view', 'signup_lb'),
                'type' => 'info',
                'size' => 'large',
                'buttonType' => 'submitLink',
                'htmlOptions' => array('submit' => array('signup', 'id' => $model->workshop->post_item_id),),
                //'url'=>array('signup',array('id'=>$model->event->post_item_id)),//array('/event/event/signup','id'=>$model->postItem->post_item_id),
                'visible' => !$alreadySignup,
            ));

            if (Yii::app()->user->isGuest)
            {
                echo CHtml::tag("span",array('class'=>'text-error'), "<small>* You will have to log-in or register</small>");
            }

            ?>
        <?php endif;?>

    </fieldset>

</div>


<!-- ************************************************************************** -->
<!-- ************************************************************************** -->

<?php 
      
      $USER_ID_REQUESTING_STUDENT_LIST = Yii::app()->user->id;
      $USER_GROUP_ID_FOR_STUDENT_LIST  = Yii::app()->user->user_group_id;
      $WORKSHOP_ID_FOR_STUDENT_LIST    = $_GET['id'];
      $WORKSHOP_OWNER_EMPLOYER_ID      = -1234;
      
      // Check if the user is an employer 
      if ($USER_GROUP_ID_FOR_STUDENT_LIST == 2) {

      	 $link = mysql_connect('colcnstprod.db.10437204.hostedresource.com:3306','colcnstprod', 'T6x5!@Wk');
         if (!$link) {
               die('Could not connect: ' . mysql_error());
         }
         $db_selected = mysql_select_db('colcnstprod', $link);
         if (!$db_selected) {
              die ('Can\'t use colcnstprod : ' . mysql_error()); 
         }

    	   // Check if the workshop belongs to this employer.
    	   $sql_text = " SELECT v.user_id " .
    	               " FROM   `v_workshop` v " .
    	               " WHERE  v.`workshop_id` = " . $WORKSHOP_ID_FOR_STUDENT_LIST ; 

    	   $result = mysql_query($sql_text,$link);
    	       
    	   if (! $result) {
    	  	    $message  = 'Invalid query: ' . mysql_error() . "\n";
              $message .= 'Whole query: ' . $sql_text;
              die($message);
    	   }
         $row = mysql_fetch_assoc($result);
         $WORKSHOP_OWNER_EMPLOYER_ID = $row['user_id'];
    	   mysql_free_result($result);
    	  
    	  if ($USER_ID_REQUESTING_STUDENT_LIST == $WORKSHOP_OWNER_EMPLOYER_ID) {
    	  	    $sql_text =" SELECT u.FIRST_NAME, u.LAST_NAME, u.EMAIL " . 
                         " FROM   `tbl_student_workshop` sw, `tbl_user` u " .
                         " WHERE  sw.`post_item_id` = " . $WORKSHOP_ID_FOR_STUDENT_LIST .
                         "   AND  sw.`user_id` = u.`user_id` " . 
                         " ORDER BY u.LAST_NAME, u.FIRST_NAME ";

           	 $result = mysql_query($sql_text,$link);
    	       
    	       if (! $result) {
    	  	       $message  = 'Invalid query: ' . mysql_error() . "\n";
                 $message .= 'Whole query: ' . $sql_text;
                 die($message);
    	       }
    	       $counter=0;
             echo "<B>POSSIBLE PARTICIPANT LIST FOR THE WORKSHOP</B>";

    	     echo "<TABLE BORDER=1 BORDERCOLOR=#D8D8D8>";
             echo "<TR><TD>SEQ #</TD><TD>FIRST NAME</TD><TD>LAST NAME</TD><TD>E-MAIL ADDRESS</TD></TR>";
             while ($row = mysql_fetch_assoc($result)) {
             	     $counter++;
                   echo "<TR><TD>" . $counter . "</TD><TD>" . $row['FIRST_NAME'] . "</TD><TD>" . 
                        $row['LAST_NAME'] . "</TD><TD>" . $row['EMAIL'] . "</TD></TR>";
             }
             if ($counter==0) {
             	   echo "<TR><TD> Nobody has registered to this workshop yet. </TD></TR>";
             }
             echo "</TABLE>";

             mysql_free_result($result);
    	  }
    	  mysql_close($link);
     }

      // echo $USER_ID_REQUESTING_STUDENT_LIST, "<BR>";
      // echo $USER_GROUP_ID_FOR_STUDENT_LIST, "<BR>";
      // echo $WORKSHOP_ID_FOR_STUDENT_LIST, "<BR>"; 
?>

<!-- ************************************************************************** -->
<!-- ************************************************************************** -->`


<div class="row-fluid">
    <fieldset id="facilitator" class="span6">
            <legend><?php echo Yii::t('view', 'workshop.facilitator_info_lb')?></legend>

        <?php if (!empty($model->workshop->workshopFacilitator)): ?>

            <div class="offset1 span10">
                <ul class="thumbnails">
                    <li>
                        <div class="thumbnail">
                            <?php echo CHtml::image($model->workshop->workshopFacilitator->getImageUrl(), "Facilitator - " . $model->workshop->workshopFacilitator->getName()) ?>
                            <h3><?php echo $model->workshop->workshopFacilitator->getName(); ?></h3>

                            <div class="well well-small">
                                <p>
                                    <strong>Biography</strong><br/><?php echo $model->workshop->workshopFacilitator->biography; ?>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

        <?php else: ?>

            <div class='alert alert-info empty'><p>Still pending</p></div>

        <?php endif; ?>

    </fieldset>

    <fieldset id="attachment" class="span6">
        <legend><?php echo Yii::t('view', 'workshop.attachment')?></legend>

        <?php if (!empty($model->workshop->workshop_file)): ?>

            <i class='icon-download-alt'></i>
            <?php
            echo CHtml::link($model->workshop->workshop_file, $model->workshop->generateWorkshopFileUrl());
            ?>

        <?php else: ?>

            <div class='alert alert-info empty'><p>No attachments</p></div>

        <?php endif; ?>

    </fieldset>

</div>


