<?php

if (isset($_SESSION['vitrine']) && isset($_SESSION['vitrine']['biobank'])) {
    echo $_SESSION['vitrine']['biobank']->vitrine['page_accueil_fr'];
} else {
    echo "No web site is built.";
}

