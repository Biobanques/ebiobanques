<?php

/**
 * Calcul des statistiques par biobanques pour le benchmarking.
 * Insertion des resultats dans la base de données
 *
 */
class DumpMongoCommand extends CConsoleCommand {

    public function run($args) {
        $path = CommonProperties::$DUMP_MONGO;
        $date = (string) date('Ymd');
        chdir($path);
        echo exec('mkdir ' . $date);
        chdir($path . $date);
        echo exec('mongodump --db interop --port 32020');
    }
}
?>