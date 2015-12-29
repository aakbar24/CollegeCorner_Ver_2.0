TESTTETETTTSTTSTSTSTSTSTSTSTSTSTSTTSTTSTSTSTSTTSTSTSTSTSTTSTSTSST
<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'login-form',
		'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
				'validateOnSubmit'=>true,
		),
)); ?>
		<?php //echo $form->errorSummary($model); ?>
		<div class="input-row">
			<?php //echo $form->textFieldRow('username',array('class'=>'input-block-level',)); ?>
			<div class="form-group">
						<label for="register-username">Username_Test</label>
						<input type="text" class="form-control" id="register-username">
					</div>
		</div>

		
		
	
		<?php $this->endWidget(); ?>

	</div>