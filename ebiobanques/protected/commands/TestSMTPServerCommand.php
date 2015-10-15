<?php

/**
 * Calcul des statistiques par biobanques pour le benchmarking.
 * Insertion des resultats dans la base de données
 *
 */
class TestSMTPServerCommand extends CConsoleCommand
{

    public function run($args) {
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->IsSMTP();
        $mail->SMTPDebug = 1;
        $mail->Host = CommonProperties::$SMTP_SENDER_HOST;
        $mail->SMTPAuth = true;
        $mail->Port = "587";
        $mail->SetFrom(CommonProperties::$SMTP_SENDER_FROM_EMAIL);
        $mail->Username = CommonProperties::$SMTP_SENDER_USERNAME;
        $mail->Password = CommonProperties::$SMTP_SENDER_PASSWORD;
        $mail->AddAddress("matthieu.penicaud@inserm.fr");
        $mail->Body = "Test Réussi";
        $mail->Subject = "Mail de test pour la configuration SMTP";
        return $mail->Send();
    }

}
?>