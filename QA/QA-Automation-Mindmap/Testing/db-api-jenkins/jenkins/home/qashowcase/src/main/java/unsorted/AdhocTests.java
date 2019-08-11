package unsorted;

import org.openqa.selenium.WebDriver;
import org.testng.Assert;
import org.testng.annotations.AfterClass;
import org.testng.annotations.BeforeClass;
import org.testng.annotations.Test;
import settings.Browser;
import settings.Settings;
import settings.Setup;

public class AdhocTests {

    private WebDriver driver = null;
    private String homepage = "https://www.nordstromrack.com/";

    @BeforeClass
    public void setup() {
        if(Settings.browser == Browser.CHROME) {
            driver = Setup.setupChrome();
        } else if(Settings.browser == Browser.FIREFOX) {
            driver = Setup.setupFirefox();
        }
        Setup.manageTimeouts(driver);
    }

    @Test(priority = 0)
    public void visitHomepageValidTitle() {
        // Goes to the url contained within the homepage variable.
        driver.navigate().to(homepage);
        Assert.assertEquals(driver.getTitle(), "Nordstrom Rack Online & In Store: Shop Dresses, Shoes, Handbags, Jewelry & More");
    }

    @Test(priority = 1)
    public void visitHomepageInvalidTitle() {
        // Goes to the url contained within the homepage variable.
        driver.navigate().to(homepage);
        Assert.assertEquals(driver.getTitle(), "Nordstrom Rack Online");
    }

    @AfterClass
    public void tearDown() {
        // Closes the browser window that is in focus. Any other windows opened by this driver will stay open.
        driver.close();
        // Closes all of the browser windows opened by this driver and ends the WebDriver session gracefully.
        driver.quit();
    }
}