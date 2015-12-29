
<?php $form = $this->beginWidget('CActiveForm', array(
    'id'=>'login-form',
    'enableAjaxValidation'=>true,
	//'action'=>Yii::app()->createUrl('auth/login'),
   'focus'=>array($model,'username'),
    'clientOptions'=>array(
        'validateOnChange'=>false,
        'validateOnSubmit'=>true,
        'hideErrorMessage'=>true,
    ),
)); ?>
 <div class="popup-header">
    <a class="close"><i class="fa fa-remove fa-lg"></i></a>
    <h2>Login</h2>
</div>
<ul class="social-login">
    <li><a class="btn btn-facebook"><i class="fa fa-facebook"></i>Sign In with Facebook</a></li>
    <li><a class="btn btn-google"><i class="fa fa-google-plus"></i>Sign In with Google</a></li>
    <li><a class="btn btn-linkedin"><i class="fa fa-linkedin"></i>Sign In with LinkedIn</a></li>
					</ul>
<?php echo $form->errorSummary($model); ?>
 <div class="form-group">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username'); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>
 
    <div class="form-group">
        <?php echo $form->labelEx($model, 'password'); ?>
        <?php echo $form->passwordField($model, 'password'); ?>
        <?php echo $form->error($model, 'password'); ?>
    </div>
 
   
 
    <div class="row buttons">
        <?php echo CHtml::submitButton('Login', array('id' => 'login','class' => 'btn btn-primary')); ?>
    </div>
 
    <?php $this->endWidget(); ?>
</div><!-- form -->
<script>
$(document).ready(function()
{
    $('#login-form').submit(function(event)
    {
        event.preventDefault();
        var $form = $(this);
        $.ajax({
            url: '<?php echo Yii::app()->request->baseUrl; ?>/auth/login',
            dataType: 'json',
            type: 'POST',
            data : $form.serialize()+'&ajax='+$form.attr('id'),
            success: function(data, textStatus, XMLHttpRequest)
            {
               
                if(data.authenticated)
                            {
                                window.location = data.redirectUrl;
                            }
                else{
                     $.each(data, function(key, value) {
                                    var div = "#"+key+"_em_";
                                    $(div).text(value);
                                    $(div).show();
                                });
                                $("#login").attr("disabled",false);
                     
                }
				
            },
            error: function(XMLHttpRequest, textStatus, errorThrown)
            {
 
            }
        });
        return false;
    })
})
</script>