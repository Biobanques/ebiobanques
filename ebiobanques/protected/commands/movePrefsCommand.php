<?php

/**
 * Calcul des statistiques par biobanques pour le benchmarking.
 * Insertion des resultats dans la base de données
 *
 */
class MovePrefsCommand extends CConsoleCommand
{

    public function run($args) {
        include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'CommonTools.php';
        $prefs = Preferences_tmp::model()->findAll();
        foreach ($prefs as $pref) {
            if (is_a($pref->id_user, get_class(new MongoId()))) {
                $user = User::model()->findByPk($pref->id_user);
                $user->preferences = new Preferences();
                foreach ($pref->attributes as $attName => $attValue) {
                    if (!in_array($attName, array('id', 'id_user', '_id')))
                        $user->preferences->$attName = $attValue;
                }
                $user->disableBehavior('LoggableBehavior');

                if ($user->update()) {
                    $pref->delete();
                    echo "Preferences moved for user $user->prenom $user->nom \n";
                }
            } else
                $pref->delete();
        }
    }

}
?>