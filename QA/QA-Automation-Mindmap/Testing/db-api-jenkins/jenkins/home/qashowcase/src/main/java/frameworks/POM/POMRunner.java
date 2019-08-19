package frameworks.POM;

import org.testng.Assert;
import org.testng.annotations.Test;

/**
 * This class is the test script that runs tests using the POM framework.
 */
public class POMRunner extends POMBase{
    HomePage homePage;
    LoginPage loginPage;

    @Test
    public void visitingWomensSection() {
        homePage = new HomePage(driver);
        homePage.goToHomePageOfNordstromRack();
        homePage.goToWomensSection();
        Assert.assertEquals(homePage.getPageUrl(), "https://www.nordstromrack.com/category/Women");
    }

    @Test
    public void visitingKidsSection() {
        homePage = new HomePage(driver);
        homePage.goToHomePageOfNordstromRack();
        homePage.goToKidsSection();
        Assert.assertEquals(homePage.getPageUrl(), "https://www.nordstromrack.com/category/Kids");
    }

    @Test
    public void visitingMensSection() {
        homePage = new HomePage(driver);
        homePage.goToHomePageOfNordstromRack();
        homePage.goToMensSection();
        Assert.assertEquals(homePage.getPageUrl(), "https://www.nordstromrack.com/category/Men");
    }

    @Test
    public void loginPositiveTest() {
        homePage = new HomePage(driver);
        homePage.goToHomePageOfNordstromRack();
        homePage.goToLoginPage();
        loginPage = new LoginPage(driver);
        loginPage.enterEmail("someemail@somedomain.com");
        loginPage.enterPassword("somepasswordhere");

        Assert.assertEquals(loginPage.getEnteredEmail(), "someemail@somedomain.com");
        Assert.assertEquals(loginPage.getEnteredPassword(), "somepasswordhere");
    }
}
