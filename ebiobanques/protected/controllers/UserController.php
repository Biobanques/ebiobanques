<?php

class UserController extends Controller
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/menu_administration';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','subscribe','captcha'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','view','delete','validate','desactivate'),
				'expression' => '$user->isAdmin()'
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actions(){
		$captcha =array(
				'class'=>'CaptchaExtendedAction',
				'mode'=>CaptchaExtendedAction::MODE_WORDS,
		);
		//ajout de fixed value si mode de dev
if(CommonTools::isInDevMode()){
			$captchaplus =array('fixedVerifyCode'=>"nicolas");
			$captcha=array_merge($captcha,$captchaplus);
}

		return array(
				// captcha action renders the CAPTCHA image displayed on the inscription page
				'captcha'=>$captcha,
				// page action renders "static" pages stored under 'protected/views/site/pages'
				// They can be accessed via: index.php?r=site/page&view=FileName
				'page'=>array(
						'class'=>'CViewAction',
				),
		);
		
	}
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->update())
				$this->redirect(array('view','id'=>$model->_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('User');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return User the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk(new MongoID($id));
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	
	public function actionValidate($id) {
		$model = $this->loadModel ( $id );
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
		
		$model->inactif = 0;
		if ($model->save ()) {
			CommonMailer::sendUserRegisterConfirmationMail($model);
			Yii::app ()->user->setFlash ( 'success', 'L\'utilisateur n°' . $model->_id . ' (' . $model->prenom . ' ' . $model->nom . ') a bien été validé.' );
		} else {
			Yii::app ()->user->setFlash ( 'error', 'L\'utilisateur n°' . $model->_id . ' (' . $model->prenom . ' ' . $model->nom . ') n\'a pas pu être validé. Consultez les logs pour plus de détails.' );
		}
		$this->redirect ( array (
				'admin',
// 				'id' => $id
		) );
	}
	
	public function actionDesactivate($id) {
		$model = $this->loadModel ( $id );
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
	
		$model->inactif = 1;
		if ($model->update ()) {
			
			Yii::app ()->user->setFlash ( 'success', 'L\'utilisateur n°' . $model->_id . ' (' . $model->prenom . ' ' . $model->nom . ') a bien été désactivé.' );
		} else {
			Yii::app ()->user->setFlash ( 'error', 'L\'utilisateur n°' . $model->_id . ' (' . $model->prenom . ' ' . $model->nom . ') n\'a pas pu être désactivé. Consultez les logs pour plus de détails.' );
		}
		$this->redirect ( array (
				'admin',

		) );
	}
	
	public function actionSubscribe() {
		$model = new User ();
	
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
	
		if (isset ( $_POST ['User'] )) {
			$model->attributes = $_POST ['User'];
			$model->profil = 0;
			$model->inactif = 1;
			
			if ($model->save ()){
				CommonMailer::sendSubscribeAdminMail($model);
					Yii::app ()->user->setFlash ( 'success', Yii::t('common','success_register') );			
				$this->redirect ( array (
						'site/index'
				) );}else{
					Yii::app ()->user->setFlash ( 'error', Yii::t('common','error_register') );
				}
		}
	
		$this->render ( 'subscribe', array (
				'model' => $model
		) );
	}
	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
