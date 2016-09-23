<?php

/*
 * CommonProperties to store variables used for connexion etc.
 * @author nicolas malservet
 * @since version 0.16
 */

class CommonProperties
{
    /*
     * DEV MODE : true or false.
     * if true activate some refrences to the server to localhost and send mails to the from mail ( admin mail)w
     */
    public static $DEV_MODE = true;
    public static $DEV_MAIL = 'contact@ebiobanques.fr';
    /*
     * connection string used in ./protected/config/main_dev.php
     */
    //ebiocbanques
    public static $CONNECTION_STRING = 'mongodb://circleUser:circlePwd@localhost:27017/interop';
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
    public static $MANAGER_EMAIL = 'contact@ebiobanques.fr';
    /*
     * SMTP Sender. Allow the script sendmailcommand to send mails via smtp with autentication
     */
    public static $SMTP_SENDER_HOST = '';
    public static $SMTP_SENDER_PORT = '';
    public static $SMTP_SENDER_USERNAME = '';
    public static $SMTP_SENDER_PASSWORD = '';
    public static $SMTP_SENDER_FROM_EMAIL = '';
    //   public static $IMPORTFOLDER = "/home/matthieu/Documents/inserm/dumps/biocap/";
    public static $IN_MAINTENANCE = false;
    public static $GMAPS_KEY = "";
    public static $TESTBROWSER = '';
    public static $LAUNCHSELENIUM = false;
    public static $SERVERTESTURL = 'http://ebiobanques.local';
}