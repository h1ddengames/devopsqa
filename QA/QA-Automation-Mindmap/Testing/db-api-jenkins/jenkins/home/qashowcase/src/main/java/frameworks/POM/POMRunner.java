package frameworks.POM;

import org.testng.annotations.Test;

/**
 * This class is the test script that runs tests using the POM framework.
 */
public class POMRunner extends POMBase{
    HomePage homePage;

    @Test
    public void visitingWomensSection() {
        homePage = new HomePage(driver);
        homePage.goToHomePageOfNordstromRack();
        homePage.goToWomensSection();
        POMBase.delayFor(5000);
    }

    @Test
    public void visitingKidsSection() {

    }

    @Test
    public void visitingMensSection() {

    }
}
