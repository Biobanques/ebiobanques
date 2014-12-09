<?php

class DemoBbUserTest extends SeleniumWebTestCase
{

    public function test_DemoBbUserTest() {
        $this->open("/demo-ebiobanques/index-test.php");
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demo");
        $this->type("id=LoginForm_username", "demoAdminBb");
        $this->type("id=LoginForm_password", "demoAdminBb");
        $this->click("name=yt0");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Ma biobanque", $this->getText("link=Ma biobanque"));
        $this->click("link=Ma biobanque");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("Ma biobanque", $this->getText("css=div.portlet-title"));
        $this->click("css=#yw5 > li.active > a");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administrer la biobanque");
        $this->waitForPageToLoad("30000");
        $this->type("id=Biobank_collection_id", "LC0012");
        $this->click("name=yt0");
        $this->waitForPageToLoad("30000");
        $this->click("link=Administrer la biobanque");
        $this->waitForPageToLoad("30000");
        $this->click("link=Gérer les échantillons");
        $this->waitForPageToLoad("30000");
        $this->click("link=Analyse comparative");
        $this->waitForPageToLoad("30000");
        $this->click("link=Connecteur");
        $this->waitForPageToLoad("30000");
        $this->click("link=Déconnexion (demoAdminBb)");
        $this->waitForPageToLoad("30000");
    }

}
?>