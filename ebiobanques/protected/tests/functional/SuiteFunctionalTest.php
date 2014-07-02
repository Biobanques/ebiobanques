<?php

class SuiteFunctionalTest extends SeleniumWebTestCase
{

    //protected $coverageScriptUrl = 'http://localhost/phpunit/phpunit_coverage.php';

    protected function setUp() {
        parent::setUp();
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/ebiobanques/index-test.php");
    }

    public function testMyTestCase() {
        $this->open("http://localhost/ebiobanques/index-test.php");
        $this->selectWindow("null");
        $this->click("link=Accueil");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr : Améliorer la recherche de matériel biologique", $this->getText("css=h3"));
        $this->click("link=Rechercher des échantillons");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
        $this->assertEquals("Connexion", $this->getText("css=h1"));
        $this->click("link=Questions fréquentes");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Questions Site", $this->getTitle());
        //$this->assertTrue((bool) preg_match('/^exact:A quoi sert le projet ebiobanques\.fr[\s\S]$/', $this->getText("css=h3")));
        $this->click("link=Activités");
        $this->waitForPageToLoad("30000");
        $this->click("link=Biobanques");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Biobanks Site", $this->getTitle());
        $this->assertEquals("ebiobanques.fr - Biobanks Site", $this->getTitle());
        $this->assertEquals("Biobanques", $this->getText("css=h1"));
        $this->click("link=Contacts");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
        $this->assertEquals("Connexion", $this->getText("css=h1"));
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
        $this->assertEquals("Connexion", $this->getText("css=h1"));
    }

}
?>