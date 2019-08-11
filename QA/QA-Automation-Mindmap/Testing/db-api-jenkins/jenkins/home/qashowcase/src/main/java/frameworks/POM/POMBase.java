package frameworks.POM;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.JavascriptExecutor;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.testng.annotations.AfterClass;
import org.testng.annotations.BeforeClass;
import settings.Browser;
import settings.Settings;
import settings.Setup;

import java.util.concurrent.TimeUnit;

/**
 * This class handles setting up the webdriver and tearing it down using the @BeforeClass and @AfterClass annotations.
 */
public class POMBase {
    protected WebDriver driver = null;
    protected JavascriptExecutor js = null;

    @BeforeClass
    public void setup() {
        if(Settings.browser == Browser.CHROME) {
            driver = Setup.setupChrome();
        } else if(Settings.browser == Browser.FIREFOX) {
            driver = Setup.setupFirefox();
        }

        js = (JavascriptExecutor) driver;

        Setup.manageTimeouts(driver);
        driver.manage().window().maximize();

        System.out.println("Setup complete.");
    }

    @AfterClass
    public void tearDown() {
        // Closes the browser window that is in focus. Any other windows opened by this driver will stay open.
        driver.close();
        // Closes all of the browser windows opened by this driver and ends the WebDriver session gracefully.
        driver.quit();
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