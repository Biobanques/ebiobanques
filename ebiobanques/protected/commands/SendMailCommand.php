<?php
/**
 * classe pour envoyer les mails en queue.
 * La commande a executer et a mettre dans les cron task est :
 * ${PATH_TO_PROJECT}/protected/yiic sendmail
 * exemple POUR AUTOMATISER CET ENVOI :
 * >crontab -e
 * >* * * * * /data/developpement/workspace_zend_eclipse_php/ebiobanques.fr/ebiobanques/protected/yiic sendmail
 * //ancienne methoide longue avec php car block le thread cournat si serveur smtp ne repond pas : mail($model->emailto, $model->subject, $model->body,$model->headers);
 * @author nicolas
 *
 */
        class SendMailCommand extends CConsoleCommand
        {
          public function run($args)
          {
          	Yii::import('application.extensions.phpmailer.JPhpMailer');

          	if(Yii::app()->params['mailSystemActif']==true){
	 	        $models=mailqueue::model()->findAll();
				foreach($models as $model){
					$mail = new JPhpMailer;
					$mail->IsSMTP();
					$mail->Host = $GLOBALS["SMTP_SENDER_HOST"];
					$mail->SMTPAuth = true;
					$mail->Port = $GLOBALS["SMTP_SENDER_PORT"];
					$mail->Username = $GLOBALS["SMTP_SENDER_USERNAME"];
					$mail->Password = $GLOBALS["SMTP_SENDER_PASSWORD"];
					$mail->SetFrom($GLOBALS["SMTP_SENDER_FROM_EMAIL"], 'ebiobanques news');
					$mail->Subject = $model->subject;
					$mail->AltBody = $model->body;
					$mail->MsgHTML($model->body);
					$mail->AddAddress($model->emailto,$model->emailto);
					$mail->CharSet = 'UTF-8';
					if($mail->Send())
					$model->delete();
					else echo 'pb sending mail';
				}
				echo "mails sent\n";
          	}
          }
        }
?>