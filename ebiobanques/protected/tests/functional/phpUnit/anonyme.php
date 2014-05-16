<?php
class anonymeTest extends WebTestCase{
    public function test_anonyme()
  {
    $this->open("http://localhost/ebiobanques-mongodb/index.php");
    $this->selectWindow("null");
    $this->click("link=Connexion");
    $this->waitForPageToLoad("30000");
    $this->click("id=yt1");
    $this->waitForPageToLoad("30000");
    $this->click("name=yt0");
    $this->waitForPageToLoad("30000");
    try {
        $this->assertTrue($this->isElementPresent("css=div.errorMessage"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr/td[2]/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[2]/td/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[2]/td[2]/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[3]/td/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[4]/td[2]/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[5]/td/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $this->type("id=User_prenom", "matthieu");
    $this->type("id=User_nom", "penicaud");
    $this->type("id=User_login", "mpenicaud");
    $this->type("id=User_password", "aze");
    $this->type("id=User_email", "m1.netcourrier.com");
    $this->type("id=User_verifyCode", "ebiobanques");
    $this->click("name=yt0");
    $this->waitForPageToLoad("30000");
    try {
        $this->assertTrue($this->isElementPresent("css=div.errorMessage"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[2]/td[2]/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[3]/td/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $this->type("id=User_email", "m1@netcourrier.com");
    $this->click("name=yt0");
    $this->waitForPageToLoad("30000");
    $this->type("id=User_password", "aze54");
    $this->type("id=User_login", "mpenicaud2");
    $this->type("id=User_gsm", "060101");
    $this->click("name=yt0");
    $this->waitForPageToLoad("30000");
    try {
        $this->assertTrue($this->isElementPresent("css=div.errorMessage"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    try {
        $this->assertTrue($this->isElementPresent("//form[@id='user-form']/table/tbody/tr[4]/td[2]/div"));
    } catch (PHPUnit_Framework_AssertionFailedError $e) {
        array_push($this->verificationErrors, $e->toString());
    }
    $this->click("id=yw0_button");
    $this->click("name=yt0");
    $this->waitForPageToLoad("30000");
    $this->type("id=User_password", "azer12");
    $this->type("id=User_gsm", "060101010101");
    $this->type("id=User_verifyCode", "nicolas");
    $this->click("name=yt0");
    $this->waitForPageToLoad("30000");
  }
}
?>