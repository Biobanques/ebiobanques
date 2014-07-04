<?php

class SysAdminTest extends SeleniumWebTestCase
{

    protected function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/ebiobanques/index-test.php");
    }

    public function testMyTestCase() {
        $this->open("http://localhost/ebiobanques/index-test.php");
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demoAdmin");
        $this->type("id=LoginForm_password", "demoAdmin");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Accueil");
        $this->waitForPageToLoad("30000");
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Search Site", $this->getTitle());
        $this->assertEquals("Rechercher des échantillons", $this->getText("css=h1"));
        $this->click("link=Contacts");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Contacts Site", $this->getTitle());
        $this->assertEquals("Contacts", $this->getText("css=h1"));
        $this->assertEquals("Administration", $this->getText("link=Administration"));
        $this->click("link=Administration");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Administration", $this->getTitle());
        $this->assertEquals("Page d administration", $this->getText("id=content"));
        $this->click("link=Déconnexion (demoAdmin)");
        $this->waitForPageToLoad("30000");
    }

}
?>