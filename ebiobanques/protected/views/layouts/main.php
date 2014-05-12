
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
        <!-- javascripts ( en fin de page pour meilleurs perfs) -->
        <!--  utilisation d un CDN gogle pour accelerer temps de chargement JS -->
        <!--<script src='js/dojo-release-1.9.1/dojo/dojo.js'></script>
        <script type="text/javascript">
            var dojoConfig = {
                parseOnLoad: true,
                afterOnLoad: true,
            };
        </script>-->
        <!--<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/dojo/1.9.1/dojo/dojo.js"></script>-->
       <script src="//ajax.googleapis.com/ajax/libs/dojo/1.9.3/dojo/dojo.js"></script>
    </head>

    <body class="container" id="page">
        <div style="float:left;">
            <a href="http://www.biobanques.eu" target="_blank"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/logobb.png', 'logo', array('height' => 80, 'width' => 110)); ?></a>
        </div>
        <div style="float:left;">
            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/ebiobanques.fr.png', 'nddlogo', array('height' => 60, 'width' => 400)); ?>
            <div style="color:#D788F1;margin-left:380px;font-weight:bold;font-size:15px;"><i>Beta</i></div>
        </div>
        <div style="float:right;padding-right:20px;padding-top:20px;">
            <div ><a href="./index.php?lang=fr"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/fr.png'); ?></a>
                <a style="padding-left: 10px;" href="./index.php?lang=en"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/gb.png'); ?></a>
            </div>
            <div style="float:right;padding-top:10px;"">
                <?php echo CHtml::link(Yii::t('common', 'contactus'), array('site/contactus')); ?>
            </div>
        </div>

    </div>
    <div id="mainmenu" style="clear:both;">
        <?php
        $this->widget('zii.widgets.CMenu', array(
            'items' => array(
                array('label' => "Accueil", 'url' => array('/site/accueil')),
                array('label' => Yii::t('common', 'searchsamples'), 'url' => array('/site/search')),
                array('label' => "Questions fréquentes", 'url' => array('/site/questions')),
                array('label' => "Activités", 'url' => array('/site/dashboard')),
                array('label' => Yii::t('common', 'biobanks'), 'url' => array('/site/biobanks')),
                array('label' => Yii::t('common', 'contacts'), 'url' => array('/site/contacts')),
                array('label' => Yii::t('common', 'myaccount'), 'url' => array('/myaccount/index'), 'visible' => !Yii::app()->user->isGuest),
                array('label' => Yii::t('common', 'bbadmin'), 'url' => array('/mybiobank/index'), 'visible' => Yii::app()->user->isBiobankAdmin()),
                array('label' => Yii::t('common', 'administration'), 'url' => array('/administration/index'), 'visible' => Yii::app()->user->isAdmin()),
                array('label' => Yii::t('common', 'seconnecter'), 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => Yii::t('common', 'sedeconnecter') . ' (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
            ),
        ));
        ?>
    </div>

    <section class="main-body">
        <div class="container-fluid">
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
    <div style="float: left;width: 100%">
        <?php require_once('tpl_footer.php') ?></div>
</body>
</html>