package settings;

import java.util.concurrent.TimeUnit;
import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxOptions;
import org.openqa.selenium.edge.EdgeDriver;
import org.openqa.selenium.ie.InternetExplorerDriver;

public class Setup {
    public static WebDriver setupChrome() {
        ChromeOptions options;
        // Sets up the chrome executable path within the script.
        WebDriverManager.chromedriver().setup();
        if (Settings.runHeadless) {
            options = new ChromeOptions().addArguments("--start-maximized", "--window-size=1920,1080", "--headless");
        } else {
            // Generates a new chrome instance.
            options = new ChromeOptions().addArguments("--start-maximized", "--window-size=1920,1080");
        }
        return new ChromeDriver(options);
    }

    public static WebDriver setupFirefox() {
        FirefoxOptions options;
        // Sets up the chrome executable path within the script.
        WebDriverManager.firefoxdriver().setup();
        if (Settings.runHeadless) {
            options = new FirefoxOptions().addArguments("--start-maximized", "--window-size=1920,1080", "--headless");
        } else {
            // Generates a new chrome instance.
            options = new FirefoxOptions().addArguments("--start-maximized", "--window-size=1920,1080");
        }
        return new FirefoxDriver(options);
    }

    //public static WebDriver setupOpera() {
    // // OperaDriver doesn't actually work. Since it runs on the same engine that Chrome uses, it's ok to just use Chrome.
    // }

    //public static WebDriver setupPhantomJS() {
    // // PhantomJS is no longer maintained.
    // }

    //public static WebDriver setupSafari() {
    // // Safari does not support headless.
    // // Setting up Safari is not worth the time.
    // }

    public static WebDriver setupEdge() {
        // Sets up the edge executable path within the script.
        WebDriverManager.operadriver().setup();
        // Edge does not have headless mode.
        return new EdgeDriver();
    }

    public static WebDriver setupIE() {
        // Sets up the opera executable path within the script.
        WebDriverManager.iedriver().setup();
        // IE does not have headless mode.
        return new InternetExplorerDriver();
    }

    public static void manageTimeouts(WebDriver driver) {
        // This is only waiting to find the element, NOT waiting for the page to load.
        driver.manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
        // This waits until the page has loaded, excluding the time it takes to load JavaScript.
        driver.manage().timeouts().pageLoadTimeout(10, TimeUnit.SECONDS);
        // This waits until JavaScript has loaded and executed.
        driver.manage().timeouts().setScriptTimeout(10, TimeUnit.SECONDS);
    }

    public static WebDriver setup() {
        WebDriver driver = null;
        if(Settings.browser == Browser.CHROME) {
            driver = setupChrome();
        } else if(Settings.browser == Browser.FIREFOX) {
            driver = setupFirefox();
        } else if(Settings.browser == Browser.EDGE) {
            driver = setupEdge();
        } else if(Settings.browser == Browser.IE) {
            driver = setupIE();
        }

        manageTimeouts(driver);
        driver.manage().window().maximize();
        return driver;
    }

    public static void tearDown(WebDriver driver) {
        if(Settings.browser == Browser.FIREFOX) {
            driver.quit();
        } else if(Settings.browser == Browser.CHROME) {
            // Closes the browser window that is in focus. Any other windows opened by this driver will stay open.
            driver.close();
            // Closes all of the browser windows opened by this driver and ends the WebDriver session gracefully.
            driver.quit();
        }
    }
}