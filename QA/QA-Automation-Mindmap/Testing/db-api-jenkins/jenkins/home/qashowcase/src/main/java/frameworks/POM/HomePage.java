package frameworks.POM;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.support.PageFactory;

/**
 * This class handles finding the elements on the home page of the website: NordstromRack.
 */
public class HomePage extends Page {
    public String homePageURL = "https://www.nordstromrack.com/";

    public HomePage(WebDriver driver) {
        super(driver);
        PageFactory.initElements(driver, this);
    }

    public void goToHomePageOfNordstromRack() {
        driver.navigate().to(homePageURL);
    }
}