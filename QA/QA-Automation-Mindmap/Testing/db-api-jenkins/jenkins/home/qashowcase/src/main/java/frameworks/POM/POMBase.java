package frameworks.POM;

import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.testng.annotations.AfterClass;
import org.testng.annotations.BeforeClass;
import settings.Browser;
import settings.Settings;
import settings.Setup;

import java.util.Set;

/**
 * This class handles setting up the webdriver and tearing it down using the @BeforeClass and @AfterClass annotations.
 */
public class POMBase {
    protected WebDriver driver = null;
    protected JavascriptExecutor js = null;

    @BeforeClass
    public void setup() {
        driver = Setup.setup();
        js = (JavascriptExecutor) driver;
        System.out.println("Setup complete.");
    }

    @AfterClass
    public void tearDown() {
        Setup.tearDown(driver);
        System.out.println("Teardown complete.");
    }

    public static void delayFor(long milliseconds) {
        try {
            Thread.sleep(milliseconds);
        } catch (InterruptedException e) {
            e.printStackTrace();
        }
    }
}