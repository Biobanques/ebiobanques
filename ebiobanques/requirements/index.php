<?php

/**
 * Yii Requirement Checker script
 *
 * This script will check if your system meets the requirements for running
 * Yii-powered Web applications.
 *
 * @author Matthieu PENICAUD <matthieu.penicaud@inserm.fr>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @package system
 * @since 1.0
 */
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'protected/extensions/phpmailer/JPhpMailer.php');
require(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'CommonProperties.php');
/**
 * @var array List of requirements (name, required or not, result, used by, memo)
 */
$requirements = array(
    /*
     * php version
     */
    array(
        t('yii', 'PHP version'),
        true,
        version_compare(PHP_VERSION, "5.3.0", ">="),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        t('yii', 'PHP 5.1.0 or higher is required.')),
    /*
     * PDO extension
     */
    array(
        t('yii', 'PDO extension'),
        false,
        extension_loaded('pdo'),
        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
        ''),
    /*
     * Mongo extension
     */
    array(
        t('yii', 'Mongo'),
        false,
        extension_loaded('mongo'),
        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
        ''),
    /*
     * Reflexion extension
     */
    array(
        t('yii', 'Reflection extension'),
        true,
        class_exists('Reflection', false),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        ''),
    /*
     * PCRE extension
     */
    array(
        t('yii', 'PCRE extension'),
        true,
        extension_loaded("pcre"),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        ''),
    /*
     * SPL extension
     */
    array(
        t('yii', 'SPL extension'),
        true,
        extension_loaded("SPL"),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        ''),
    /*
     * database connection properties
     * from Commonproperties.php
     */
    array(
        t('yii', 'bddConnectionProperties'),
        true,
        checkDbConnectionProperties(),
        'Application',
        t('yii', 'dbConnectionProperties')),
    /*
     * Database version
     */
    array(
        t('yii', 'db version'),
        true,
        version_compare(checkDbVersion(), "db.version.v.2.4.0", ">="),
        '<a href="http://www.yiiframework.com">Application</a>',
        t('yii', 'Mongodb 2.4.0 or higher is required.found:'.checkDbVersion())),
    /*
     * Send a test mail to check if mail system properties are correct
     * from Commonproperties.php
     */
    array(
        t('yii', 'mail'),
        true,
        sendCheckMail(),
        'Application',
        t('yii', "checkMail {email}", array('email' => CommonProperties::$ADMIN_EMAIL))),
    array(
        t('yii', 'assets'),
        true,
        is_writable(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'assets'),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        t('yii', 'folder_assets required')),
    array(
        t('yii', 'runtime'),
        true,
        is_writable(dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'protected' . DIRECTORY_SEPARATOR . 'runtime'),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        t('yii', 'folder_runtime required')),
    array(
        t('yii', 'GD extension with<br />FreeType support<br />or ImageMagick<br />extension with<br />PNG support'),
        false,
        '' === $message = checkCaptchaSupport(),
        '<a href="http://www.yiiframework.com/doc/api/CCaptchaAction">CCaptchaAction</a>',
        $message),
    array(
        t('yii', '$_SERVER variable'),
        true,
        '' === $message = checkServerVar(),
        '<a href="http://www.yiiframework.com">Yii Framework</a>',
        $message),
//    array(
//        t('yii', 'DOM extension'),
//        false,
//        class_exists("DOMDocument", false),
//        '<a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>, <a href="http://www.yiiframework.com/doc/api/CWsdlGenerator">CWsdlGenerator</a>',
//        ''),
//    array(
//        t('yii', 'PDO SQLite extension'),
//        false,
//        extension_loaded('pdo_sqlite'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for SQLite database.')),
//    array(
//        t('yii', 'PDO MySQL extension'),
//        false,
//        extension_loaded('pdo_mysql'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for MySQL database.')),
//    array(
//        t('yii', 'PDO PostgreSQL extension'),
//        false,
//        extension_loaded('pdo_pgsql'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for PostgreSQL database.')),
//    array(
//        t('yii', 'PDO Oracle extension'),
//        false,
//        extension_loaded('pdo_oci'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for Oracle database.')),
//    array(
//        t('yii', 'PDO MSSQL extension (pdo_mssql)'),
//        false,
//        extension_loaded('pdo_mssql'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for MSSQL database from MS Windows')),
//    array(
//        t('yii', 'PDO MSSQL extension (pdo_dblib)'),
//        false,
//        extension_loaded('pdo_dblib'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for MSSQL database from GNU/Linux or other UNIX.')),
//    array(
//        t('yii', 'PDO MSSQL extension (<a href="http://sqlsrvphp.codeplex.com/">pdo_sqlsrv</a>)'),
//        false,
//        extension_loaded('pdo_sqlsrv'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required for MSSQL database with the driver provided by Microsoft.')),
//    array(
//        t('yii', 'PDO ODBC extension'),
//        false,
//        extension_loaded('pdo_odbc'),
//        t('yii', 'All <a href="http://www.yiiframework.com/doc/api/#system.db">DB-related classes</a>'),
//        t('yii', 'Required in case database interaction will be through ODBC layer.')),
//    array(
//        t('yii', 'Memcache extension'),
//        false,
//        extension_loaded("memcache") || extension_loaded("memcached"),
//        '<a href="http://www.yiiframework.com/doc/api/CMemCache">CMemCache</a>',
//        extension_loaded("memcached") ? t('yii', 'To use memcached set <a href="http://www.yiiframework.com/doc/api/CMemCache#useMemcached-detail">CMemCache::useMemcached</a> to <code>true</code>.') : ''),
//    array(
//        t('yii', 'APC extension'),
//        true,
//        extension_loaded("apc"),
//        '<a href="http://www.yiiframework.com/doc/api/CApcCache">CApcCache</a>',
//        ''),
//    array(
//        t('yii', 'Mcrypt extension'),
//        false,
//        extension_loaded("mcrypt"),
//        '<a href="http://www.yiiframework.com/doc/api/CSecurityManager">CSecurityManager</a>',
//        t('yii', 'Required by encrypt and decrypt methods.')),
//    array(
//        t('yii', 'crypt() CRYPT_BLOWFISH option'),
//        false,
//        function_exists('crypt') && defined('CRYPT_BLOWFISH') && CRYPT_BLOWFISH,
//        '<a href="http://www.yiiframework.com/doc/api/1.1/CPasswordHelper">CPasswordHelper</a>',
//        t('yii', 'Required for secure password storage.')),
//    array(
//        t('yii', 'SOAP extension'),
//        false,
//        extension_loaded("soap"),
//        '<a href="http://www.yiiframework.com/doc/api/CWebService">CWebService</a>, <a href="http://www.yiiframework.com/doc/api/CWebServiceAction">CWebServiceAction</a>',
//        ''),
    array(
        t('yii', 'Ctype extension'),
        false,
        extension_loaded("ctype"),
        '<a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateFormatter</a>, <a href="http://www.yiiframework.com/doc/api/CDateFormatter">CDateTimeParser</a>, <a href="http://www.yiiframework.com/doc/api/CTextHighlighter">CTextHighlighter</a>, <a href="http://www.yiiframework.com/doc/api/CHtmlPurifier">CHtmlPurifier</a>',
        ''
    ),
    array(
        t('yii', 'Fileinfo extension'),
        false,
        extension_loaded("fileinfo"),
        '<a href="http://www.yiiframework.com/doc/api/CFileValidator">CFileValidator</a>',
        t('yii', 'Required for MIME-type validation')
    ),
);



$result = 1;  // 1: all pass, 0: fail, -1: pass with warnings

foreach ($requirements as $i => $requirement) {
    if ($requirement[1] && !$requirement[2])
        $result = 0;
    else if ($result > 0 && !$requirement[1] && !$requirement[2])
        $result = -1;
    if ($requirement[4] === '')
        $requirements[$i][4] = '&nbsp;';
}

$lang = getPreferredLanguage();
$viewFile = dirname(__FILE__) . "/views/$lang/index.php";
if (!is_file($viewFile))
    $viewFile = dirname(__FILE__) . '/views/index.php';

renderFile($viewFile, array(
    'requirements' => $requirements,
    'result' => $result,
    'serverInfo' => getServerInfo()));

function sendCheckMail() {
    try {
        $mail = new JPhpMailer;
        $mail->IsSMTP();
        $mail->Host = CommonProperties::$SMTP_SENDER_HOST;
        $mail->SMTPAuth = true;
        $mail->Port = CommonProperties::$SMTP_SENDER_PORT;
        $mail->SetFrom(CommonProperties::$SMTP_SENDER_FROM_EMAIL);
        $mail->Username = CommonProperties::$SMTP_SENDER_USERNAME;
        $mail->Password = CommonProperties::$SMTP_SENDER_PASSWORD;
        $mail->AddAddress(CommonProperties::$ADMIN_EMAIL);
        $mail->Body = "Test Réussi - " . date("d/m/Y");
        $mail->Subject = "Mail de test pour la configuration SMTP";
        return $mail->Send();
    } catch (Exception $ex) {
        return false;
    }
}

function checkDbConnectionProperties() {
    try {
        $connect = new MongoClient(CommonProperties::$CONNECTION_STRING);
    } catch (Exception $e) {
        return false;
    }
    return $connect->connected;
}

function checkDbVersion() {
    try {
        $result = exec('mongo --version');
    } catch (Exception $e) {
        return false;
    }
    return $result;
}

function checkServerVar() {
    $vars = array('HTTP_HOST', 'SERVER_NAME', 'SERVER_PORT', 'SCRIPT_NAME', 'SCRIPT_FILENAME', 'PHP_SELF', 'HTTP_ACCEPT', 'HTTP_USER_AGENT');
    $missing = array();
    foreach ($vars as $var) {
        if (!isset($_SERVER[$var]))
            $missing[] = $var;
    }
    if (!empty($missing))
        return t('yii', '$_SERVER does not have {vars}.', array('{vars}' => implode(', ', $missing)));

    if (realpath($_SERVER["SCRIPT_FILENAME"]) !== realpath(__FILE__))
        return t('yii', '$_SERVER["SCRIPT_FILENAME"] must be the same as the entry script file path.');

    if (!isset($_SERVER["REQUEST_URI"]) && isset($_SERVER["QUERY_STRING"]))
        return t('yii', 'Either $_SERVER["REQUEST_URI"] or $_SERVER["QUERY_STRING"] must exist.');

    if (!isset($_SERVER["PATH_INFO"]) && strpos($_SERVER["PHP_SELF"], $_SERVER["SCRIPT_NAME"]) !== 0)
        return t('yii', 'Unable to determine URL path info. Please make sure $_SERVER["PATH_INFO"] (or $_SERVER["PHP_SELF"] and $_SERVER["SCRIPT_NAME"]) contains proper value.');

    return '';
}

function checkCaptchaSupport() {
    if (extension_loaded('imagick')) {
        $imagick = new Imagick();
        $imagickFormats = $imagick->queryFormats('PNG');
    }
    if (extension_loaded('gd'))
        $gdInfo = gd_info();
    if (isset($imagickFormats) && in_array('PNG', $imagickFormats))
        return '';
    elseif (isset($gdInfo)) {
        if ($gdInfo['FreeType Support'])
            return '';
        return t('yii', 'GD installed,<br />FreeType support not installed');
    }
    return t('yii', 'GD or ImageMagick not installed');
}

function getYiiVersion() {
    $coreFile = dirname(__FILE__) . '/../framework/YiiBase.php';
    if (is_file($coreFile)) {
        $contents = file_get_contents($coreFile);
        $matches = array();
        if (preg_match('/public static function getVersion.*?return \'(.*?)\'/ms', $contents, $matches) > 0)
            return $matches[1];
    }
    return '';
}

/**
 * Returns a localized message according to user preferred language.
 * @param string message category
 * @param string message to be translated
 * @param array parameters to be applied to the translated message
 * @return string translated message
 */
function t($category, $message, $params = array()) {
    static $messages;

    if ($messages === null) {
        $messages = array();
        if (($lang = getPreferredLanguage()) !== false) {
            $file = dirname(__FILE__) . "/messages/$lang/yii.php";
            if (is_file($file))
                $messages = include($file);
        }
    }

    if (empty($message))
        return $message;

    if (isset($messages[$message]) && $messages[$message] !== '')
        $message = $messages[$message];

    return $params !== array() ? strtr($message, $params) : $message;
}

function getPreferredLanguage() {
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && ($n = preg_match_all('/([\w\-]+)\s*(;\s*q\s*=\s*(\d*\.\d*))?/', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $matches)) > 0) {
        $languages = array();
        for ($i = 0; $i < $n; ++$i)
            $languages[$matches[1][$i]] = empty($matches[3][$i]) ? 1.0 : floatval($matches[3][$i]);
        arsort($languages);
        foreach ($languages as $language => $pref) {
            $lang = strtolower(str_replace('-', '_', $language));
            if (preg_match("/^en\_?/", $lang))
                return false;
            if (!is_file($viewFile = dirname(__FILE__) . "/views/$lang/index.php"))
                $lang = false;
            else
                break;
        }
        return $lang;
    }
    return false;
}

function getServerInfo() {
    $info[] = isset($_SERVER['SERVER_SOFTWARE']) ? $_SERVER['SERVER_SOFTWARE'] : '';
    $info[] = '<a href="http://www.yiiframework.com/">Yii Framework</a>/' . getYiiVersion();
    $info[] = @strftime('%Y-%m-%d %H:%M', time());

    return implode(' ', $info);
}

function renderFile($_file_, $_params_ = array()) {
    extract($_params_);
    require($_file_);
}
