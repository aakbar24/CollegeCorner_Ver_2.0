<?php 
/************************A dialog that will hold the student profile html from the ajax request**********************************/
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
		'id'=>'view-profile-dialog',
		'htmlOptions'=>array('class'=>''),
		// additional javascript options for the dialog plugin
		'options'=>array(
				'title'=>'User Profile',
				'autoOpen'=>false,
				'width'=>'450',
				'resizable'=>false,
				'position'=>array('at'=>'left','my'=>'right top','of'=>$ofPosition),
		),
));
?>

<div class="profile-content "></div>
<div class="profile-content-cache hide"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');

$cs=Yii::app()->clientScript;
// registers the view profile javascript
$viewProfileUrl=Yii::app()->createAbsoluteUrl('account/profile/viewProfile');
$postAjaxCall=<<<EOD
	$('#view-profile-dialog .profile-content-cache').append(response);
	$('#view-profile-dialog .profile-content').html(response);
	$('#view-profile-dialog').dialog('open');
EOD;
$cachedCall=<<<EOD
	var profileHtml=$('#profile'+user_id).clone();
	$('#view-profile-dialog .profile-content').html(profileHtml);
	$('#view-profile-dialog').dialog('open');
EOD;
$viewProfileJS=$this->renderPartial('/common/scripts/_viewProfileJS',array('postAjaxCall'=>$postAjaxCall,'cachedCall'=>$cachedCall,'url'=>$viewProfileUrl),true);
$cs->registerScript(__FILE__.'_ViewProfile', $viewProfileJS,CClientScript::POS_END);