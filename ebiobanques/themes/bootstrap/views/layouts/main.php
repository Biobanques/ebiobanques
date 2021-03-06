
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="biobank biobanques crb france centre ressource biologique">
        <meta name="author" content="biobanques.eu">
        <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic' rel='stylesheet' type='text/css'>



        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <!-- use the link below to test cdn instead of local lib -->
        <!--<link href="//netdna.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />-->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome-4.6.3/css/font-awesome.min.css" />

        <!-- use bootstrap -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-3.3.7-dist/css/bootstrap.min.css" />


        <!-- use the link below to test cdn instead of local lib. -->
        <!--<script src="//ajax.googleapis.com/ajax/libs/dojo/1.9.3/dojo/dojo.js"></script>-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/dojo/1.11.2/dojo.js"></script>
        <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>
    </head>

    <body>
        <!-- bootstrap main container -->
        <div class="container">
            <div >
                <?php
                $this->widget('application.widgets.navbar.NavBarBootstrap', array(
                    'id' => 'navMainMenu',
                    'brandUrl'=>'http://biobanques.eu',
                    'logoUrl'=> Yii::app()->request->baseUrl .'/images/logobb.png',
                    'items' => array(
                        array('label' => Yii::t('common', 'accueil'), 'url' => array('/site/accueil')),
                        array('label' => Yii::t('common', 'catalog'), 'url' => array('/catalog/search')),
                        array('label' => Yii::t('common', 'FAQ'), 'url' => array('/site/questions')),
                        array('label' => Yii::t('common', 'myaccount'), 'url' => array('/myaccount/index'), 'visible' => !Yii::app()->user->isGuest),
                        array('label' => Yii::t('common', 'bbadmin'), 'url' => array('/mybiobank/index'), 'visible' => Yii::app()->user->isBiobankAdmin()),
                        array('label' => Yii::t('common', 'administration'), 'url' => array('/administration/index'), 'visible' => Yii::app()->user->isAdmin()),
                        array('label' => Yii::t('common', 'seconnecter'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest, 'position' => 'right'),
                        array('label' => Yii::t('common', 'sedeconnecter') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest, 'position' => 'right'),
                    ),
                ));
                ?>
            </div>

            <div style="float:right;padding-right:20px;padding-top:20px;">
                <div >
                    <?php
                    /**
                     * Affichage des liens de traduction en gardant le couple controlleur/action et les parametres d'origine.
                     */
                    $controler = Yii::app()->getController()->getId();
                    $action = Yii::app()->getController()->getAction()->getId();
                    if ($controler == "admin") {
                        $controler = "auditTrail";
                    }
                    echo CHtml::link(
                            CHtml::image(Yii::app()->request->baseUrl . '/images/fr.png'), Yii::app()->createUrl("$controler/$action", array_merge($_GET, array('lang' => "fr"))
                            )
//                        ,                      $htmlOptions
                    );
                    echo CHtml::link(
                            CHtml::image(Yii::app()->request->baseUrl . '/images/gb.png'), Yii::app()->createUrl("$controler/$action", array_merge($_GET, array('lang' => "en")))
                            , array('style' => "padding-left: 10px;")
                    );
                    ?>
                </div>
                <div style="float:right;padding-top:10px;">
                    <?php echo CHtml::link(Yii::t('common', 'contactus'), array('site/contactus')); ?>
                </div>
            </div>


            <?php
            /*
             * change button destination function of the language choosen
             */
            $destButtonRequestForm = "http://www.biobanques.eu/fr/offre-de-services/demande-d-echantillon";
            if (Yii::app()->language == "en") {
                $destButtonRequestForm = "http://www.biobanques.eu/en/services/biospecimen-request";
            }
            ?>

            <div style="float:right;padding-right:20px;padding-top:20px;">
                <a class="btn btn-primary" href="<?= $destButtonRequestForm ?>" role="button" style="background-color:#C96CB6;border-color:white;"><?php echo Yii::t('common', 'button_ask_samples'); ?></a>
            </div>

            <section class="main-body">
                <div class="container-fluid" style="height:70%; background-color: white; padding: 0px">
                    <div id="flashMessages">
                        <?php
                        $flashMessages = Yii::app()->user->getFlashes();
                        if ($flashMessages) {
                            foreach ($flashMessages as $key => $message) {
                                echo '<br><div class="flash-' . $key . '">' . $message . "</div>";
                            }
                        }
                        ?>
                    </div>
                    <!-- Include content pages -->
                    <?php echo $content; ?>
                </div>
            </section>
            <!-- Require the footer -->
            <div style="width:100%;clear: both ">
                <?php require_once('tpl_footer.php') ?></div>
            <!-- end main container-->
        </div>
        <!-- Bootstrap core JavaScript
================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <!--script src="<?php //echo Yii::app()->request->baseUrl; ?>/js/jquery-1.12.4.min.js"></script-->
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery-ui.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

    </body>
</html>
