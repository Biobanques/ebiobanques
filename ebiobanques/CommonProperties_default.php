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
var $CONNECTION_STRING_DEV='mongodb://ebiobanques:ebiobanques@localhost/interop';
/*
 * conection string used in ./protected/config/main.php for prod file
 */
var $CONNECTION_STRING_PROD='mongodb://ebiobanques:ebiobanques@localhost/interop';
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
