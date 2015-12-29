<?php

class ComplaintController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '/layouts/mainView';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('update', 'index', 'view', 'delete', 'admin', 'disableReply', 'replySafe', 'threadSafe',  'relational'),
                'users' => array('@'),
                'expression' => '$user->isAdmin()|| $user->isSuperAdmin() || $user->isCollegeAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Complaint;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Complaint'])) {
            $model->attributes = $_POST['Complaint'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Complaint'])) {
            $model->attributes = $_POST['Complaint'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Complaint');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        
        Yii::app()->user->setState('adminView', array('complaint/admin'));
        
        $model = new Complaint('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Complaint']))
            $model->attributes = $_GET['Complaint'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    
    public function actionThreadSafe($thread_id)
    {
        Complaint::model()->deleteAllByAttributes(array('post_item_id'=>$thread_id));
        
        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(array('admin'));
    }
    
    public function actionReplySafe($id)
    {
        Complaint::model()->deleteByPk($id);
        
        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(array('admin'));
    }
    
    public function actionDisableReply($reply_id, $complaint_id)
    {
        if ($reply_id)
        {
        $reply = Reply::model()->findByPk($reply_id);
        $reply->is_active = 0;
        $reply->save();
        
        Complaint::model()->deleteByPk($complaint_id);  
        }
        else
        {
        $thread = PostItem::model()->findByPk(Complaint::model()->findByPk($complaint_id)->post_item_id);
        $thread->is_active = $thread->is_active ? 0 : 1;
        $thread->save(false);
        }
        
        if (!Yii::app()->request->isAjaxRequest)
            $this->redirect(array('admin'));
    }

    public function actionRelational() {
        
        $report_id = Yii::app()->getRequest()->getParam('id');
        $thread_id = Complaint::model()->findByPk($report_id)->post_item_id;
        
        //Yii::log('Thread ID: ' . $thread_id, 'log');

        $model = new Complaint('search');
        $model->unsetAttributes();

        $gridColumns = array(array('name' => 'user.username', 'header' => 'Username'),
            array('name' => 'reply.message', 'value' => '$data->reply_id ? $data->reply->message : "<strong>(OP)</strong> " . $data->postItem->description ', 'header' => 'Message', 'type' => 'html'),
            array('name' => 'reason', 'header' => 'Complaint'),
            array(
            'htmlOptions' => array('nowrap' => 'nowrap'),
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view} | {safe} {disable}',
            'cssClassExpression' => '!$data->reply_id ? "op" : "reply"',    
            'viewButtonUrl' => 'Yii::app()->controller->createUrl("/post/readTopic", array("id"=>$data->post_item_id))',
            'buttons' => array
                (
                'safe' => array
                    (
                    'label' => 'Safe',
                    'icon' => 'thumbs-up',
                    'url' => 'Yii::app()->createUrl("complaint/replySafe", array("id"=>$data->complaint_id))',
                ),
                'disable' => array
                    (
                    'label' => 'Disable',
                    'icon' => 'eye-close',
                    'url' => 'Yii::app()->createUrl("complaint/disableReply", array("reply_id"=>$data->reply_id, "complaint_id" => $data->complaint_id))',
                    'click' => 'function() {confirm("ok?");}'
                )
            ),
        ));

        $this->renderPartial('_relational', array(
            'id' => $thread_id,
            'gridDataProvider' => $model->search(false, $thread_id),
            'gridColumns' => $gridColumns
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Complaint the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = Complaint::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Complaint $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'complaint-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
