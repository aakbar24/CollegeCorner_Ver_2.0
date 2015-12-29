<?php 
/*******************************
 * 
 * This is a javascript template that can be used to perform an ajax request 
 * to display user profile.
 * 
 * @var $url - the ajax request url
 * @var $postAjaxCall - the javascript expression that is executed on post ajax call
 * @var $cachedCall - the javascript expression that is executed on cached call
 * ********************************/
?>
function viewProfile(profileLink){
	var user_id=$(profileLink).attr('data-value');
	var url='<?php 
		if (!isset($url)) 
			throw new CException("Url is required");	
		echo $url;
	?>';
	
	if($(profileLink).hasClass('pulled')){
		pullCachedProfile(user_id);
	}else if($('#profile'+user_id).length>=1){
		$(profileLink).addClass('pulled');
		pullCachedProfile(user_id);
	}else{
		if(!$(profileLink).hasClass('loading')){
			$(profileLink).addClass('loading');
			$.ajax({type:'get',	url: url,data:{id:user_id},success:function(response,status,xhr){afterPullingProfile(response,status,xhr);$(profileLink).addClass('pulled').removeClass('loading');}});	
		}		
	}
	
	return false;
}

function afterPullingProfile(response,status,xhr){
	<?php 
	if (isset($postAjaxCall)) {
		$postAjaxCall=new CJavaScriptExpression($postAjaxCall);
		echo $postAjaxCall;
	}
	?>

}

function pullCachedProfile(user_id){
	<?php 
	if (isset($cachedCall)) {
		$cachedCall=new CJavaScriptExpression($cachedCall);
		echo $cachedCall;
	}
	?>
	
}

