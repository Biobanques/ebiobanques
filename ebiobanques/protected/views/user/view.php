<?php
/* @var $this UserController */
/* @var $model User */
?>

<h1>Fiche utilisateur : <?php echo $model->nom . " " . $model->prenom; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        '_id',
        'prenom',
        'nom',
        'login',
        'password',
        'email',
        'telephone',
        'gsm',
        array('name' => 'profil', 'value' => $model->getProfil()),
        array('name' => 'statut', 'value' => $model->getInactif()),
    ),
));
?>
