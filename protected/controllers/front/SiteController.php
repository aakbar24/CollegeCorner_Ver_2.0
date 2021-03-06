<?php

class SiteController extends Controller
{
    
    const homePageArticleLimit = 4;
    const listingsPerPage = 8;

    public $viewBreadcrumb = array();

    public $tabMenus = null;
    
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: studentIndex.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/studentIndex.php'
		// using the default layout 'protected/views/layouts/main.php'
            
                $articleData = Article::model()->getBriefArticlesData(self::homePageArticleLimit);

        $slideItems = Slide::getSliderItems();
        Yii::log(CVarDumper::dumpAsString($slideItems));
                
		$this->render('index', array('articleData' => $articleData, 'slideItems' => $slideItems));
	}
        
        public function actionArticles()
	{      
                $articleData = Article::model()->getBriefArticlesData(null, Article::POST_TYPE);
                $articleData->pagination = new CPagination(self::listingsPerPage);

        $this->breadcrumbs=array('Articles');
        $this->tabMenus=array(
            array('label'=>'Articles', 'active'=>true),
            array('label'=>'News', 'url'=>array('/site/news')),
            array('label'=>'Events', 'url'=>array('/event/event/index')),
            array('label'=>'Workshops', 'url'=>array('//site/workshops')),
        );


                
		$this->render('articles', array('articleData' => $articleData));
	}

    public function actionWorkshops()
    {
        $plannedWorkshopData = WorkshopPlanned::getPlannedWorkshops();

        $workshopData = Workshop::getUpcomingWorkshops();
        /*$workshopData->pagination = new CPagination(self::listingsPerPage);*/

        $this->breadcrumbs=array('Workshops');
        $this->tabMenus=array(
            array('label'=>'Articles', 'url'=>array('/site/articles')),
            array('label'=>'News', 'url'=>array('/site/news')),
            array('label'=>'Events', 'url'=>array('/event/event/index')),
            array('label'=>'Workshops', 'active'=>true),
        );

        $this->render('workshops', array('plannedWorkshopData' => $plannedWorkshopData, 'workshopData' => $workshopData));
    }

    public function actionNews()
    {
        $newsData = Article::model()->getBriefArticlesData(null, Article::POST_TYPE_NEWS);
        $newsData->pagination = new CPagination(self::listingsPerPage);

        $this->breadcrumbs=array('News');
        $this->tabMenus=array(
            array('label'=>'Articles', 'url'=>array('/site/articles')),
            array('label'=>'News', 'active'=>true),
            array('label'=>'Events', 'url'=>array('/event/event/index')),
            array('label'=>'Workshops', 'url'=>array('//site/workshops')),
        );

        $this->render('news', array('newsData' => $newsData));
    }

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				if(mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers)){
					Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				}
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionReadPosting($id)
    {
        $typeId = PostItem::model()->findByPk($id)->getAttribute("post_type_id");

        switch($typeId)
        {
            case Article::POST_TYPE:
            {
                $this->_displayArticle($id);
                break;
            }
            case Event::POST_TYPE:
            {
                break;
            }
            case Article::POST_TYPE_NEWS:
            {
                $this->_displayNews($id);
                break;
            }
                default:
                    throw new CHttpException(404,'Invalid Posting Type.');
        }

    }

    public function actionRegistered($type = null)
    {

        switch($type)
        {
            case Employer::USER_GROUP_ID:

                //****************************************************
   	        $FileName000="TMP_" . $_SERVER['REMOTE_ADDR'] . "_TMP";
   	        $EmpEmail000=file_get_contents($FileName000);
                unlink($FileName000);

                include 'SEND_ACTIVATION_EMAIL_EMP.php';
                //****************************************************

                $message = Yii::t('view', 'employer.registered.message');
                break;
            case Student::USER_GROUP_ID:
                $message = Yii::t('view', 'student.registered.message');
                break;
            default:
                throw new CHttpException(404,'Invalid User group found.');
                break;

        }

        $this->render('registered',array('message'=>$message));
    }

    private function _displayArticle($id)
    {
        $data = Article::getReadArticleData($id);

        $this->breadcrumbs = array('Articles'=>array('articles'), $data['title']);

        $this->render('article_news_view',array('data'=>$data,'type'=>Article::POST_TYPE));
    }

    private function _displayNews($id)
    {
        $data = Article::getReadArticleData($id);

        $this->breadcrumbs = array('News'=>array('news'), $data['title']);

        $this->render('article_news_view',array('data'=>$data,'type'=>Article::POST_TYPE_NEWS));
    }

}
