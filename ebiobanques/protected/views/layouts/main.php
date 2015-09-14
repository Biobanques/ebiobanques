
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
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <script src="//ajax.googleapis.com/ajax/libs/dojo/1.9.3/dojo/dojo.js"></script>
        <?php
        Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerCoreScript('jquery.ui');
        ?>
    </head>

    <body class="container" id="page" >
        <div style="float:left;">
            <a href="http://rnce.inserm.fr/" target="_blank"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/logo_BIOCAP.jpg', 'logo', array('height' => 50)); ?></a>
        </div>
        <!--<div style="float:left;">-->
        <?php //echo CHtml::image(Yii::app()->request->baseUrl . '/images/ebiobanques.fr.png', 'nddlogo', array('height' => 60, 'width' => 400)); ?>

        <!--</div>-->
        <div style="float:right;padding-right:20px;padding-top:20px;">
            <div >
                <?php
                /**
                 * Affichage des liens de traduction en gardant le couple controlleur/action et les parametres d'origine.
                 */
                $controler = Yii::app()->getController()->getId();
                $action = Yii::app()->getController()->getAction()->getId();
//                echo CHtml::link(
//                        CHtml::image(Yii::app()->request->baseUrl . '/images/fr.png'), Yii::app()->createUrl("$controler/$action", array_merge($_GET, array('lang' => "fr"))
//                        )
////                        ,                      $htmlOptions
//                );
//                echo CHtml::link(
//                        CHtml::image(Yii::app()->request->baseUrl . '/images/gb.png'), Yii::app()->createUrl("$controler/$action", array_merge($_GET, array('lang' => "en")))
//                        , array('style' => "padding-left: 10px;")
//                );
                ?>
            </div>
            <div style="float:right;padding-top:10px;">
                <?php echo CHtml::link(Yii::t('common', 'contactus'), array('site/contactus')); ?>
            </div>
        </div>
        <div id="mainmenu" style="clear:both;">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'id' => 'navMainMenu',
                'encodeLabel' => false,
                'htmlOptions' => array('class' => 'mainMenu last'),
                'items' => array(
                    array('label' => Yii::t('common', 'accueil'), 'url' => array('/site/accueil')),
                    array('label' => Yii::t('common', 'searchsamples'), 'url' => array('/main/search'), 'visible' => !Yii::app()->user->isGuest,
                        'itemOptions' => array('class' => 'visited'),
                        'linkOptions' => array('class' => 'bar')),
                    //  array('label' => Yii::t('common', 'FAQ'), 'url' => array('/site/questions')),
                    // array('label' => Yii::t('common', 'activities'), 'url' => array('/site/dashboard')),
                    // array('label' => Yii::t('common', 'biobanks'), 'url' => array('/site/biobanks')),
                    // array('label' => Yii::t('common', 'contacts'), 'url' => array('/site/contacts')),
                    //  array('label' => Yii::t('common', 'myaccount'), 'url' => array('/myaccount/index'), 'visible' => !Yii::app()->user->isGuest),
                    //   array('label' => Yii::t('common', 'bbadmin'), 'url' => array('/mybiobank/index'), 'visible' => Yii::app()->user->isBiobankAdmin()),
                    array('label' => Yii::t('common', 'administration'), 'url' => array('/administration/index'), 'visible' => Yii::app()->user->isAdmin()),
                    array('label' => Yii::t('common', 'seconnecter'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                    array('label' => Yii::t('common', 'sedeconnecter') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
                ),
            ));
            ?>
        </div>

        <section class="main-body">
            <div class="container-fluid" style="height:70%; background-color: white">
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
    </body>
</html>