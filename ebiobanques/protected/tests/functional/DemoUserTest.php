<?php

class DemoUserTest extends SeleniumWebTestCase
{

    public function test_DemoUserTest() {
        $this->open("/demo-ebiobanques/index-test.php");
        $this->click("link=Accueil");
        $this->waitForPageToLoad("30000");
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demo");
        $this->type("id=LoginForm_password", "demo");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Mon compte");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Myaccount", $this->getTitle());
        $this->type("id=User_prenom", "demo");
        $this->type("id=User_nom", "demo");
        $this->type("id=User_login", "demoUser");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Mise à jour de l'utilisateur : demo demo", $this->getText("css=h1"));
        $this->assertEquals("ebiobanques.fr - Myaccount", $this->getTitle());
        $this->type("id=User_prenom", "demoUser");
        $this->type("id=User_nom", "demoUser");
        $this->type("id=User_login", "demo");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Déconnexion (demo)", $this->getText("link=Déconnexion (demo)"));
        $this->click("link=Déconnexion (demo)");
        $this->waitForPageToLoad("30000");
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demo");
        $this->type("id=LoginForm_password", "demo");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Le champ de recherche permet d'effectuer des recherches complexes parmi les échantillons.\n Les critères saisis doivent être séparés par un espace. \n Les critères sont inteprétés pour effectuer une recherche approfondie des données parmi les données disponibles.\n Les valeurs de comparaison doivent être ajoutées à droite du comparateur.\n Exemples d'utilisation : male 35years H >=28ans H >35ans <60ans TO Les champs analysés lors de cette recherche sont le sexe, l'age, et les notes.\n Les notes sont des champs libres pouvant contenir tout type d'information non normalisée.\n Si votre recherche contient de nombreux critères, nous vous conseillons d' utiliser le formulaire de recherche avancée.", $this->getText("//div[@id='content']/div[3]/div/div[2]"));
        $this->assertEquals("ebiobanques.fr - Search Site", $this->getTitle());
        $this->assertEquals("ebiobanques.fr - Chose Demande", $this->getTitle());
        $this->click("css=img[alt=\"53ba687501754474158b4570\"]");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Update Demande", $this->getTitle());
        $this->type("id=Demande_titre", "nouvelle demande");
        $this->type("id=Demande_detail", "test nouvelle demande");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->click("id=selectionCB_1");
        $this->click("id=selectionCB_2");
        $this->click("css=tr.even.selected > td.checkbox-column");
        $this->click("id=selectionCB_3");
        $this->click("css=img[alt=\"53ba687501754474158b4570\"]");
        $this->waitForPageToLoad("30000");
        $this->click("css=img[alt=\"53a14cdc44aeb806f5ef7a81\"]");
        $this->waitForPopUp("_blank", "30000");
        $this->assertEquals("Afficher les résultats de 1 à 3 (total de 3)", $this->getText("css=div.summary"));
        $this->click("link=Accueil");
        $this->waitForPageToLoad("30000");
        $this->click("link=Contacts");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Contacts Site", $this->getTitle());
        $this->click("link=Recherche avancée");
        $this->assertEquals("ebiobanques.fr - Contacts Site", $this->getTitle());
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - UpdateAndSend Demande", $this->getTitle());
        $this->type("id=Demande_titre", "test");
        $this->type("id=Demande_detail", "test de demande");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Total de 3 résultats.", $this->getText("css=div.summary"));
        $this->assertEquals("ebiobanques.fr - View Demande", $this->getTitle());
        $this->click("id=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Envoyer Demande", $this->getTitle());
        $this->assertEquals("Votre demande a bien été envoyée aux différents sites", $this->getText("css=div.flash-success"));
        $this->click("link=Déconnexion (demo)");
        $this->waitForPageToLoad("30000");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
    }

}
?>