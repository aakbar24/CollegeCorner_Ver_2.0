
//alert("teststs 2");
$(function() {
  //  alert("teststs 2");
    $('#main-content').load('<?php echo Yii::app()->baseUrl;?>/protected/views/front/layouts/post-a-resume.html');
$('ul#nav li a').click(function(){
    // alert("teststs 1");
  var page = $(this).attr('herf');
//   alert("teststs 2");
 $('#main-content').load('<?php echo Yii::app()->baseUrl;?>/protected/views/front/layouts/post-a-resume.html');
//     alert("teststs 3");
});
});

