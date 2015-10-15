<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta http-equiv="content-language" content="en"/>
        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <title>Vérification de la configuration nécessaire pour ebiobanques</title>
    </head>

    <body>
        <div id="page">

            <div id="header">
                <h1>Vérification de la configuration nécessaire pour ebiobanques</h1>
            </div><!-- header-->

            <div id="content">
                <h2>Description</h2>
                <p>
                    Ce script vérifie si la configuration de votre serveur satisfait toutes les dépendances nécessaires
                    pour exécuter l' application ebiobanques</a>.
                    Il vérifie si le serveur exécute la version correcte de PHP,
                    si toutes les extensions PHP nécessaires ont été chargées, si les paramètres du fichier php.ini sont corrects, et si les paramètres de l'application sont bien renseignés dans le fichier CommonProperties.php.
                </p>

                <h2>Conclusion</h2>
                <p>
                    <?php if ($result > 0): ?>
                        Félicitations ! Votre configuration vérifie toutes les exigences de ebiobanques.
                    <?php elseif ($result < 0): ?>
                        Votre configuration satisfait les exigences minimales de ebiobanques. Notez les avertissements listés ci-dessous si votre application utilise les fonctionnalités correspondantes.
                    <?php else: ?>
                        Malheureusement, votre configuration ne satisfait pas les exigences de ebiobanques.
                    <?php endif; ?>
                </p>

                <h2>Details</h2>

                <table class="result">
                    <tr><th>Nom</th><th>Resultat</th><th>Requis Par</th><th>Info</th></tr>
                    <?php foreach ($requirements as $requirement): ?>
                        <tr>
                            <td>
                                <?php echo $requirement[0]; ?>
                            </td>
                            <td class="<?php echo $requirement[2] ? 'passed' : ($requirement[1] ? 'failed' : 'warning'); ?>">
                                <?php echo $requirement[2] ? 'Ok' : ($requirement[1] ? 'Echec' : 'Attention'); ?>
                            </td>
                            <td>
                                <?php echo $requirement[3]; ?>
                            </td>
                            <td>
                                <?php echo $requirement[4]; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>

                <table>
                    <tr>
                        <td class="passed">&nbsp;</td><td>Ok</td>
                        <td class="failed">&nbsp;</td><td>Echec</td>
                        <td class="warning">&nbsp;</td><td>Avertissement</td>
                    </tr>
                </table>

            </div><!-- content -->

            <div id="footer">
                <?php echo $serverInfo; ?>
            </div><!-- footer -->

        </div><!-- page -->
    </body>
</html>