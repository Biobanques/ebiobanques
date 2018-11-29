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
                'actions' => array('index', 'dashboard', 'contacts', 'userLog', 'exportAllBiobanks', 'exportAllUsers'),
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
    
    public function actionExportAllBiobanks() {
        $models = Biobank::model()->findAll();
        $dataProvider = array();
        $listAttributes = array();
        foreach ($models as $model) {
//récuperation de la liste totale des attributs
            foreach ($model->attributeExportedLabelsForSql() as $attributeName => $attributeValue) {
                $listAttributes[$attributeName] = $attributeName;
            }
        }
        foreach ($models as $model) {
            $datas = array();
            foreach ($listAttributes as $attribute) {
                if (isset($model->$attribute)) {
                    if (!is_object($model->$attribute)) {
                        $datas[$attribute] = $model->$attribute;
                    } else {
                        switch ($attribute) {
                            case "address":
                                $datas[$attribute] = $model->getAddress();
                                break;
                            case "contact_resp":
                                $datas['contact_resp_civility'] = $model->getResponsableRespCivility();
                                $datas['contact_resp_FirstName'] = $model->getResponsableRespFirstName();
                                $datas['contact_resp_LastName'] = $model->getResponsableRespLastName();
                                $datas['contact_resp_address'] = $model->getResponsableRespAddress();
                                $datas['contact_resp_direct_phone'] = $model->getResponsableRespPhone();
                            case "responsable_op":
                                $datas['responsable_op_civility'] = $model->getResponsableOpCivility();
                                $datas['responsable_op_FirstName'] = $model->getResponsableOpFirstName();
                                $datas['responsable_op_LastName'] = $model->getResponsableOpLastName();
                                $datas['responsable_op_address'] = $model->getResponsableOpAddress();
                                $datas['responsable_op_direct_phone'] = $model->getResponsableOpPhone();
                                break;
                            case "responsable_qual":
                                $datas['responsable_qual_civility'] = $model->getResponsableQualCivility();
                                $datas['responsable_qual_FirstName'] = $model->getResponsableQualFirstName();
                                $datas['responsable_qual_LastName'] = $model->getResponsableQualLastName();
                                $datas['responsable_qual_address'] = $model->getResponsableQualAddress();
                                $datas['responsable_qual_direct_phone'] = $model->getResponsableQualPhone();
                                break;
                            case "responsable_adj":
                                $datas['responsable_adj_civility'] = $model->getResponsableAdjCivility();
                                $datas['responsable_adj_FirstName'] = $model->getResponsableAdjFirstName();
                                $datas['responsable_adj_LastName'] = $model->getResponsableAdjLastName();
                                $datas['responsable_adj_address'] = $model->getResponsableAdjAddress();
                                $datas['responsable_adj_direct_phone'] = $model->getResponsableAdjPhone();
                                break;
                        }
                    }
                } else {
                    if ($attribute == "cim") {
                        $datas['cim'] = $model->getCims();
                    } else {
                        $datas[$attribute] = "";
                    }
                }
            }
            $dataProvider[] = $datas;
        }
        $filename = date('Ymd_H') . 'h' . date('i') . '_biobanks_list.csv';
        $csv = new ECSVExport($dataProvider);
        $toExclude = array();

        $csv->setExclude($toExclude);
        Yii::app()->getRequest()->sendFile($filename, $csv->toCSV(), "text/csv", false);
    }
    
    public function actionExportAllUsers() {
        $models = User::model()->findAll();
        $dataProvider = array();
        $listAttributes = array();
        foreach ($models as $model) {
//récuperation de la liste totale des attributs
            foreach ($model->attributeExportedLabelsForSql() as $attributeName => $attributeValue) {
                $listAttributes[$attributeName] = $attributeName;
            }
        }
        foreach ($models as $model) {
            $datas = array();
            foreach ($listAttributes as $attribute) {
                if (isset($model->$attribute)) {
                    if (!is_object($model->$attribute)) {
                        if ($attribute == "biobank_id" && $model->$attribute != null) {
                            $biobank = Biobank::model()->findByPk(new MongoID($model->$attribute));
                            if ($biobank != null) {
                                $datas['biobank_id'] = $biobank->id;
                            }
                        } else {
                            $datas[$attribute] = $model->$attribute;
                        }
                    }
                } else {
                    $datas[$attribute] = "";
                }
            }
            $dataProvider[] = $datas;
        }
        $filename = date('Ymd_H') . 'h' . date('i') . '_users_list.csv';
        $csv = new ECSVExport($dataProvider);
        $toExclude = array();

        $csv->setExclude($toExclude);
        Yii::app()->getRequest()->sendFile($filename, $csv->toCSV(), "text/csv", false);
    }

}