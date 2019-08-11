package settings;

import io.github.bonigarcia.wdm.WebDriverManager;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.chrome.ChromeOptions;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.firefox.FirefoxOptions;

import java.util.concurrent.TimeUnit;

public class Setup {
    public static WebDriver setupChrome() {
        // Sets up the chrome executable path within the script.
        WebDriverManager.chromedriver().setup();
        if(Settings.runHeadless) {
            ChromeOptions options = new ChromeOptions().addArguments("--start-maximized", "--window-size=1920,1080", "--headless");
            return new ChromeDriver(options);
        } else {
            // Generates a new chrome instance.
            return new ChromeDriver();
        }
    }

    public static WebDriver setupFirefox() {
        // Sets up the chrome executable path within the script.
        WebDriverManager.firefoxdriver().setup();
        if(Settings.runHeadless) {
            FirefoxOptions options = new FirefoxOptions().addArguments("--start-maximized", "--window-size=1920,1080", "--headless");
            return new FirefoxDriver(options);
        } else {
            // Generates a new chrome instance.
            return new FirefoxDriver();
        }
    }

    public static void manageTimeouts(WebDriver driver) {
        // This is only waiting to find the element, NOT waiting for the page to load.
        driver.manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
        // This waits until the page has loaded, excluding the time it takes to load JavaScript.
        driver.manage().timeouts().pageLoadTimeout(10, TimeUnit.SECONDS);
        // This waits until JavaScript has loaded and executed.
        driver.manage().timeouts().setScriptTimeout(10, TimeUnit.SECONDS);
    }
}