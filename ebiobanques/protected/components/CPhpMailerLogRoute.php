<?php
/**
 * class to route trace and logs with emails and use specific smtp server
 */
class CPhpMailerLogRoute extends CEmailLogRoute
{
    protected function sendEmail($email, $subject, $message)
    {
        Yii::import('application.extensions.phpmailer.JPhpMailer');
        $mail = new JPhpMailer;
        $mail->IsSMTP();
        $mail->Host = CommonProperties::$SMTP_SENDER_HOST;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "none";//"tls";
        $mail->Port = CommonProperties::$SMTP_SENDER_PORT;
        $mail->Username = CommonProperties::$SMTP_SENDER_USERNAME;
        $mail->Password = CommonProperties::$SMTP_SENDER_PASSWORD;
        $src=CommonProperties::$DEV_MODE?'dev':'prod';
        $mail->SetFrom(CommonProperties::$SMTP_SENDER_FROM_EMAIL, "robot ebiobanques".$src);
        $mail->Subject = "ebiobanques : ".$subject;
        $mail->Body = $message;
        $mail->addAddress($email);
        $mail->send();
    }
}
