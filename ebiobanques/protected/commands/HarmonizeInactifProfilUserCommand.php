<?php

/**
  Extract date from a mongoId
 *
 */
class HarmonizeInactifProfilUserCommand extends CConsoleCommand
{

    /**
     *
     * @codeCoverageIgnore
     * @param type $args
     */
    public function run($args) {
        $users = User::model()->findAll();

        foreach ($users as $user) {
            if ($user->inactif == 0 && $user->inactif !== '0') {
                $user->inactif = '0';
            }
            if ($user->inactif == 1 && $user->inactif !== '1') {
                $user->inactif = '1';
            }
            if ($user->profil == 0 && $user->profil !== '0') {
                $user->profil = '0';
            }
            if ($user->profil == 1 && $user->profil !== '1') {
                $user->profil = '1';
            }
            if ($user->profil == 2 && $user->profil !== '2') {
                $user->profil = '2';
            }
            $user->save(false);
        }
    }

}
?>