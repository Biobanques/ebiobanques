<?php

use Facebook\WebDriver\WebDriverBy;
class AccueilTestTest extends FunctionalAbstractClass
{
protected $baseUrl;
  /**
   * Method testAccueilTest
   * @test
   */
  public function testAccueilTest()
  {
    // open | / | 
    parent::$webDriver->get($this->baseUrl . "/");
    // assertElementPresent | link=Accueil | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("Accueil"))!=null);
    // assertElementPresent | link=Catalogue des biobanques | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("Catalogue des biobanques"))!=null);
    // assertElementPresent | link=Questions fréquentes | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("Questions fréquentes"))!=null);
    // assertElementPresent | link=Connexion | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("Connexion"))!=null);
    // assertElementPresent | link=Demande d'échantillons biologiques | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("Demande d'échantillons biologiques"))!=null);
    // assertElementPresent | link=Nous contacter | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("Nous contacter"))!=null);
    // assertElementPresent | css=img[alt="logo"] | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::cssSelector("img[alt=\"logo\"]"))!=null);
    // assertTitle | ebiobanques.fr - Site | 
    $this->assertEquals("ebiobanques.fr - Site", parent::$webDriver->getTitle());
    // assertText | css=h3 | ebiobanques.fr : Améliorer la recherche de matériel biologique
    $this->assertEquals("ebiobanques.fr : Améliorer la recherche de matériel biologique", parent::$webDriver->findElement(WebDriverBy::cssSelector("h3"))->getText());
    // assertElementPresent | link=connexion | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::linkText("connexion"))!=null);
    // assertElementPresent | xpath=(//a[contains(text(),'Catalogue des biobanques')])[2] | 
    $this->assertTrue(parent::$webDriver->findElements(WebDriverBy::xpath("(//a[contains(text(),'Catalogue des biobanques')])[2]"))!=null);
  }

}
