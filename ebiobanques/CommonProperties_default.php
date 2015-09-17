<?php

/*
 * CommonProperties to store variables used for connexion etc.
 * Save this file as CommonProperties.php to use it in the application.
 * @author nicolas malservet
 * @since version 0.16
 */

class CommonProperties
{
    /*
     * DEV MODE : true or false.
     * if true activate some refrences to the server to localhost and send mails to the from mail ( admin mail)
     */
    public static $DEV_MODE = true;
    /*
     * connection string used in ./protected/config/main_dev.php
     */
    public static $CONNECTION_STRING = 'mongodb://ebiobanques:ebiobanques@localhost/interop';
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
    public static $SMTP_SENDER_HOST = '';
    public static $SMTP_SENDER_PORT = '';
    public static $SMTP_SENDER_USERNAME = '';
    public static $SMTP_SENDER_PASSWORD = '';
    public static $SMTP_SENDER_FROM_EMAIL = '';
    /**
     * import folder. Need a / at the end
     * format attendu :  export_biocap_json_%AAAAMMDD_HH%h%mm%.json
     * exemple export_biocap_json_20150629_12h34.json
     * @var type
     */
    public static $IMPORTFOLDER = "/Users/nicolas/sync/biobanques/projets/biocap/data/";
    public static $IN_MAINTENANCE = false;
}