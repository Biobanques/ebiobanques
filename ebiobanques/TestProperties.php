<?php

/*
 * CommonProperties to store variables used for connexion etc.
 * @author nicolas malservet
 * @since version 0.16
 */

class TestProperties
{
    /*
     * SELENIUM COVERAGE TESTS
     * Prepend and append File : used to allow code coverage for selenium tests. Put in .htaccess in index-test.html, remove in index.html
     *
     */
    public static $PREPEND_FILE = "/home/matthieu/NetBeansProjects/ebiobanques.fr/vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/SeleniumCommon/prepend.php";
    public static $APPEND_FILE = "/home/matthieu/NetBeansProjects/ebiobanques.fr/vendor/phpunit/phpunit-selenium/PHPUnit/Extensions/SeleniumCommon/append.php";
    public static $CODE_COVERAGE_SCRIPT = 'http://localhost/phpunit/phpunit_coverage.php';


    /*
     * connection string used in ./protected/config/main.php
     */
    public static $CONNECTION_STRING = 'mongodb://ebiobanques:insermEbb@localhost:32020/interop';
    /**
     * Mail system active: true if you want to send email.
     */
    public static $MAIL_SYSTEM_ACTIVE = false;
    /**
     * true if you want to send an email to signal biobank to apply their export.
     *
     */
    public static $MAIL_RELANCE_EXPORT = false;
    /*
     * Admin email to send mails in case of errors or news.
     */
    public static $ADMIN_EMAIL = 'contact@ebiobanques.fr';
    /*
     * SMTP Sender. Allow the script sendmailcommand to send mails via smtp with autentication
     */
    public static $SMTP_SENDER_HOST = 'ebiobanques.fr';
    public static $SMTP_SENDER_PORT = '587';
    public static $SMTP_SENDER_USERNAME = 'robot@ebiobanques.fr';
    public static $SMTP_SENDER_PASSWORD = 'ia4ever@2014';
    public static $SMTP_SENDER_FROM_EMAIL = 'robot@ebiobanques.fr';
}