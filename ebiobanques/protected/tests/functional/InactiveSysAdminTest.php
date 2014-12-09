<?php

class InactiveSysUserTest extends SeleniumWebTestCase
{

    protected function setUp() {
        $this->setBrowser("*firefox");
        $this->setBrowserUrl("http://localhost/ebiobanques/index-test.php");
    }

    public function testMyTestCase() {
        $this->open("http://localhost/ebiobanques/index-test.php");
        $this->click("link=Connexion");
        $this->waitForPageToLoad("30000");
        $this->type("id=LoginForm_username", "demoInactiveAdminSys");
        $this->type("id=LoginForm_password", "demoInactiveAdminSys");
        $this->click("name=yt0");
        $this->assertEquals("ebiobanques.fr - Login Site", $this->getTitle());
        $this->assertTrue($this->isTextPresent(""));
    }

}
?>