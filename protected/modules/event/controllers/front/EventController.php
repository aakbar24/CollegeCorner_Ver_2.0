<?php

class EventController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/resource';

	public $tabMenus=null;
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + signup'
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			
			array('allow', 
				'actions'=>array('index','view','feed'),
				'users'=>array('*'),
			),
				
			array('allow', 
					'actions'=>array('signup'),
					'users'=>array('@'),
					'expression'=>'$user->user_group_id==Student::USER_GROUP_ID',
			),
				
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$alreadySignup=false;
		if (!Yii::app()->user->isGuest) {
			$alreadySignup=StudentEvent::model()->exists('user_id=:user_id AND post_item_id=:post_item_id',array(':user_id'=>Yii::app()->user->id,':post_item_id'=>$id));			
		}
		
		$this->render('view',array(
			'model'=>new EventForm('view',$id),
			'alreadySignup'=>$alreadySignup,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='event-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionFeed(){
		if (isset($_GET['start']) && isset($_GET['end'])) {
			$model=new Event('search');
			$collegeId=null;
			if (Yii::app()->user->isStudent()) {
				$student=Student::model()->findByPk(Yii::app()->user->id);
				$collegeId=$student->college_id;
			}
			$events=$model->searchEventsForFeed($collegeId, $_GET['start'],$_GET['end']);
			
			if (!empty($events)) {
				$eventSources=array();
				foreach ($events as $key=>$event) {
					$eventSources[$key]['id']=$event['post_item_id'];
					$eventSources[$key]['title']=$event['title'];
					$eventSources[$key]['start']=$event['start_date'].' '.$event['start_time'];
					$eventSources[$key]['end']=$event['end_date'].' '.$event['end_time'];
					$eventSources[$key]['allDay']=false;
					$eventSources[$key]['color']=$event['event_background_color'];
					$eventSources[$key]['textColor']=$event['event_text_color'];
					$eventSources[$key]['signup']='Public Signup: '.($event['college_name']!=null?$event['college_name'].' Only':'yes');
					$eventSources[$key]['url']=$this->createAbsoluteUrl('view',array('id'=>$event['post_item_id']));
				}
				echo CJSON::encode($eventSources);
    			
			}
		}
		Yii::app()->end();
	}
	
	public function actionSignup($id){
		if (isset($id)) {
			if (Yii::app()->request->isPostRequest) {
				$event=Event::model()->findByPk($id);
				if ($event!=null) {
					if (!$event->isPublic()) {
						$isStuFromCollege=Student::model()->exists('user_id=:user_id AND college_id=:college_id',array(':user_id'=>Yii::app()->user->id,':college_id'=>$event->college_id));
						if (!$isStuFromCollege) {
							throw new CHttpException(400,'Sorry, you cannot sign up for this event.');
						}
					}
					$studentEvent=new StudentEvent();
					$studentEvent->user_id=Yii::app()->user->id;
					$studentEvent->post_item_id=$id;
					
					if ($studentEvent->save()) {
						Yii::app()->user->setFlash('success', Yii::t('app', 'msg.success.event_signup'));
						$this->redirect(array('view','id'=>$id));
					}					
				}else{
					throw new CHttpException(400,'Event not found.');
				}
			}else{
				throw new CHttpException(400,'Invalid Request');
			}
		}
		else{
			throw new CHttpException(400,'Event not found.');
		}
	}
}
