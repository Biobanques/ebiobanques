<?php

class AnonymeTest extends SeleniumWebTestCase
{

    public function test_AnonymeTest() {
        $this->open("/ebiobanques/index-test.php?r=site/accueil");
        $this->click("link=Accueil");
        $this->waitForPageToLoad("30000");
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
        $this->click("link=Questions fréquentes");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Questions Site", $this->getTitle());
        $this->click("link=Activités");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Reception de fichiers", $this->getText("css=div.portlet-title"));
        $this->assertEquals("Localisation des échantillons", $this->getText("css=#yw1 > div.portlet-decoration > div.portlet-title"));
        $this->click("link=Biobanques");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Biobanks Site", $this->getTitle());
        $this->click("link=Contacts");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
    }

    public function testMyTestCase() {
        $this->open("http://localhost/ebiobanques/index-test.php");
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demoAdminBb");
        $this->type("id=LoginForm_password", "demoAdminBb");
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
        $this->click("link=Ma biobanque");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Mybiobank", $this->getTitle());
        $this->assertEquals("Ma biobanque", $this->getText("css=div.portlet-title"));
        $this->click("link=Déconnexion (demoAdminBb)");
        $this->waitForPageToLoad("30000");
    }

}
?>