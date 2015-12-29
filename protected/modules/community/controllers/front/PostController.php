<?php

class PostController extends Controller {

    public $layout = '/layouts/postView';
    public $areaLarge = '';
    public $areaSmall = '';
    public $forumBreadcrumb = array();
    public $programId = null;
    public $semesterId = null;

    public function init() {
        parent::init();

        $this->areaLarge = Yii::t('forum', 'forum.title');
    }

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
            array('allow',
                'actions' => array('create', 'update', 'index', 'readTopic', 'review', 'downloadAttachment'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionReview($id) {
        $this->render('review', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionReadTopic($id) {


        $thread = Thread::model()->getThreadInfoById($id);

        $this->forumBreadcrumb = array(
            'Programs' => array('forum/index'),
            $thread['program_name'] => array('forum/programView', 'programId' => $thread['program_id']),
            $thread['semester_name'] => array('forum/viewTopics', 'programId' => $thread['program_id'], 'semesterId' => $thread['semester_id']),
            $thread['title'] < Yii::app()->params['forum_max_crumb_length'] ? $thread['title'] : substr($thread['title'], 0, Yii::app()->params['forum_max_crumb_length']) . '...'
        );

        $this->areaLarge = $thread['program_name'];
        $this->areaSmall = $thread['semester_name'];

        $reply = new Reply();
        $complaint = new Complaint('postComplaint');

        if (isset($_POST['Reply'])) {
            $reply->attributes = $_POST['Reply'];
            $reply->post_item_id = $id;
            if ($reply->save()) {
                Yii::app()->user->setFlash('success', Yii::t('forum', 'forum.view.reply.success'));
                $reply->unsetAttributes();
            } else {
                Yii::app()->user->setFlash('error', Yii::t('forum', 'forum.view.reply.error'));
            }
        }

        if (isset($_POST['Complaint'])) {
            $complaint->attributes = $_POST['Complaint'];
            if ($complaint->save()) {
                if ($complaint->post_item_id == $id)
                    Yii::app()->user->setFlash('success', Yii::t('forum', 'forum.view.complaint.success'));
                else
                    Yii::app()->user->setFlash('success', Yii::t('forum', 'forum.view.complaint.success'));
                $complaint->unsetAttributes();
            } else {
                Yii::app()->clientScript->registerScript('show_modal', "$('#reportModal').modal('show');", CClientScript::POS_READY);
            }
        }

        $dataProvider = Thread::model()->getPostsDataInThread($id);

        Yii::log(CVarDumper::dumpAsString($dataProvider->getData()));

        $this->render('view', array(
            'thread' => $thread,
            'threadId' => $id,
            'dataProvider' => $dataProvider,
            'reply' => $reply,
            'complaint' => $complaint
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'review' page.
     */
    public function actionCreate($programId = null, $semesterId = null) {
        $this->areaSmall = 'New Post';
        Yii::log($this->module->basePath);
        $college = College::getUserCollege();

        $this->forumBreadcrumb = array(
            'Programs' => array('forum/index')
        );

        if ($programId) {
            $program = Program::model()->findByPk($programId);
            $this->programId = $programId;
            $this->forumBreadcrumb = array_merge($this->forumBreadcrumb, array($program->program_name => array('forum/programView', 'programId' => $programId)));
        }
        if ($semesterId) {
            $semester = Semester::model()->findByPk($semesterId);
            $this->semesterId = $semesterId;
            $this->forumBreadcrumb = array_merge($this->forumBreadcrumb, array($semester->semester_name => array('forum/viewTopics', 'programId' => $programId, 'semesterId' => $semesterId)));
        }

        $this->forumBreadcrumb = array_merge($this->forumBreadcrumb, array('New Post'));

        $model = new ThreadForm($college->college_id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['PostItem'])) {
            $model->postItem->attributes = $_POST['PostItem'];
            $model->thread->attributes = $_POST['Thread'];

            $fileUpload = CUploadedFile::getInstance($model->thread, 'attachment');
            Yii::log(CVarDumper::dumpAsString($fileUpload));

            if ($fileUpload !== null)
                $model->thread->attachment = $fileUpload;

            if ($model->validate()) {
                if ($model->save()) {

                    if ($fileUpload !== null)
                        $model->thread->attachment->saveAs($this->module->basePath . '/files/' . $model->thread->attachment . "_" . $model->thread->getPrimaryKey());
                    //$model->thread->attachment->saveAs(Yii::app()->basePath . '/../files/' . $model->thread->attachment);

                    $this->redirect(array('review', 'id' => $model->postItem->post_item_id));
                    exit;
                } else {
                    Yii::app()->user->setFlash('error', 'Unable to post your thread.');
                }
            }
        }

        $this->render('create', array(
            'model' => $model, 'collegeId' => $college->college_id
        ));
    }

    public function actionDownloadAttachment($fileName, $threadId) {
        $filePath = $this->module->basePath . '/files/' . $fileName . "_" . $threadId;

        Yii::log("FilePath: " . $filePath . "\nFileName: " . $fileName);

        Yii::app()->request->sendFile($fileName, @file_get_contents($filePath), null, false);
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

        if (isset($_POST['PostItem'])) {
            $model->attributes = $_POST['PostItem'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->post_item_id));
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
        $dataProvider = new CActiveDataProvider('PostItem');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new PostItem('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['PostItem']))
            $model->attributes = $_GET['PostItem'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return PostItem the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = PostItem::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param PostItem $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'post-item-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
