<?php

/**
 * controller de la partie administration.<br>
 * Administration du site avec users, biobanks etc.
 *
 * @author nicolas
 *
 */
class AdministrationController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/menu_administration';

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'dashboard', 'contacts', 'userLog'),
                'expression' => '$user->isAdmin()',
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Declares class-based actions.
     */
    public function actions() {
        return array();
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex() {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $this->render('index');
    }

    /**
     * affichage du tableau de bord
     */
    public function actionDashboard() {
        $this->render('dashboard');
    }

    /**
     * affichage du tableau de contacts détaillé
     */
    public function actionContacts() {
        $this->render('contacts');
    }
    
    public function actionUserLog() {
        $model = new UserLog('search');
        $model->unsetAttributes();
        if (isset($_GET['UserLog'])) {
            $model->setAttributes($_GET['UserLog']);
        }
        $data = array();
        $dataAdminBbq = array();
        foreach (CommonTools::englishDates() as $month) {
            $time = strtotime(date('Y-m-d', strtotime('first day of ' . $month)));
            $criteria = new EMongoCriteria;
            $criteria->profil = "1";
            $criteria->connectionDate = array('$gte' => date("Y-m-d",(strtotime("first day of this month", $time))) . " 00:00:00.000000", '$lte' => date("Y-m-d",(strtotime("last day of this month", $time))) . " 23:59:59.000000");
            $nbConnectedStandardUsersByMonth = count(UserLog::model()->findAll($criteria));
            array_push($data, $nbConnectedStandardUsersByMonth);
            $criteriaAdminBbq = new EMongoCriteria;
            $criteriaAdminBbq->profil = "2";
            $criteriaAdminBbq->connectionDate = array('$gte' => date("Y-m-d",(strtotime("first day of this month", $time))) . " 00:00:00.000000", '$lte' => date("Y-m-d",(strtotime("last day of this month", $time))) . " 23:59:59.000000");
            $nbConnectedUsersAdminBbqByMonth = count(UserLog::model()->findAll($criteriaAdminBbq));
            array_push($dataAdminBbq, $nbConnectedUsersAdminBbqByMonth);
        }
        
        $this->render('userLog', array(
            'model' => $model,
            'data' => $data,
            'dataAdminBbq' => $dataAdminBbq,
            'nbConnectedUsersByMonth' => $nbConnectedStandardUsersByMonth,
            'nbConnectedUsersAdminBbqByMonth' => $nbConnectedUsersAdminBbqByMonth
        ));
    }

}