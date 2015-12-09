
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="biobank biobanques crb france centre ressource biologique">
        <meta name="author" content="biosoftwarefactory.com">
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
    </head>
    <?php
    CommonTools::getBiobankInfo();
    $splitStringArray = split(".", $_SESSION['vitrine']['biobankLogo']->filename);
    $extention = end($splitStringArray);
    ?>
    <body class="container" id="page" >
        <div style="float:left;">
            <a href="http://www.biobanques.eu" target="_blank"><img src="<?php echo CommonTools::data_uri($_SESSION['vitrine']['biobankLogo']->getBytes(), "image/$extention"); ?>" alt="1 photo" style="height:120px;"/></a>
        </div>
        <div style="float:left;">
            
            <h1><?php echo $_SESSION['vitrine']['biobank']->identifier; ?></h1>
        </div>
        <div style="float:right;padding-right:20px;padding-top:20px;">
            <div >


                <?php
                /**
                 * Affichage des liens de traduction en gardant le couple controlleur/action et les parametres d'origine.
                 */
                $id = $_SESSION['vitrine']['biobank']->id;
                $controler = Yii::app()->getController()->getId();
                $action = Yii::app()->getController()->getAction()->getId();
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
                <?php echo CHtml::link(Yii::t('common', 'contactus'), array('site/contactus', 'id' => $id, 'layout' => 'vitrine_layout')); ?>
            </div>
        </div>
        <div id="mainmenu" style="clear:both;">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'id' => 'navMainMenu',
                'encodeLabel' => false,
                'htmlOptions' => array('class' => 'mainMenu last'),
                'items' => array(
                    array('label' => Yii::t('common', 'accueil'), 'url' => array('vitrine/view', 'id' => $id)),
                    array('label' => Yii::t('common', 'searchsamples'), 'url' => array('/site/search', 'id' => $id, 'layout' => 'vitrine_layout'),
                        'itemOptions' => array('class' => 'visited'),
                        'linkOptions' => array('class' => 'bar')),
                    array('label' => Yii::t('common', 'seconnecter'), 'url' => array('/site/login', 'id' => $id, 'layout' => 'vitrine_layout'), 'visible' => Yii::app()->user->isGuest),
                    array('label' => Yii::t('common', 'sedeconnecter') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout', 'id' => $id, 'layout' => 'vitrine_layout'), 'visible' => !Yii::app()->user->isGuest),
                ),
            ));
            ?>
        </div>

        <section class="main-body">
            <div class="container-fluid" style="height:70%; background-color: white">
                <?php
                $flashMessages = Yii::app()->user->getFlashes();
                if ($flashMessages) {
                    foreach ($flashMessages as $key => $message) {
                        echo '<br><div class="flash-' . $key . '">' . $message . "</div>";
                    }
                }
                ?>
                <!-- Include content pages -->
                <?php echo $content; ?>
            </div>
        </section>
        <!-- Require the footer -->
        <div style="width:100%;">
            <?php require_once('tpl_footer.php') ?></div>
    </body>
</html>
