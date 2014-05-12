<?php
/* 
 * CommonProperties to store variables used for connexion etc.
 * Save this file as CommonProperties.php to use it in the application.
 * @author nicolas malservet
 * @since version 0.16
 */

/*
 * connection string used in ./protected/config/main_dev.php 
 */
$CONNECTION_STRING_DEV='mongodb://ebiobanques:ebiobanques@localhost/interop';
/*
 * conection string used in ./protected/config/main.php for prod file
 */
$CONNECTION_STRING_PROD='mongodb://ebiobanques:ebiobanques@localhost/interop';
/*
 * Admin email to send mails in case of errors or news.
 */
$ADMIN_EMAIL='contact@ebiobanques.fr';
/*
 * SMTP Sender. Allow the script sendmailcommand to send mails via smtp with autentication
 */
$SMTP_SENDER_HOST='';
$SMTP_SENDER_PORT='';
$SMTP_SENDER_USERNAME='';
$SMTP_SENDER_PASSWORD='';
$SMTP_SENDER_FROM_EMAIL='';
