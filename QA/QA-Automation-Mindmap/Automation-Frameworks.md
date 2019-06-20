## Automation Frameworks
- This document contains all information related to any questions that can be asked about common automation frameworks. 
#

#### Maven
- Maven is a powerful project management tool that is based on POM (project object model).
- It is used for projects build, dependency and documentation.
- Some features of Maven include:
    - Easily build a project.
    - Easily add jars and other dependencies required.
    - Easily hook up source control.

- Maven comes preinstalled with most IDEs.
    - In order to make your project a maven project, create the project in the IDE's GUI and select ```Maven project```. 
- POM file is the Page Object Model file that is written in XML.
    - It contains information related to the project:
        ```
        <project xmlns="http://maven.apache.org/POM/4.0.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://maven.apache.org/POM/4.0.0 http://maven.apache.org/xsd/maven-4.0.0.xsd">
        <modelVersion>4.0.0</modelVersion>

            <groupId>org.example</groupId>
            <artifactId>projectName</artifactId>
            <version>1.0</version>
            <packaging>jar</packaging>
            ...
        </project>
        ```
    - It contains dependency information:
        ```
        <project ...
            ...
             <dependencies>
                <dependency>
                    <groupId>junit</groupId>
                    <artifactId>junit</artifactId>
                    <version>3.8.1</version>
                    <scope>test</scope>
                </dependency>
                <dependency>
                    <groupId>mysql</groupId>
                    <artifactId>mysql-connector-java</artifactId>
                    <version>5.1.14</version>
                </dependency>
            </dependencies>
            ...
        </project>
        ```

    - It contains configuration information
        ```
        <project ...
            ...
            <properties>
                <project.build.sourceEncoding>UTF-8</project.build.sourceEncoding>
            </properties>

            <build>
                <plugins>
                    <plugin>
                        <groupId>org.apache.maven.plugins</groupId>
                        <artifactId>maven-compiler-plugin</artifactId>
                        <version>2.3.2</version>
                        <configuration>
                            <source>1.6</source>
                            <target>1.6</target>
                        </configuration>
                    </plugin>
                </plugins>
            </build>
            ...
        </project>
        ```

- Build Life Cycles, Phases and Goals: 
    - A build life cycle consists of a sequence of build phases, and each build phase consists of a sequence of goals. 
    - Maven command is the name of a build life cycle, phase or goal.
        - validate - validate the project is correct and all necessary information is available

        - compile - compile the source code of the project
        
        - test - test the compiled source code using a suitable unit testing framework. These tests should not require the code be packaged or deployed
        
        - package - take the compiled code and package it in its distributable format, such as a JAR.
        
        - integration-test - process and deploy the package if necessary into an environment where integration tests can be run
        
        - verify - run any checks to verify the package is valid and meets quality criteria
        install - install the package into the local repository, for use as a dependency in other projects locally
        
        - deploy - done in an integration or release environment, copies the final package to the remote repository for sharing with other developers and projects.

        - Example:
        ```
        mvn clean
        mvn clean install plugin:goal
        mvn verify test package
        ```

#
#### Bug Reporting / Bug Tracking
- Bug Reporting/ Bug Tracking is the process of capturing, reporting, and managing data on bugs that occur in software (also called errors and exceptions).
- The goal is to maintain high product quality, using two types of services: task management systems and bug capturing tools.
    - Project or task management systems are used as a large-scale overview of the project. 
    - Beyond merely tracking the progress of bug fixes, they provide insights into the performance of the development team in how efficiently they are able to handle bugs, and building new features along the side.

    #
    #### Jira
    - Jira is project management software that has the ability to track bugs. 
    - Contains:
        - Planning
            - Scrum
            - Kanban
            - Mixed
        - Tracking
            - Features
            - Bugs
        - Releasing
        - Reporting
    
    - Every feature that needs to be built is represented as an Epic.
    - Each Epic is broken down into smaller items such as User Stories and Issues.

    #
    #### Bugzilla
    - Bugzilla is a defect-tracking system (bug-tracking system)
        - This allows teams of developers to keep track of bugs, problems, issues, and other change requests. 
        - Defect-tracking is built into source control management environments but often times businesses will outgrow the abilities of these systems. 
            - Benefits include:
                - Being completely free.
                - In active development
                - Has workflow management built in.
                - Bug visibility control.
                - Custom fields.
                
#
#### CI/CD
- CI/CD is 
    - CI is continuous Integration a development practice that requires developers to integrate code into a shared repository several times a day. Each check-in is then verified by an automated build, allowing teams to detect problems early. 
        - How to do it:
            - Developers check out code into their private workspaces
            - When done, commit the changes to the repository
            - The CI server monitors the repository and checks out changes when they occur
            - The CI server builds the system and runs unit and integration tests
            - If the build or tests fail, the CI server alerts the team
            - The team fixes the issue at the earliest opportunity
            - Continue to continually integrate and test throughout the project
        
        - Team Responsibilities:
            - Check in frequently
            - Don’t check in broken code
            - Don’t check in untested code
            - Don’t check in when the build is broken
            - Don’t go home after checking in until the system builds

    - CD is Continuous Delivery is the application development discipline that takes Agile to it's logical conclusion: creating software that is always ready to release. 

    - Release management describes the steps that are typically performed to release a software application, including building and functional testing, tagging releases, assigning versions, and deploying and activating the new version in production.

    #
    #### Jenkins
    - Jenkins provides many plugins that support building, deploying, and automating any project.
    - It can be used as a simple CI server or turned into the continuous delivery hub for any project.

    - Benefits:
        - Easy to install
        - Easy to configure
        - Easy to use
        - Extensible
        - Work can be distributed across multiple machines
    
    - We have a Git repository where the development team will commit the code. Then, Jenkins takes over from there, a front-end tool where you can define your entire job or the task. 
    - From Git, Jenkins pulls the code and then Jenkins moves it into the commit phase, where the code is committed from every branch. 
    - The build phase is where we compile the code. If it is Java code, we use tools like maven in Jenkins and then compile that code, which can be deployed to run a series of tests. 

    #
    #### Bamboo
    - Bamboo is a continuous integration server that can be used to automate the release management for a software application, creating a continuous delivery pipeline.

    #
    #### Browser Stack
    - Browser Stack is a cloud web and mobile testing platform that enables developers to test their websites and mobile applications across on-demand browsers, operating systems and real mobile devices, without requiring users to install or maintain an internal lab of virtual machines, devices or emulators.
    - Users can choose from more than 1,200 on-demand real mobile devices, browsers and operating systems and rely on a secure, stable and scalable infrastructure to support thousands of concurrent manual and automated tests. 

#
#### Selenium
- Selenium is used to automate browsers.
- It is primarily used for automating web applications for testing purposes. 

    #
    #### Selenium WebDriver
    - WebDriver is a compact Object Oriented API that builds off of Selenium 1.0
    - It drives a browser natively as a user would either locally or on a remote machine using Selenium Server.

    #
    #### Selenium Grid
    - Selenium-Grid allows you run your tests on different machines against different browsers in parallel. 
    
    #
    #### API
    In order to start using Selenium with Java, the Selenium package must be imported:
    ```
    import org.openqa.selenium.*;
    ```

    The package contains Firefox, Chrome, Edge, Internet Explorer, and Safari drivers and options.

    Webdriver contains: 
    - .manage()
        - timeouts()
            - pageLoadTimeout()
            - implicitlyWait()
            - setScriptTimeout()
        - COOKIES
            - addCookie()
            - deleteCookie()
            - deleteCookieNamed
            - getCookieNamed()
            - getCookies() 
        - ime()
        - logs()
        - window()
            - fullscreen()
            - getPosition()
            - getSize()
            - maximize()
            - setPosition()
            - setSize()
    - .close()
    - .quit()
    - .findElement()
    - .findElements()
    - GET
        - .getTitle()
        - .get()
        - .getCurrentUrl()
        - .getPageSource()
        - .getWindowHandle()
        - .getWindowHandles()
    - .navigate()
        - back()
        - forward()
        - refresh()
        - to()
    - .switchTo()
        - activeElement()
        - alert()
        - defaultContent()
        - frame()
        - parentFrame()
        - window()

    #
    #### Locators
    - There are 8 ways of locating an element on a webpage.
      - An element can be something like the login button or an image or even a ```<div></div>```
    - These are the locators:
      - ID: ```driver.findElement(By.id("menu"));```
      - Name: ```driver.findElement(By.name("home"));```
      - Link Text: ```driver.findElement(By.linkText("Read on Wikipedia"));```
      - Partial Link Text: ```driver.findElement(By.partialLinkText("Wikipedia"));```
      - Tag Name: ```driver.findElement(By.tagName("div"));```
      - Class Name: ```driver.findElement(By.className("container-top"));```
      - CSS: ```driver.findElement(By.cssSelector(".top-menu>li"));```
      - Xpath: ```driver.findElement(By.xpath("//*[@id='top-menu']/li"));```

    #
    #### XPath
    - XPath stands for XML Path Language.
    - XPath uses "path like" syntax to identify and navigate nodes in an XML document.
    - XPath can be used to navigate through elements and attributes in an XML document.
    - Absolute Path - this type of XPath starts at the root of the document and starts with a single "/" slash.
    - Relative Path - this type of XPath starts at the element that you specify and starts with two "//" slashes.

        #
        #### XPath Nodes
        - In XPath, there are seven kinds of nodes: 
            1. element: ```driver.findElement(By.xpath("//li"));``` // Anything with an opening tag such as ```<div></div>``` ```<li></li>``` ```<ul></ul>``` ```<body></body>```
            2. attribute: ```driver.findElement(By.xpath("//title[@*='en']"));``` // Anything with an attribute such as ```<title lang='en'></title>``` ```<title s='en'></title>```
            3. text: ```driver.findElement(By.xpath("//li[text()='Data']"));```
            4. namespace 
            5. processing-instruction
            6. comment ```driver.findElement(By.xpath("/table/length/following::comment()[1]"));``` // Table has child length and right after length there is a comment. This xpath finds the element length then looks right after the element to find the first comment.
            7. document nodes

        #
        #### XPath Axes
        - In Xpath, an axis represents a relationship to the context (current) node, and is used to locate nodes relative to that node on the tree.
            1. ancestor	- Selects all ancestors (parent, grandparent, etc.) of the current node
            2. ancestor-or-self	- Selects all ancestors (parent, grandparent, etc.) of the current node and the current node itself
            3. attribute - Selects all attributes of the current node
            4. child - Selects all children of the current node
            5. descendant - Selects all descendants (children, grandchildren, etc.) of the current node
            6. descendant-or-self - Selects all descendants (children, grandchildren, etc.) of the current node and the current node itself
            7. following - Selects everything in the document after the closing tag of the current node 
            8. following-sibling - Selects all siblings after the current node
            9. namespace - Selects all namespace nodes of the current node 
            10. parent - Selects the parent of the current node 
            11. preceding - Selects all nodes that appear before the current node in the document, except ancestors, attribute nodes and namespace nodes 
            12. preceding-sibling - Selects all siblings before the current node
            13. self - Selects the current node

        #
        #### XPath Operators
        | Operator | Description | Example
        | --- | --- | --- |
        | ```|```    |  Computes two node-sets | ```//book | //cd``` (combines all the results of //book and all the results of //cd) |
        | ```+``` | Addition| 6 + 4 |
        | ```-``` | Subtraction | 6 - 4 |
        | ```*``` | Multiplication | 6 * 4 |
        | ```div``` | Division | 8 div 4 |
        | ```=``` | Equal | price=9.80 |
        | ```!=```| Not equal | price!=9.80 |
        | ```<```| Less than | price<9.80 |
        | ```<=```| Less than or equal to | price<=9.80 |
        | ```>```| Greater than | price>9.80 |
        | ```>=```| Greater than or equal to| price>=9.80 |
        | ```or```| or | //price[text()='29.99' or text()='30.00'] |
        | ```and```| and | //price[text()='29.99' and text()>='25'] |
        | ```mod```| mod | 5 mod 2 |

    #
    #### Exceptions
    - Some common exceptions include:
        - <b>ElementNotVisibleException</b>: Although an element is present in the DOM, it is not visible (cannot be interacted with). For example: Hidden Elements – defined in HTML using type=”hidden”.
        - <b>ElementNotSelectableException</b>: Although an element is present in the DOM, it may be disabled (cannot be clicked/selected).
        - <b>NoSuchElementException</b>: Webdriver is unable to identify the elements during runtime, i.e. FindBy method can’t find the element.
        - <b>StaleElementReferenceException</b>: The referenced element is no longer present on the DOM page (reference to an element is now Stale). For example: the element belongs to a different frame than the current one OR the user has navigated away to another page.
        - <b>TimeoutException</b>: The command did not complete in enough time. E.g. the element didn’t display in the specified time. Encountered when working with waits.

    #
    #### Benefits
    - Open source, active contributions from community.
    - Supports a lot of languages such as Java, Python, C#, and Javascript.
    - Supports the most common operating systems (Windows, Linux, Mac)
    - Supports all popular web browsers.
    - Lots of online resources.

    #
    #### Limitations
    - Web based stuff only, doesn't support Desktop Applications/Windows bases applications.
    - No official support.

#
#### Appium
- Appium is an open source test automation framework for use with native, hybrid and mobile web apps. 

#
#### Page Object Model
- Page Object Model is a design pattern to create Object Repository for web UI elements. 
- Under this model, for each web page in the application, there should be corresponding page class. 
    - This Page class will find the WebElements of that web page and also contains Page methods which perform operations on those WebElements.

    #
    #### Page Factory
    - Page Factory is an inbuilt Page Object Model concept for Selenium WebDriver but it is very optimized.
    - The FindBy annotation is used in place of the FindElement(s) method(s)
    - The PageFactory.initElements(...) is used to find the elements when the page object is being initialized. 

    ```
    import org.openqa.selenium.WebDriver;
    import org.openqa.selenium.WebElement;
    import org.openqa.selenium.support.FindBy;
    import org.openqa.selenium.support.PageFactory;
    public class LoginPage {
        WebDriver driver;

        @FindBy(name="username")
        WebElement username;

        @FindBy(name="password")
        WebElement password;    

        @FindBy(className="title")
        WebElement titleText;

        @FindBy(name="login")
        WebElement login;

        public LoginPage(WebDriver driver){
            this.driver = driver;
            PageFactory.initElements(driver, this);
        }

        public void setUsername(String name){
            username.sendKeys(name);     
        }

        public void setPassword(String pass){
            password.sendKeys(pass);
        }

        public void clickLogin(){
            login.click();
        }

        public void loginToApplication(String user,String pass){
            this.setUsername(user);
            this.setPassword(pass);
            this.clickLogin();           
        }
    }
    ```

#
#### Cucumber
- Cucumber is a testing tool that supports Behavior Driven Development (BDD) framework. It defines application behavior using simple English text, defined by a language called Gherkin.
- Cucumber is used to implement Behavior Driven Development (BDD).
    - Behavior Driven Development gives us an opportunity to create test scripts from both the developer’s and the customer’s perspective as well. 

- How it works: 
    1. Describe the behavior
    2. Write step definition
    3. Run and fail
    4. Write code to make the step pass
    5. Run and pass

    #
    #### Gherkin
    - Gherkin is a plain English text language, which helps the tool - Cucumber to interpret and execute the test scripts.
    - A simple feature file consists of the following keywords/parts −
        - Feature − Name of the feature under test.
        - Description (optional) − Describe about feature under test.
        - Scenario − What is the test scenario.
        - Given − Prerequisite before the test steps get executed.
            - Example − GIVEN I am a user
        - When − Specific condition which should match in order to execute the next step.
            - Example − WHEN I enter ```"<username>"```
        - Then − What should happen if the condition mentioned in WHEN is satisfied.
            - Example − THEN login should be successful.
        - And − It provides the logical AND condition between any two statements. AND can be used in conjunction with GIVEN, WHEN and THEN statement.
            - Example − WHEN I enter my ```"<username>"``` AND I enter my ```"<password>"```

- Example Feature file:
    ```
    Feature: Login Action

    Scenario: Successful Login with Valid Credentials
        Given User is on Home Page
        When User Navigate to Login Page
        And User enters username and password
        Then Message displayed Login Successfully

    Scenario: Successful LogOut
        When User LogOut from the Application
        Then Message displayed LogOut Successfully
    ```

- Example Step Definition:
    ```
    @Given("^User is on Home Page$")
	public void user_is_on_Home_Page() throws Throwable {
		driver = new FirefoxDriver();
        driver.manage().timeouts().implicitlyWait(10, TimeUnit.SECONDS);
        driver.get("http://www.store.demoqa.com");
	}
    ```

#
#### Testing Frameworks
-  Testing Frameworks are comprised of a combination of practices and tools that are designed to help QA professionals test more efficiently.

    #
    #### TestNG
    - TestNG is Test Next Generation and it is a testing framework that has more features compared to JUnit. 

        #### Features
        - Introduces "test groups" where user specified tests can be run without running all tests.
        - Support for multi threaded testing.
        - Supports annotations.

        #### Setup with Maven
        ```
        <!-- https://mvnrepository.com/artifact/org.testng/testng -->
        <dependency>
            <groupId>org.testng</groupId>
            <artifactId>testng</artifactId>
            <version>7.0.0-beta3</version>
            <scope>test</scope>
        </dependency>

        <!-- https://mvnrepository.com/artifact/org.apache.maven.plugins/maven-surefire-plugin -->
        <dependency>
            <groupId>org.apache.maven.plugins</groupId>
            <artifactId>maven-surefire-plugin</artifactId>
            <version>3.0.0-M3</version>
        </dependency>

        <build>
            <plugins>
                <plugin>
                    <groupId>org.apache.maven.plugins</groupId>
                    <artifactId>maven-surefire-plugin</artifactId>
                    <version>3.0.0-M3</version>
                    <configuration>
                        <suiteXmlFiles>
                            <suiteXmlFile>testng-shifttest.xml</suiteXmlFile>
                        </suiteXmlFiles>
                        <argLine>
                            -javaagent:"${settings.localRepository}/org/aspectj/aspectjweaver/${aspectj.version}/aspectjweaver-${aspectj.version}.jar"
                        </argLine>
                    </configuration>
                </plugin>
            </plugins>
        </build>
        ```

        #### Creating a Simple Test
        1. Create a file called TestNGSimpleTest.java (File name MUST match class name)
        2. Type in the following into the created file.
        ```
        import org.testng.annotations.Test;
        import org.testng.Assert.assertEquals;

        public class TestNGSimpleTest {
            @Test
            public void testAdd() {
                String str = "TestNG is working fine";
                AssertEquals("TestNG is working fine", str);
            }
        }
        ```

        #### Running the Simple Test 
        1. Create a file called testng.xml (File name can be anything but must have .xml file type)
        2. Type in the following into the created file.
        ```
        <?xml version = "1.0" encoding = "UTF-8"?>
        <!DOCTYPE suite SYSTEM "http://testng.org/testng-1.0.dtd" >

        <suite name = "Suite1">
            <test name = "test1">
                <classes>
                    <class name = "TestNGSimpleTest"/>
                </classes>
            </test>
        </suite>
        ```
        1. Run this file in your IDE (such as IntelliJ IDEA or Eclipse) or Run TestNGSimpleTest class. 
        2. The results will be output into a folder called test-output.

        #### TestNG Annotations
        These are contained in the org.testng.annotations package:
        1. @BeforeSuite = This annotation will only run the method below it once before all tests in the suite have run.
        2. @AfterSuite = This annotation will only run the method below it once after all tests in the suite have run.
        3. @BeforeClass = This annotation will only run the method below it once before the current class is run.
        4. @AfterClass = This annotation will only run the method below it once after the current class has run. 
        5. @BeforeTest = This annotation will only run the method below it before every test.
        6. @AfterTest = This annotation will only run the method below it after every test.
        7. @BeforeMethod = The annotated method will be run before each test method.
        8. @AfterMethod = The annotated method will be run after each test method.
        9. @DataProvider = This annotation marks the method below it as supplying data for a test method. The annotated method MUST return an Object[][]. The @Test method that wants to receive data from this DataProvider needs to use a dataProvider name equal to the name of the method that was annotated with @DataProvider.
        10. @Factory = This annotation marks the method below it as a factory that returns objects that will be used by TestNG as Test classes. This method MUST return Object[].
        11. @Listeners = Defines listeners on a test class (Listeners are third-party report generating tools)
        12. @Parameters = Describes how to pass parameters to a @Test method.
        13. @Test = This annotation marks a class or method as a part of the test.

        #### Order of Execution for TestNG Annotations
        1. BeforeSuite
        2. BeforeTest
        3. BeforeClass
        4. BeforeMethod
        5. Test
        6. AfterMethod
        7. AfterClass
        8. AfterTest
        9. AfterSuite

        #### Ignoring Tests
        ```
        @Test(enabled = false)
        ```

        #### Grouping Tests
        ```
        @Test(groups = { "functest", "checkintest" })
        @Test(groups = { "functest" })

        <?xml version = "1.0" encoding = "UTF-8"?>
        <!DOCTYPE suite SYSTEM "http://testng.org/testng-1.0.dtd" >

        <suite name = "Suite1">
            <test name = "test1">
            
                <groups>
                    <run>
                        <include name = "functest" />
                    </run>
                </groups>

                <classes>
                    <class name = "GroupTestExample" />
                </classes>
            
            </test>
        </suite>
        ```

        Groups can also be grouped and some groups can be excluded.
        ```
        <?xml version = "1.0" encoding = "UTF-8"?>
        <!DOCTYPE suite SYSTEM "http://testng.org/testng-1.0.dtd" >

        <suite name = "Suite1">
            <test name = "test1">
            
                <groups>
                
                    <define name = "all">
                        <include name = "functest"/>
                        <include name = "checkintest"/>
                        <exclude name = "notready"/>
                    </define>
                    
                    <run>
                        <include name = "all"/>
                    </run>
                    
                </groups>
                
                <classes>
                    <class name = "GroupTestExample" />
                </classes>
                
            </test>
        </suite>
        ```

        #### Parameterized Test
        With testng.xml :
        ```
        import org.testng.annotations.Parameters;
        import org.testng.annotations.Test;

        public class ParameterizedTest1 {
            @Test
            @Parameters("myName")
            public void parameterTest(String myName) {
                System.out.println("Parameterized value is : " + myName);
            }
        }

        <?xml version = "1.0" encoding = "UTF-8"?>
        <!DOCTYPE suite SYSTEM "http://testng.org/testng-1.0.dtd" >

        <suite name = "Suite1">
            <test name = "test1">
            
                <parameter name = "myName" value="Shahid"/> 
                
                <classes>
                    <class name = "ParameterizedTest1" />
                </classes>
                
            </test>
        </suite>
        ```

        With Data Providers :
        ```
        public class PrimeNumberChecker {
            public Boolean validate(final Integer primeNumber) {
            
                for (int i = 2; i < (primeNumber / 2); i++) {
                    if (primeNumber % i == 0) {
                        return false;
                    }
                }
                return true;
            }
        }

        import org.testng.Assert;
        import org.testng.annotations.BeforeMethod;
        import org.testng.annotations.DataProvider;
        import org.testng.annotations.Test;

        public class ParamTestWithDataProvider1 {
            private PrimeNumberChecker primeNumberChecker;

            @BeforeMethod
            public void initialize() {
                primeNumberChecker = new PrimeNumberChecker();
            }

            @DataProvider(name = "test1")
            public static Object[][] primeNumbers() {
                return new Object[][] {{2, true}, {6, false}, {19, true}, {22, false}, {23, true}};
            }

            // This test will run 4 times since we have 5 parameters defined
            @Test(dataProvider = "test1")
            public void testPrimeNumberChecker(Integer inputNumber, Boolean expectedResult) {
                System.out.println(inputNumber + " " + expectedResult);
                Assert.assertEquals(expectedResult, primeNumberChecker.validate(inputNumber));
            }
        }

        <?xml version = "1.0" encoding = "UTF-8"?>
        <!DOCTYPE suite SYSTEM "http://testng.org/testng-1.0.dtd" >

        <suite name = "Suite1">
            <test name = "test1">
                <classes>
                    <class name = "ParamTestWithDataProvider1" />
                </classes>
            </test>
        </suite>
        ```

    #
    #### Robot Framework 
    - Robot Framework is a generic open source automation framework for acceptance testing, acceptance test driven development (ATDD), and robotic process automation (RPA).
    - Utilizes the keyword-driven testing approach. 
    - Example Test Case:
        ```
        *** Settings ***
        Documentation     A test suite with a single test for valid login.
        ...
        ...               This test has a workflow that is created using keywords in
        ...               the imported resource file.
        Resource          resource.robot

        *** Test Cases ***
        Valid Login
            Open Browser To Login Page
            Input Username    demo
            Input Password    mode
            Submit Credentials
            Welcome Page Should Be Open
            [Teardown]    Close Browser
        ```

    #
    #### JUnit
    - JUnit is an open source Unit Testing Framework for JAVA. It is useful for Java Developers to write and run repeatable tests.
    
    - Annotations: 
        - @Before annotation is used on a method containing Java code to run before each test case. i.e it runs before each test execution.
        - @After annotation is used on a method containing java code to run after each test case. These methods will run even if any exceptions are thrown in the test case or in the case of assertion failures.
        - @BeforeClass is used on a method to run "only one time" setup tasks. Like the name implies, it will only run before a class. 
        - @AfterClass is used on a method to run "only one time" teardown tasks. Like the name implies, it will only run after a class. 
        - @Test is a replacement of org.junit.TestCase which indicates that public void method to which it is attached can be executed as a test Case.
    
    - Annotation Execution Order:
        1. Execute the @BeforeClass method in this class.
        2. Execute the @Before methods in the superclass
        3. Execute the @Before methods in this class
        4. Execute a @Test method in this class
        5. Execute the @After methods in this class
        6. Execute the @After methods in the superclass
        7. Execute the @AfterClass method in this class.

    - Example Test Case:
        ```
        @Test		
        public void myFirstMethod(){					
            String str= "JUnit is working fine";					
            assertEquals("JUnit is working fine",str);					
        }
        ```

#
#### Parallel Execution
- Instead of running tests sequentially, or one after the other, parallel testing allows us to execute multiple tests at the same point in time across different environments or part of the code base.

    #
    #### Thread-safe Driver
    - According to the FAQ section of the Selenium github repository, WebDriver is NOT thread-safe. The FAQ goes onto state that if we can serialize access to the underlying driver instance, we can share a reference in more than one thread but it is not advisable.
    - With the way I have setup the CommonAutomationFramework, I take advantage of ThreadLocal serialization of the WebDriver as Follows:
        ```
        package framework;
        import org.openqa.selenium.chrome.*;
        import org.openqa.selenium.firefox.*;

        public class DriverFactory {
            private static DriverFactory instance = new DriverFactory();
            private static final ThreadLocal<ChromeDriver> chromeDriverThreadLocal = new ThreadLocal<ChromeDriver>() {
                @Override
                protected ChromeDriver initialValue() {
                    ChromeOptions options = new ChromeOptions().addArguments("--start-maximized", "--headless");
                    return new ChromeDriver(options);
                }
            };

            private static final ThreadLocal<FirefoxDriver> firefoxDriverThreadLocal = new ThreadLocal<FirefoxDriver>() {
                @Override
                protected FirefoxDriver initialValue() {
                    FirefoxOptions options = new FirefoxOptions().addArguments("--start-maximized", "--headless");
                    return new FirefoxDriver(options);
                }
            };

            public static DriverFactory getInstance() { return instance; }
            public ChromeDriver getChromeDriver() { return chromeDriverThreadLocal.get(); }
            public FirefoxDriver getFirefoxDriver() { return firefoxDriverThreadLocal.get(); }

            public void setChromeDriver(ChromeDriver driver) { chromeDriverThreadLocal.set(driver); }
            public void setFirefoxDriver(FirefoxDriver driver) { firefoxDriverThreadLocal.set(driver); }

            private DriverFactory() { }

            public void removeDrivers() {
                if(getChromeDriver() != null) {
                    try {
                        getChromeDriver().close(); getChromeDriver().quit();
                    } catch(Exception e) { e.printStackTrace(); }
                }
                if(getFirefoxDriver() != null) {
                    try {
                        // When there's one browser window and .close() implicitly calls .quit()
                        getFirefoxDriver().close();
                    } catch (Exception e) { e.printStackTrace(); }
                }
                chromeDriverThreadLocal.remove(); firefoxDriverThreadLocal.remove();
            }
        }
        ```

#
#### Reporting
- Reporting is generating documentation on if a test passed or failed and the logs that the user and machine generated during the test.

    #
    #### TestNG Reporting
    - Reporting is generated into the folder of your choosing by including this in the POM:
        ```
        <dependencies>
            <!-- https://mvnrepository.com/artifact/org.apache.maven.plugins/maven-compiler-plugin -->
            <dependency>
                <groupId>org.apache.maven.plugins</groupId>
                <artifactId>maven-compiler-plugin</artifactId>
                <version>3.8.1</version>
            </dependency>

            <!-- https://mvnrepository.com/artifact/org.apache.maven.plugins/maven-surefire-plugin -->
            <dependency>
                <groupId>org.apache.maven.plugins</groupId>
                <artifactId>maven-surefire-plugin</artifactId>
                <version>3.0.0-M3</version>
            </dependency>
        </dependencies>

        <build>
            <plugins>
                <plugin>
                    <groupId>org.apache.maven.plugins</groupId>
                    <artifactId>maven-compiler-plugin</artifactId>
                    <version>3.8.0</version>
                    <configuration>
                        <release>11</release>
                        <encoding>UTF-8</encoding>
                    </configuration>
                </plugin>
                <plugin>
                    <groupId>org.apache.maven.plugins</groupId>
                    <artifactId>maven-surefire-plugin</artifactId>
                    <version>3.0.0-M3</version>
                    <configuration>
                        <suiteXmlFiles>
                            <suiteXmlFile>testng-simpletest.xml</suiteXmlFile>
                        </suiteXmlFiles>
                        <argLine>
                            --illegal-access=permit
                        </argLine>
                    </configuration>
                </plugin>
            </plugins>
        </build>
        ```
  
    #
    #### Cucumber Reporting
    - Similar to the above.

    #
    #### Recording
    - Recording is creating a video/screenshot of the test at the moment it passes or fails.

        #
        #### Video
        - Video recording can be taken with the video-recorder-java library found here: https://github.com/SergeyPirogov/video-recorder-java

        #
        #### Screenshot
        - Take a screenshot with the following:
            ```
            @Step("Taking a screenshot.")
            @Attachment(value = "Page screenshot", type = "image/png")
            public byte[] saveScreenshot() {
                File file = ((TakesScreenshot)driver).getScreenshotAs(OutputType.FILE);
                byte[] bytes = new byte[(int) file.length()];

                try{
                    FileInputStream fis = new FileInputStream(file);
                    fis.read(bytes);
                    fis.close();
                } catch (Exception e) {
                }

                return bytes;
            }
            ```
        - A better version:
            ```
            import java.io.*;
            import java.util.*;
            import java.text.*;
            import org.apache.commons.io.FileUtils;

            public void takeScreenshot(String testName) {
                WebDriver augmentedDriver = new Augmenter().augment(driver);
                File screenshot = ((TakesScreenshot)augmentedDriver).
                    getScreenshotAs(OutputType.FILE);
                try {
                    DateFormat dateFormat = new SimpleDateFormat("yyyy-MM-dd.HH-mm-ss");
                    Date date = new Date();
                    FileUtils.copyFile(screenshot, new File("C:/selenium/" + testName + "-" +
                        dateFormat.format(date)
                        +".png"));
                    } catch(IOException e) {
                    System.out.println(e.getMessage());
                }
            }
            ```