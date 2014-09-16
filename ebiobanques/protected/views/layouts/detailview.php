
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

    <body class="container" id="page" >
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