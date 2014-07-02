<?php
/**
 * classe qui ented l active record et ajoute le comprtement loggable utile pour catcher les actions effectuées sur la base
 * @author nicolas
 *
 */
abstract class LoggableActiveRecord extends EMongoDocument{


	/**
	 * ajout du comportement pour log audittrail
	 * @return multitype:string
	 */
	public function behaviors()
	{
		return array(
				'LoggableBehavior'=>
				'application.modules.auditTrail.behaviors.LoggableBehavior',
		);
	}
}

?>