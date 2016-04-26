
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

    <body class="container" id="page" style="background-image: none" >
        <div style="float:left;">
            <a href="http://www.biobanques.eu" target="_blank"><?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/logobb.png', 'logo', array('height' => 80, 'width' => 110)); ?></a>
        </div>
        <div style="float:left;">
            <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/ebiobanques.fr.png', 'nddlogo', array('height' => 60, 'width' => 400)); ?>

        </div>
        <div style="width:100%;clear: both "></div>

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