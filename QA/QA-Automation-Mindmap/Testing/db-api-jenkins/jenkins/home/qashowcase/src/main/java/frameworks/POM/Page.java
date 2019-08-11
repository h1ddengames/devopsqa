package frameworks.POM;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

/**
 * This class handles finding the navigation elements of the website: NordstromRack.
 * Since the navigation elements are the same no matter what page of NordstromRack someone is on,
 *      this class is the parent class for all other page classes. Inheritance is used here because
 *      all the page classes require a reference to the navigation. Composition could have worked here too
 *      but I opted for Inheritance because it was easier to implement.
 * Important note: When selecting an element that has multiple results, xpath will always start at 1.
 * For example: if //nav[@class='site-header__primary-nav']/ul/li returns 7 results,
 *      //nav[@class='site-header__primary-nav']/ul/li[1] will be the first
 *      //nav[@class='site-header__primary-nav']/ul/li[7] will be the last
 */
public class Page {
    protected WebDriver driver = null;

    @FindBy(xpath="//a[@class='logo logo--nordstromrack']") protected WebElement logo;
    @FindBy(xpath="//input[@class='search-bar__input']") protected WebElement searchBar;
    @FindBy(linkText="Log In / Sign Up") protected WebElement login;
    @FindBy(xpath="//div/div/a[@aria-label='Cart']") protected WebElement shoppingCart;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[1]/a") protected WebElement womensSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[2]/a") protected WebElement shoesSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[3]/a") protected WebElement bagsAccessoriesSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[4]/a") protected WebElement beautySection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[5]/a") protected WebElement mensSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[6]/a") protected WebElement kidsSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[7]/a") protected WebElement homeSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[8]/a") protected WebElement giftsSection;
    @FindBy(xpath="//nav[@class='site-header__primary-nav']/ul/li[9]/a") protected WebElement clearanceSection;

    public Page(WebDriver driver) {
        this.driver = driver;
        PageFactory.initElements(driver, this);
    }

    public void goToHomePage() { logo.click(); }
    public void goToLoginPage() { login.click(); }
    public void enterTextIntoSearchBar(String text) { searchBar.sendKeys(text); }
    public void goToShoppingCart() { shoppingCart.click(); }
    public void goToWomensSection() { womensSection.click(); }
    public void goToShoesSection() { }
    public void goToBagsAccessoriesSection() { }
    public void goToBeautySection() { }
    public void goToMensSection() { }
    public void goToKidsSection() { }
    public void goToHomeSection() { }
    public void goToGiftsSection() { }
    public void goToClearanceSection() { }
}