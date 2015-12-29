<?php

/* @var $thread Thread */
/* @var $program Program */

class ForumController extends Controller {

    public $layout = '/layouts/forumView';
    public $areaLarge = 'College';
    public $areaSmall = 'Community';
    public $canPost = true;
    public $search;
    public $programId = null;
    public $semesterId = null;
    public $forumBreadcrumb = array();
    public $emptyText = "There are currently no topics";

    public function init() {
        parent::init();

        $this->search = new SearchForm();

        if (isset($_POST['SearchForm'])) {
            Yii::log("Search Form logged");
            $this->search->attributes = $_POST['SearchForm'];
            Yii::log($this->search->searchString);
            Yii::log($this->search->programId);
            Yii::log($this->search->semesterId);
            //$this->search = $search;
            if ($this->search->validate())
                $this->redirect(array('searchTopics', 'string' => $this->search->searchString, 'progId' => $this->search->programId, 'semesterId' => $this->search->semesterId));
        }
    }

    public function accessRules() {
        return array(
            array('allow',
                'actions' => array('index', 'programView', 'viewTopics', 'myTopics', 'todaysTopics', 'latestReplies', 'searchTopics', 'deleteThread'),
                'users' => array('@'),
            ),
            array('allow',
                'actions' => array(),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    public function actionIndex() {

        $college = College::getUserCollege();
        Yii::log(CVarDumper::dumpAsString($college));

        $programs = Thread::getThreadsByProgram($college->college_id);
        Yii::log(CVarDumper::dumpAsString($programs));

        $programRows = array();

        foreach ($programs as $i => $program) {
            $row = array(
                'id' => $program['program_id'],
                'forum' => $program['program_name'],
                'latestTopic' => $program['last_thread_title'],
                'numPosts' => $program['thread_count'] ? $program['thread_count'] : 0,
                'numReplies' => $program['reply_count'] ? $program['reply_count'] : 0,
                'last_thread_id' => $program['last_thread_id']
            );

            $programRows[] = $row;
        }

        $gridColumns = array(
            array('name' => 'forum', 'header' => 'Forum', 'type' => 'raw', 'value' => 'CHtml::link($data["forum"], array("programView", "programId" => $data["id"]));'),
            array('name' => 'latestTopic', 'header' => 'Latest Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["latestTopic"], array("post/readTopic", "id" => $data["last_thread_id"]));'),
            array('name' => 'numPosts', 'header' => 'Posts'),
            array('name' => 'numReplies', 'header' => 'Replies'));

        $forumGridData = new CArrayDataProvider($programRows, array('sort' => array(
                'attributes' => array(
                    'forum', 'numPosts', 'numReplies'
                ),
        )));
        $forumGridData->setPagination(false);

        $this->areaLarge = $college->college_name;
        $this->render('index', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData));
    }

    public function actionProgramView($programId) {

        $college = College::getUserCollege();

        $semesters = Thread::getThreadsBySemester($college->college_id, $programId);

        Yii::log(CVarDumper::dumpAsString($semesters));

        $semesterRows = array();

        foreach ($semesters as $i => $semester) {
            $row = array(
                'id' => $i,
                'forum' => CHtml::link($semester['semester_name'], array('viewTopics', 'programId' => $programId, 'semesterId' => $semester['semester_id'])),
                'latestTopic' => $semester['last_thread_title'],
                'numPosts' => $semester['thread_count'] ? $semester['thread_count'] : 0,
                'numReplies' => $semester['reply_count'] ? $semester['reply_count'] : 0,
                'last_thread_id' =>  $semester['last_thread_id']
            );

            $semesterRows[] = $row;
        }

        $gridColumns = array(
            array('name' => 'forum', 'header' => 'Forum', 'type' => 'raw'),
            array('name' => 'latestTopic', 'header' => 'Latest Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["latestTopic"], array("post/readTopic", "id" => $data["last_thread_id"]));'),
            array('name' => 'numPosts', 'header' => 'Posts'),
            array('name' => 'numReplies', 'header' => 'Replies'));

        $forumGridData = new CArrayDataProvider($semesterRows, array('sort' => array(
                'attributes' => array(
                    'numPosts', 'numReplies'
                ),
        )));

        $programName = Program::model()->findByPk($programId)->program_name;

        $this->forumBreadcrumb = array(
            'Programs' => array('index'),
            $programName
        );

        $this->programId = $programId;

        $this->areaLarge = $programName;
        $this->areaSmall = $college->college_name;
        $this->search->programId = $programId;
        $this->render('topics', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData));
    }

    public function actionViewTopics($programId, $semesterId) {
        $college = College::getUserCollege();

        $threads = Thread::model()->getThreads($college->college_id, $programId, $semesterId);

        $topicRows = array();

        $maxLengh = Yii::app()->params['forum_max_latest_reply_length'];

        foreach ($threads as $i => $thread) {
            $row = array(
                'id' => $thread['thread_id'],
                'topic' => $thread['title'],
                'progCode' => $thread['program_code'],
                'postDate' => $thread['date_created'],
                'latestReply' => strip_tags($thread['latest_reply']) <= $maxLengh ? substr(strip_tags($thread['latest_reply']), 0, $maxLengh) : substr(strip_tags($thread['latest_reply']), 0, $maxLengh) . '...',
                'numReplies' => $thread['reply_count'] ? $thread['reply_count'] : 0
            );

            $topicRows[] = $row;
        }

        $gridColumns = array(
            array('name' => 'topic', 'header' => 'Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["topic"], array("post/readTopic", "id" => $data["id"]));'),
            array('name' => 'progCode', 'header' => 'Program Code'),
            array('name' => 'postDate', 'header' => 'Post Date', 'filter' => false, 'value' => 'Yii::app()->timeagoFormat->timeago(new DateTime($data["postDate"]))'),
            array('name' => 'latestReply', 'header' => 'Latest Reply', 'filter' => false),
            array('name' => 'numReplies', 'header' => 'Replies', 'filter' => false));

        $filtersForm = new FiltersForm();
        if (isset($_GET['FiltersForm']))
            $filtersForm->filters = $_GET['FiltersForm'];

        $filteredData = $filtersForm->filter($topicRows);

        $forumGridData = new CommunityArrayDataProvider(array_values($filteredData), array('sort' => array(
                'attributes' => array(
                    'topic', 'progCode', 'postDate', 'numReplies'
                ),
            ), 'pagination' => array(
                'pageSize' => Yii::app()->params['forum_pageSize'],
        )));

        $semesterName = Semester::model()->findByPk($semesterId)->semester_name;
        $programName = Program::model()->findByPk($programId)->program_name;

        $this->forumBreadcrumb = array(
            'Programs' => array('index'),
            $programName => array('programView', 'programId' => $programId),
            $semesterName
        );

        $this->areaLarge = $semesterName;
        $this->areaSmall = $programName;

        $this->programId = $programId;
        $this->semesterId = $semesterId;

        $this->search->programId = $programId;
        $this->search->semesterId = $semesterId;

        $this->render('topics', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData, 'filtersForm' => $filtersForm));
    }

    public function actionMyTopics() {
        $college = College::getUserCollege();

        $this->areaLarge = $college->college_name;
        $this->areaSmall = Yii::t('forum', 'forum.area.mytopics');

        $this->canPost = false;

        $threads = Thread::model()->getUserThreads(Yii::app()->user->getId());

        $topicRows = array();

        foreach ($threads as $i => $thread) {
            $row = array(
                'id' => $thread['thread_id'],
                'topic' => $thread['title'],
                'program_name' => $thread['program_name'],
                'program' => $thread['program_id'],
                'semester' => CHtml::link($thread['semester_name'], array('viewTopics', 'programId' => $thread['program_id'], 'semesterId' => $thread['semester_id'])),
                'progCode' => $thread['program_code'],
                'postDate' => $thread['date_created'],
                'delete' => CHtml::checkBox('cb_' . $thread['thread_id'])
            );

            $topicRows[] = $row;
        }


        $gridColumns = array(
            array('name' => 'topic', 'header' => 'Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["topic"], array("post/readTopic", "id" => $data["id"]));'),
            array('name' => 'program_name', 'header' => 'Program', 'type' => 'raw', 'value' => 'CHtml::link($data["program_name"], array("programView", "programId" => $data["program"]));'),
            array('name' => 'semester', 'header' => 'Semester', 'type' => 'raw'),
            array('name' => 'postDate', 'header' => 'Post Date', 'filter' => false, 'value' => 'Yii::app()->timeagoFormat->timeago(new DateTime($data["postDate"]))'),
            array(
                'htmlOptions' => array('nowrap' => 'nowrap', 'class' => 'col_trash'),
                'class' => 'bootstrap.widgets.TbButtonColumn',
                'template' => '{delete}',
                'deleteButtonUrl' => 'Yii::app()->controller->createUrl("deleteThread",array("id"=>$data["id"]))',
            )
        );
//
//        $filtersForm = new FiltersForm();
//        if (isset($_GET['FiltersForm']))
//            $filtersForm->filters = $_GET['FiltersForm'];
//
//        $filteredData = $filtersForm->filter($topicRows);

        $forumGridData = new CommunityArrayDataProvider(array_values($topicRows), array('sort' => array(
                'attributes' => array(
                    'topic', 'program', 'postDate'
                ),
            ),
            'pagination' => array(
                'pageSize' => Yii::app()->params['forum_pageSize'],
        )));

        $this->render('topics', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData));
    }

    public function actionTodaysTopics() {
        $college = College::getUserCollege();

        $this->areaLarge = $college->college_name;
        $this->areaSmall = Yii::t('forum', 'forum.area.todaystopics');

        $this->canPost = false;

        $threads = Thread::model()->getTodaysThreads($college->college_id);

        $topicRows = array();

        foreach ($threads as $i => $thread) {
            $row = array(
                'id' => $thread['thread_id'],
                'topic' => $thread['title'],
                'program_name' => $thread['program_name'],
                'program' => $thread['program_id'],
                'semester' => CHtml::link($thread['semester_name'], array('viewTopics', 'programId' => $thread['program_id'], 'semesterId' => $thread['semester_id'])),
                'progCode' => $thread['program_code'],
                'postDate' => $thread['date_created'],
                'numReplies' => $thread['reply_count'],
            );

            $topicRows[] = $row;
        }

        $gridColumns = array(
            array('name' => 'topic', 'header' => 'Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["topic"], array("post/readTopic", "id" => $data["id"]));'),
            array('name' => 'program_name', 'header' => 'Program', 'type' => 'raw', 'value' => 'CHtml::link($data["program_name"], array("programView", "programId" => $data["program"]));'),
            array('name' => 'semester', 'header' => 'Semester', 'type' => 'raw'),
            array('name' => 'postDate', 'header' => 'Post Date', 'filter' => false, 'value' => 'Yii::app()->timeagoFormat->timeago(new DateTime($data["postDate"]))'),
            array('name' => 'numReplies', 'header' => 'Replies', 'filter' => false),
        );

        $filtersForm = new FiltersForm();
        if (isset($_GET['FiltersForm']))
            $filtersForm->filters = $_GET['FiltersForm'];

        $filteredData = $filtersForm->filter($topicRows);

        $forumGridData = new CArrayDataProvider(array_values($filteredData), array('sort' => array(
                'attributes' => array(
                    'topic', 'program', 'postDate', 'numReplies'
                ),
        )));
        $forumGridData->setPagination(false);

        $this->render('topics', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData, 'filtersForm' => $filtersForm));
    }

    public function actionLatestReplies($days = 1) {
        $college = College::getUserCollege();

        $this->areaLarge = Yii::t('forum', 'forum.area.latestReplies');
        $this->areaSmall = 'Past 24 Hours';

        $this->canPost = false;

        $threads = Thread::model()->getLatestReplies(Yii::app()->user->getId(), $days);

        $topicRows = array();

        $maxLengh = Yii::app()->params['forum_max_latest_reply_length'];

        foreach ($threads as $i => $thread) {
            if (!$thread['reply_date'])
                continue;

            $row = array(
                'id' => $thread['thread_id'],
                'topic' => $thread['title'],
                'message' => strip_tags($thread['latest_reply']) <= $maxLengh ? substr(strip_tags($thread['latest_reply']), 0, $maxLengh) : substr(strip_tags($thread['latest_reply']), 0, $maxLengh) . '...',
                'replyDate' => $thread['reply_date'],
                'numReplies' => $thread['reply_count'],
            );

            $topicRows[] = $row;
        }

        $gridColumns = array(
            array('name' => 'topic', 'header' => 'Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["topic"], array("post/readTopic", "id" => $data["id"]));'),
            array('name' => 'message', 'header' => 'Message'),
            array('name' => 'replyDate', 'header' => 'Time', 'value' => 'Yii::app()->timeagoFormat->timeago(new DateTime($data["replyDate"]))'),
            array('name' => 'numReplies', 'header' => 'Replies'),
        );

        $forumGridData = new CommunityArrayDataProvider($topicRows, array('sort' => array(
                'attributes' => array(
                    'topic', 'topic', 'replyDate', 'numReplies'
                ),
            ), 'pagination' => array(
                'pageSize' => Yii::app()->params['forum_pageSize'],
        )));
        $forumGridData->setPagination(false);

        $this->render('topics', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData));
    }

    public function actionSearchTopics($string, $progId = null, $semesterId = null) {
        $college = College::getUserCollege();

        $this->areaLarge = $college->college_name;
        $this->areaSmall = Yii::t('forum', 'forum.area.search');

        if (!empty($progId)) {
            $this->areaSmall .= " (In " . Program::model()->findByPk($progId)->program_name;
            if (!empty($semesterId))
                $this->areaSmall .= " / " . Semester::model()->findByPk($semesterId)->semester_name;
            $this->areaSmall .= " )";
        }


        $this->canPost = false;

        Yii::log($string);

        $threads = Thread::model()->searchTopics($string, $college->college_id, $progId, $semesterId);

        Yii::log(CVarDumper::dumpAsString($threads));

        $topicRows = array();

        foreach ($threads as $i => $thread) {
            $row = array(
                'id' => $thread['thread_id'],
                'topic' => $thread['title'],
                'program_name' => $thread['program_name'],
                'program' => $thread['program_id'],
                'semester' => CHtml::link($thread['semester_name'], array('viewTopics', 'programId' => $thread['program_id'], 'semesterId' => $thread['semester_id'])),
                'progCode' => $thread['program_code'],
                'postDate' => $thread['date_created'],
                'numReplies' => $thread['reply_count'],
            );

            $topicRows[] = $row;
        }

        $gridColumns = array(
            array('name' => 'topic', 'header' => 'Topic', 'type' => 'raw', 'value' => 'CHtml::link($data["topic"], array("post/readTopic", "id" => $data["id"]));'),
            array('name' => 'program_name', 'header' => 'Program', 'type' => 'raw', 'value' => 'CHtml::link($data["program_name"], array("programView", "programId" => $data["program"]));'),
            array('name' => 'semester', 'header' => 'Semester', 'type' => 'raw'),
            array('name' => 'postDate', 'header' => 'Post Date', 'filter' => false, 'value' => 'Yii::app()->timeagoFormat->timeago(new DateTime($data["postDate"]))' ),
            array('name' => 'numReplies', 'header' => 'Replies', 'filter' => false),
        );

        $filtersForm = new FiltersForm();
        if (isset($_GET['FiltersForm']))
            $filtersForm->filters = $_GET['FiltersForm'];

        $filteredData = $filtersForm->filter($topicRows);

        $forumGridData = new CommunityArrayDataProvider(array_values($filteredData), array('sort' => array(
                'attributes' => array(
                    'topic', 'program', 'postDate', 'numReplies'
                ),
            ), 'pagination' => array(
                'pageSize' => Yii::app()->params['forum_pageSize'])));
        $forumGridData->setPagination(false);

        $this->emptyText = "No topics could be found";

        $this->render('topics', array('gridColumns' => $gridColumns, 'forumGridData' => $forumGridData, 'filtersForm' => $filtersForm));
    }

    public function actionDeleteThread($id) {
        //$thread = new Thread;

        $thread = Thread::model()->findByPk($id);

        if ($thread->delete())
            Yii::app()->user->setFlash('success', "Thread $thread->primaryKey deleted");
        else {
            Yii::app()->user->setFlash('error', "Problem removing thread");
        }

        $this->redirect(array('myTopics'));
    }

}
