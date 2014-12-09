<?php

class SimpleUserTest extends SeleniumWebTestCase
{

//    protected function setUp() {
//        $this->setBrowser("*firefox");
//        $this->setBrowserUrl("http://localhost/ebiobanques/index-test.php");
//    }

    public function testMyTestCase() {
        $this->open("http://localhost/ebiobanques/index-test.php");

        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demo");
        $this->type("id=LoginForm_password", "demoTest");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Accueil");
        $this->waitForPageToLoad("30000");
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Search Site", $this->getTitle());
//        $this->assertEquals("Rechercher des échantillons", $this->getText("css=h1"));
//        $this->click("link=Mon compte");
//        $this->waitForPageToLoad("30000");
//        $this->assertEquals("Mise à jour de l'utilisateur : demoUser demoUser", $this->getText("css=h1"));
//        $this->click("link=Contacts");
//        $this->waitForPageToLoad("30000");
//        $this->assertEquals("ebiobanques.fr - Contacts Site", $this->getTitle());
//        $this->assertEquals("Contacts", $this->getText("css=h1"));
//        $this->assertEquals("Déconnexion (demo)", $this->getText("link=Déconnexion (demo)"));
//        $this->click("link=Déconnexion (demo)");
//        $this->waitForPageToLoad("30000");
//        $this->assertEquals("Connexion", $this->getText("link=Connexion"));
    }

}
?>