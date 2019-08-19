package frameworks.POM;

import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.support.FindBy;
import org.openqa.selenium.support.PageFactory;

public class LoginPage extends Page {
    @FindBy(name="email") protected WebElement emailLogin;
    @FindBy(name="password") protected WebElement passwordLogin;
    @FindBy(xpath="//div/button[@class='authentication-modal__alternate-action']") protected WebElement loginButton;
    @FindBy(xpath="//div[@class='authentication-form__submit']/button[@type='submit']") protected  WebElement createAccountButton;
    @FindBy(xpath="//button[contains(text(),'No, thanks. Continue browsing.')]") protected WebElement continueBrowsingButton;

    public LoginPage(WebDriver driver) {
        super(driver);
        PageFactory.initElements(driver, this);
    }

    public void enterEmail(String email) {
        emailLogin.sendKeys(email);
    }

    public void enterPassword(String password) {
        passwordLogin.sendKeys(password);
    }

    public String getEnteredEmail() {

        return emailLogin.getAttribute("value");
    }

    public String getEnteredPassword() {
        return passwordLogin.getAttribute("value");
    }

    public void login(String email, String password) {
        enterEmail(email);
        enterPassword(password);
        loginButton.click();
    }

    public void signUp(String email, String password) {
        enterEmail(email);
        enterPassword(password);
        createAccountButton.click();
    }

    public void cancelLogin() {
        continueBrowsingButton.click();
    }
}
