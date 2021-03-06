<?php

/**
 * classe WebUser pour ajouter le statut admin et/ou admin biobank a un user.
 * Permet de gerer simplement les roles du user
 * @author nicolas
 *
 */
class WebUser extends CWebUser
{
    private $_user;
    private $admin = false;
    private $biobankAdmin = false;

    /**
     * set the admin value
     * @param boolean $val
     */
    public function setAdmin($val) {
        $admin = $val;
    }

    /**
     * return true if user is admin
     * @return boolean
     */
    public function isAdmin() {
        return $this->getState('profil', '0') == 1;
    }

    /**
     * set the biobankAdmin value
     * @param boolean $val
     */
    public function SetBiobankAdmin($val) {
        $biobankAdmin = $val;
    }

    /**
     * return true if user is biobank admin
     * @return boolean
     */
    public function isBiobankAdmin() {
        return $this->getState('biobank_id') != null;
    }

    //get the logged user
    public function getUser() {
        return $this->_user;
    }

    public function getEmail() {
        return $this->getState('email');
    }
    
    /**
     * return user first name and last name
     * @return first name + last name
     */
    public function getNomPrenomById($userId)
    {
        $model = User::model()->findByPk(new MongoId($userId));
        return $model != null ? ucfirst($model->prenom) . " " . strtoupper($model->nom) : null;
    }

}
?>