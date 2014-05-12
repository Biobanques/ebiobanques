<?php
/**
 * class of Common tools to use in all functions.
 * can agregate some common constants.
 * @author nicolas malservet
 * @since version 0.1
 */
class CommonTools
{
	
	/*
	 * FORMAT DATE
	*/
	const MYSQL_DATE_FORMAT = "Y-m-d H:i:s";
	const MYSQL_DATE_DAY_FORMAT = "Y-m-d 00:00:00";
	const FRENCH_DATE_FORMAT = "H:i:s d/m/Y";
	const FRENCH_SHORT_DATE_FORMAT = "d/m/Y";
	const FRENCH_HD_DATE_FORMAT = "d/m/Y H:i";
	const HOUR_DATE_FORMAT = "H:i";
	
/*
 * limite pour export xls
 */
	const XLS_EXPORT_NB=500;
public static function isInDevMode(){
	if($_SERVER['HTTP_HOST']=='localhost'){
		return true;
	}
	return false;
}
/**
 * transforme la date mysql en format français jj/mm/aaaa
 * @param unknown $madate
 */
public static function toShortDateFR($madate){
	$result="";
	if($madate!=""){
		$result=date(CommonTools::FRENCH_SHORT_DATE_FORMAT,strtotime($madate));
	}
	return $result;
}

/**
 * transforme la date mysql en format français jj/mm/aaaa
 * @param unknown $madate
 */
public static function toDateFR($madate){
	$result="";
	if($madate!=""){
		$result=date(CommonTools::FRENCH_HD_DATE_FORMAT,strtotime($madate));
	}
	return $result;
}
}
?>