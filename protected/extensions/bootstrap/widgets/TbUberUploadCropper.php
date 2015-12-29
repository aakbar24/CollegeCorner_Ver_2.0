<?php
class TbUberUploadCropper extends CInputWidget{
	/**
	 * @var TbActiveForm
	 */
	public $form;
	
	public $options = array();
	
	private static $_DEFAULT_OPTIONS=array(
				'fineuploader'=>array(
						'multiple'=>false,
						'validation'=>array('sizeLimint'=>2097152,'allowedExtensions'=>array('jpg','jpeg','png','gif')),
						'text'=>array('uploadButton'=>'<div><i class="icon-upload icon-white"></i> Upload</div>'),
						'template'=>'<div class="qq-uploader span12"><pre class="qq-upload-drop-area span12"><span>{dragZoneText}</span></pre><div class="qq-upload-button btn btn-info" style="width: auto;">{uploadButtonText}</div><ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul></div>',
						'classes'=>array('success'=>'alert alert-success','fail'=>'alert alert-error'),
						),
				'jcrop'=>array(
						'aspectRatio'=>1,
						'allowSelect'=>false,
						'allowResize'=>false,
						'setSelect'=>array(0,0,200,200),
						),
								
			);
	
	/**
	 * @var string[] the JavaScript event handlers.
	 */
	public $events = array();
	
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();

	public $tagHtmlOptions=array();
	
	public $tag='div';
	
	public $uploadIdPostFix='-imageupload';
	public $imageIdPostFix='-image';
	
	/**
	 * @var the destination upload folder 
	 */
	public $uploadFolder;
	
	/**
	 * @var string the crop action url
	 */
	public $cropActionUrl;
	
	/**
	 * @var string the upload action url
	 */
	public $uploadActionUrl;
	
	/**
	 * @var int[] integer array that holds the crop selectio coordinates
	 */
	public $cropCoor;
	
	/**
	 * @var string specifies another model attribute if the image file name is stored else where other than the supplied attribute.
	 */
	public $existingFileAttribute;
	
	/**
	 * @var string specifies another file folder if the image file is stored else where other than the suupplied upload folder.
	 */
	public $existingFileFolder;
	
	/**
	 * Runs the widget.
	 */
	public function run()
	{
		if (!isset($this->uploadFolder)||!isset($this->uploadActionUrl)||!isset($this->cropActionUrl)) {
			throw new CException("uploadFolder, uploadActionUrl, and cropActionUrl are required.");
		}
		
		list($name, $id) = $this->resolveNameID();
	
		$imagePath=$this->value;
		$imageTag='';
		if ($this->hasModel())
		{
			if ($this->form)
				$content= $this->form->hiddenField($this->model, $this->attribute, $this->htmlOptions);
			else
				$content= CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
			$imagePath=CHtml::resolveValue($this->model, $this->attribute);
			
			if(isset($this->model->attributes[$this->existingFileAttribute])){
				if($this->model->attributes[$this->existingFileAttribute]!=''){
					if (isset($this->existingFileAttribute)) {
						$imagePath=CHtml::resolveValue($this->model, $this->existingFileAttribute);
					}
					if (isset($this->existingFileFolder) && ($imagePath!=null && $imagePath!='')) {
						$imagePath=$this->existingFileFolder.'/'.$imagePath;
					}
				}	
			}
			
		} else 
			$content= CHtml::hiddenField($name, $this->value, $this->htmlOptions);
		
		if ($imagePath!=null && $imagePath!=''){
			$imageTag=CHtml::image($imagePath.'?_='.time());
		}
		
		$content.=CHtml::tag('div',array('id'=>$id.$this->uploadIdPostFix),'',true);
		$content.=CHtml::tag('div',array('id'=>$id.$this->imageIdPostFix),$imageTag,true);
		echo CHtml::tag($this->tag,$this->tagHtmlOptions,$content,true);
		
		$this->registerClientScript($id);
	
	}
	
	/**
	 * Registers required javascript files
	 * @param string $id
	 */
	public function registerClientScript($id)
	{
		Yii::app()->bootstrap->registerAssetCss('jQuery-Impromptu/bootstrap-impromptu.css');
		Yii::app()->bootstrap->registerAssetCss('fineuploader/fineuploader.css');
		Yii::app()->bootstrap->registerAssetCss('Jcrop/jquery.Jcrop.min.css');
		Yii::app()->bootstrap->registerAssetJs('jQuery-Impromptu/jquery-impromptu.js');
		Yii::app()->bootstrap->registerAssetJs('fineuploader/jquery.fineuploader-3.0.min.js');
		Yii::app()->bootstrap->registerAssetJs('Jcrop/jquery.Jcrop.min.js');
		Yii::app()->bootstrap->registerAssetJs('jquery-uberuploadcropper.js');
	
		$this->setOptions($id);
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		$id=$id.$this->uploadIdPostFix;
		ob_start();
	
		echo "jQuery('#{$id}').uberuploadcropper({$options})";
		foreach ($this->events as $event => $handler)
			echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
	
			Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, ob_get_clean() . ';');
	}
	
	protected function setOptions($id){
		$this->options=CMap::mergeArray(self::$_DEFAULT_OPTIONS, $this->options);
		
		if(isset($this->options['fineuploader']))
			$this->options['fineuploader']['request']['endpoint']=$this->uploadActionUrl;
		else
			$this->options['fineuploader']=array('request'=>array('endpoint'=>$this->uploadActionUrl));
		
		if (isset($this->cropCoor))
			$this->options['jcrop']['setSelect']=$this->cropCoor;
		
		$this->options['folder']=$this->uploadFolder.'/';
		$this->options['cropAction']=$this->cropActionUrl;
		
		$imgHolderId=$id.$this->imageIdPostFix;
		
		$this->options['onComplete']="js:function(e,imgs,data){jQuery('#{$imgHolderId}').html('<img src=\"{$this->uploadFolder}/'+ imgs[0].filename +'?d='+ (new Date()).getTime() +'\" />'); jQuery('#{$id}').val('{$this->uploadFolder}/'+ imgs[0].filename);}";
		
	}
}