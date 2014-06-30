<?php
/* 
 * CommonProperties to store variables used for connexion etc.
 * Save this file as CommonProperties.php to use it in the application.
 * @author nicolas malservet
 * @since version 0.16
 */
class CommonProperties{
/*
 * connection string used in ./protected/config/main_dev.php 
 */
var $CONNECTION_STRING='mongodb://ebiobanques:ebiobanques@localhost/interop';
/**
 * Mail system active: true if you want to send email.
 */
public static $MAIL_SYSTEM_ACTIVE=false;

/**
 * true if you want to send an email to signal biobank to apply their export. 
 * 
 */
public static $MAIL_RELANCE_EXPORT=false;
/*
 * Admin email to send mails in case of errors or news.
 */
var $ADMIN_EMAIL='contact@ebiobanques.fr';
/*
 * SMTP Sender. Allow the script sendmailcommand to send mails via smtp with autentication
 */
var $SMTP_SENDER_HOST='';
var $SMTP_SENDER_PORT='';
var $SMTP_SENDER_USERNAME='';
var $SMTP_SENDER_PASSWORD='';
var $SMTP_SENDER_FROM_EMAIL='';
}
