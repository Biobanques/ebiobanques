<?php

/**
 * classe pour envoyer des mails via yii avec template de mise en forme.
 * @author nmalservet
 *
 */
class CommonMailer
{
    const PROD_URL = "\"http://www.ebiobanques.fr/";
    const DEV_URL = "\"http://localhost/ebiobanques/";
    /**
     * from by default
     */
    const MAIL_FROM = "contact@ebiobanques.fr";

    /**
     * "send" an email. To do it, store an email into db and a crontask will pull emails to send them.
     * the crontask will be executed using the command line yiic sendmail.
     * @param unknown $to
     * @param unknown $subject
     * @param unknown $body
     */
    public static function sendMail($to, $subject, $body) {
        try {
            $mailq = new mailqueue ();
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
            $headers .= 'From: ' . CommonMailer::MAIL_FROM . "\r\n" . 'Reply-To: ' . CommonMailer::MAIL_FROM . "\r\n" . 'X-Mailer: PHP/' . phpversion();
            if (!CommonTools::isInDevMode()) {
                $mailq->emailto = $to;
            } else {
//                $mailq->emailto = CommonMailer::MAIL_FROM;
                $mailq->emailto = CommonProperties::$ADMIN_EMAIL;
                $subject = "Mail in dev_mod for $to : $subject";
            }
            $mailq->subject = $subject;
            $mailq->body = $body;
            $mailq->headers = $headers;
            return $mailq->save();
        } catch (Exception $e) {
            Yii::log("exception sur save mail", "error");
        }
    }

    /**
     * envoi de mail inscription avec infos de connexion.
     */
    function sendMailInscriptionUser($to, $identifiant, $prenom, $nom, $pass) {
        $subject = "Bienvenue!";
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\"><html><head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Message de ebiobanques.fr</title>
				</head><body>
				<table style=\"font-family:Verdana,sans-serif; font-size:11px; color:#374953; width: 550px;\">
				<tr>
				<td align=\"left\">
				<a href=\"http://ebiobanques.fr/\" title=\"ebiobanques.fr\"><img alt=\"ebiobanques.fr\" height=\"70px\" width=\"458px\" src=\"http://www.ebiobanques.fr/wp-content/uploads/2012/08/logo211.jpg\" style=\"border:none;\" ></a>
				</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td align=\"left\">Bonjour <strong style=\"color:#DB3484;\">" . $prenom . " " . $nom . "</strong>,</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
						<td align=\"left\" style=\"background-color:#DB3484; color:#FFF; font-size: 12px; font-weight:bold; padding: 0.5em 1em;\">

						Merci d'avoir cr&eacute;&eacute; un compte sur ebiobanques.fr. Voici un rappel de vos codes d'acc&egrave;s</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
						<td align=\"left\">
						Adresse e-mail : <strong><span style=\"color:#DB3484;\">" . $identifiant . "</span></strong>
								<br >Mot de passe : <strong>" . $pass . "</strong>
										</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
										<td align=\"left\">
										Vous pouvez d&egrave;s &agrave; pr&eacute;sent utiliser notre site internet <a href=\"http://ebiobanques.fr/\">ebiobanques.fr</a> pour g&eacute;rer vos r&eacute;servations de studios.
										</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
										<tr>
										<td align=\"center\" style=\"font-size:10px; border-top: 1px solid #D9DADE;\">
										<a href=\"http://ebiobanques.fr/\" style=\"color:#DB3484; font-weight:bold; text-decoration:none;\">
										ebiobanques.fr </a> - copyright BioSoftware Factory
										<a href=\"http://www.gap-consulting.fr/\" style=\"text-decoration:none; color:#374953;\">www.biobanques.eu</a>
										</td>
										</tr>
										</table>
										</body>
										</html>";

        CommonMailer::sendMail($to, $subject, $body);
    }

    /**
     * envoi de mail inscription avec infos de connexion.
     * TODO a complerter avec partiie inscription user.
     */
    public static function sendMailConfirmationEmail($to, $identifiant, $prenom, $nom, $idUser) {
        $base = CommonMailer::DEV_URL;
        if (!CommonTools::isInDevMode()) {
            $base = CommonMailer::PROD_URL;
        }
        $urlConfirm = "http://" . $base . "/index.php?r=site/confirmmail&arg1=" . $idUser . "&arg2=" . $identifiant;

        $subject = "Confirmation de votre adresse email";
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
				<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<html><head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Confirmation email de ebiobanques.fr</title>
				</head><body>
				<table style=\"font-family:Verdana,sans-serif; font-size:11px; color:#374953; width: 550px;\">
				<tr>
				<td align=\"left\">
				<a href=\"http://ebiobanques.fr/\" title=\"ebiobanques.fr\"><img alt=\"ebiobanques.fr\" height=\"70px\" width=\"458px\" src=\"http://www.ebiobanques.fr/logo211.jpg\" style=\"border:none;\" ></a>
				</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
				<td align=\"left\">Bonjour <strong style=\"color:#DB3484;\">" . $prenom . " " . $nom . "</strong>,</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
						<td align=\"left\" style=\"background-color:#DB3484; color:#FFF; font-size: 12px; font-weight:bold; padding: 0.5em 1em;\">

						Pour pouvoir profiter pleinement des services de ebiobanques.fr, il nous faut confirmer votre adresse email.<br>
						Pouvez-vous cliquer sur le lien ci-dessous ou copier l'adresse dans votre navigateur afin de finaliser la proc&eacute;dure de confirmation:
						</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
						<td align=\"left\">
						<a href=\"" . $urlConfirm . "\">" . $urlConfirm . "</a>

								</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
								<td align=\"left\">
								Rendez-vous sur notre site internet <a href=\"http://ebiobanques.fr/\">ebiobanques.fr</a> pour g&eacute;rer vos r&eacute;servations d'échantillons biologiques.
								</td>
								</tr>
								<tr><td>&nbsp;</td></tr>
								<tr>
								<td align=\"center\" style=\"font-size:10px; border-top: 1px solid #D9DADE;\">
								<a href=\"http://ebiobanques.fr/\" style=\"color:#DB3484; font-weight:bold; text-decoration:none;\">
								ebiobanques.fr </a> - copyright BioSoftware Factory
								<a href=\"http://www.gap-consulting.fr/\" style=\"text-decoration:none; color:#374953;\">www.biobanques.eu</a>
								</td>
								</tr>
								</table>
								</body>
								</html>";

        CommonMailer::sendMail($to, $subject, $body);
    }

    /**
     * envoi mail demande d'echantillons
     */
    function sendDemande($contact, $title, $detail, $sampleList) {
        $to = Yii::app()->params ['adminEmail'];
        if ($contact == null && $contact->email != null) {
            $to = $contact->email;
        }
        $user = User::model()->findByPk(Yii::app()->user->id);
        if ($user != null) {
            $listEchantillons = '';
            $subject = Yii::t('common', 'mailDemandeSubject') . ' : ' . $title;
            if ($sampleList != null) {
                foreach ($sampleList as $concernSample) {
                    $listEchantillons .= '<li>' . $concernSample->id_sample . '</li>';
                }

                $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
				<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<html><head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Confirmation email de ebiobanques.fr</title>
				</head><body>
				Cet email est une demande d'échantillons de $user->prenom $user->nom, par le biais du site <a href = \"http://www.ebiobanques.fr\">" .
                        "ebiobanques.fr</a>.<br>Titre de la demande : $title <br>Détail de la demande : $detail<br>Cette demande concerne les échantillons suivants :" .
                        " <br><ul>$listEchantillons </ul><br>Merci de vous mettre en relation avec " .
                        "<a href=\"mailto:$user->email?subject=Re : Demande d'échantillons \"> $user->prenom $user->nom </a> pour avoir plus de détail sur cette demande.
				<br><br>L'équipe <a href = \"http://www.ebiobanques.fr\">ebiobanques.fr</a>.</body>";
                return CommonMailer::sendMail($to, $subject, $body);
            } else {
                return CommonMailer::sendMail(Yii::app()->params ['adminEmail'], $subject . ">anomalie : liste null", $body);
            }
        }
    }

    /**
     * send an email to indicate to the admin that there is a new user to confirm
     * @param type $user
     * @return type
     */
    public static function sendSubscribeAdminMail($user) {
        $base = CommonTools::isInDevMode() ? CommonMailer::DEV_URL : CommonMailer::PROD_URL;
        $to = Yii::app()->params['adminEmail'];
        $subject = "Inscription d'un nouvel utilisateur sur ebiobanques.fr";
        $userDetails = '';
        foreach ($user->getAttributes() as $label => $value) {
            $userDetails.="<li>$label : $value</li>";
        }
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
				<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<html><head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Inscription d'un nouvel utilisateur sur ebiobanques.fr</title>
				</head><body>
				$user->prenom $user->nom s'est inscrit sur le site ebiobanques.fr.<br>
						Détails :<br>
	<ul>$userDetails</ul><br>
	Vous pouvez valider cet utilisateur en cliquant sur ce lien : <a href=$base/index.php/user/validate/id/$user->_id\">Valider l'utilisateur</a>, le <a href=$base/index.php/user/refuseRegistration/id/$user->_id\">désactiver</a>
	 ou le retrouver dans <a href=$base/index.php/user/admin\">la liste des utilisateurs</a>.
	</body>
		";
        return CommonMailer::sendMail($to, $subject, $body);
    }

    /**
     * send an email to confirm that the subscritption is valid and the account waiting for validatin by admin
     * @param type $user
     * @return type
     */
    public static function sendSubscribeUserMail($user) {
        $to = $user->email;
        $subject = "Welcome on ebiobanques.fr " . $user->prenom . " " . $user->nom;
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
				<?xml version=\"1.0\" encoding=\"utf-8\"?>
				<html><head>
				<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
                                <title>Welcome " . $user->prenom . " " . $user->nom . " on ebiobanques.fr</title>
				</head><body>
                                Welcome " . $user->prenom . " " . $user->nom . " on ebiobanques.fr.
			Your account is waiting for a validation by the administrator of ebiobanques.<br>
                        If you have any problem during your experience with ebiobanques.fr feel free to send an email to " . Yii::app()->params['adminEmail'] . "<br>
                            Best
	</body>
		";
        return CommonMailer::sendMail($to, $subject, $body);
    }

    /**
     * send an email to confirm that the account is valid.
     * @param type $user
     * @return type
     */
    public static function sendUserRegisterConfirmationMail($user) {
        $to = $user->email;
        $subject = "Confirmation de votre inscription sur ebiobanques.fr";
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
		<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<html><head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Confirmation de votre inscription sur ebiobanques.fr</title>
		</head><body>
		Cher (Chère) $user->prenom $user->nom,<br><br>
		Merci de vous être inscrit sur le site <a href=\"http://www.ebiobanques.fr/index.php\">ebiobanques.fr</a>.<br>
		Vous pouvez vous connecter dès à présent sur le site avec vos identifiants : <br>
		<ul><li>Nom d'utilisateur : $user->login </li>
		<li>Mot de passe : $user->password </li></ul>
		</body>
		";
        return CommonMailer::sendMail($to, $subject, $body);
    }

    public static function sendUserRegisterRefusedMail($user) {
        $to = $user->email;
        $subject = "Refus de votre inscription sur ebiobanques.fr";
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
		<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<html><head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Confirmation de votre inscription sur ebiobanques.fr</title>
		</head><body>
		Cher (Chère) $user->prenom $user->nom,<br><br>
		Merci de vous être intéressé à la plate-forme <a href=\"http://www.ebiobanques.fr/index.php\">ebiobanques.fr</a>.<br>
		Malheureusement, nous ne pouvons donner suite à votre inscription.<br>
                Pour toute question, merci de contacter l'administrateur de la plate-forme.<br><br>
                Cordialement<br>
                L'équipe ebiobanques

		</body>
		";
        return CommonMailer::sendMail($to, $subject, $body);
    }

    public static function sendMailRelanceExport($contact, $lastImportDate, $nbJours) {
        if (Yii::app()->params['mailRelanceExport'] == true) {
            $to = $contact->email;
            $fname = $contact->first_name;
            $lname = $contact->last_name;
        } else {
            $to = 'contact@ebiobanques.fr';
            $fname = 'Administrateur';
            $lname = 'ebiobanques.fr';
        }
        $dateFormat = date('d/m/y', strtotime($lastImportDate));
        $subject = "Exportez vos données";
        $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
		<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<html><head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Vos exports sur ebiobanques.fr</title>
		</head><body>
		Cher (Chère) $fname $lname,<br><br>
		Nous n'avons reçu aucun export d'échantillon de votre biobanque depuis le $dateFormat, soit déjà $nbJours jours.<br>
		N'oubliez pas de mettre régulièrement vos échantillons à jour sur notre plateforme.
		</body>
		";
        return CommonMailer::sendMail($to, $subject, $body);
    }

    /**
     * send a email to recover the password
     * @param type $user
     * @return true if it s sent ( stored in db then pull by the cron task)
     */
    public static function sendMailRecoverPassword($user) {
        try {
            if ($user != null)
                $to = $user->email;
            $fname = $user->prenom;
            $lname = $user->nom;
            $login = $user->login;
            $password = $user->password;
            $subject = "Informations perdues sur ebiobanques.fr";
            $body = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/1999/REC-html401-19991224/strict.dtd\">
		<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<html><head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">	<title>Vos exports sur ebiobanques.fr</title>
		</head><body>
		Cher (Chère) $fname $lname,<br><br>
		Suite à votre demande effectuée sur le site ebiobanques.fr, nous vous rappelons vos codes d'accès :<br>
                Identifiant : $login<br>
                Password : $password <br>
                Vous pouvez dès à présent vous connecter avec ces identifiants.
A bientôt sur ebiobanques.fr
		</body>
		";
            return CommonMailer::sendMail($to, $subject, $body);
        } catch (Exception $e) {
            Yii::log("exception sur save mail", "error");
            return false;
        }
    }

}
?>
