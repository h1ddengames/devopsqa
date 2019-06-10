## Testing Types
- This document contains all information related to any questions that can be asked about all the various testing types that are required for most web applications. 
#

#### Manual Testing
- Manual Testing is a process in which you compare the behavior of a developed piece of code (software, module, API, feature, etc.) against the expected behavior (requirement document). This is done by hand by following a test case.

#
#### Automation Testing
- Automation testing is a Software testing technique to test and compare the actual outcome with the expected outcome. This can be achieved by writing test scripts or using any automation testing tool. Test automation is used to automate repetitive tasks and other testing tasks which are difficult to perform manually. 

#
#### Positive Testing
- Positive testing is the type of testing that can be performed on the system by providing the valid data as input. It checks whether an application behaves as expected with expected or positive inputs. This test is done to check the application that does what it is supposed to do.

#
#### Negative Testing 
- Negative Testing is a variant of testing that can be performed on the system by providing invalid data as input. It checks whether an application behaves as expected with the unexpected or negative inputs. This is to test the application does not do anything that it is not supposed to do so. 

#
#### Keyword Driven Testing
- A keyword-driven testing is a scripting technique that uses data files to contain the keywords related to the application being tested. These keywords describe the set of actions that is required to perform a specific step.

- In Keyword Driven Testing, you first identify a set of keywords and then associate an action (or function) related to these keywords. Here, every testing action like opening or closing of browser, mouse click, keystrokes, etc. is described by a keyword such as openbrowser, click, Typtext and so on. 

- Keyword Driven Testing is done for the following reasons:
    - Common components handled by standard library
    - Using this approach tests can be written in a more abstract manner
        - The detail of the script is hidden from the users
    - High degree of reusability
        - Avoids duplicated specifications
        - Better testing support and portability
        - Achieve more testing with less or same effort
    - Users don't have to use the scripting languages
    - The test is concise, maintainable and flexible

In order to create a Keyword driven framework, you need following things:
    - Excel Sheet - Identify the keywords and store them in an Excel sheet
    - Function Library - Function library consist of the function for the business flows ( login button for any website).So when test is executed, it will read the keyword from the Excel sheet and call the functions accordingly
    - Data Sheets - Data sheets is used to store the test data that will be used in the application
    - Object Repository - based on your keyword driven framework you can use an object repository
    - Test Scripts - Based on the design of your framework, you can have test scripts for each manual Test Case or a single driver script

- Steps to implement Keyword Driven Testing:
    1. Identifying low level as well as high-level keywords
    2. Implementing the keywords as executable
    3. Creating test cases
    4. Creating the driver scripts
    5. Executing the automation test scripts

#
#### Data Driven Driven Testing
- Data-driven is a test automation framework which stores test data in a table or spreadsheet format. 
    - This allows automation engineers to have a single test script which can execute tests for all the test data in the table.
- In this framework, input values are read from data files and are stored into a variable in test scripts. DDT (Data Driven testing) enables building both positive and negative test cases into a single test.
    - All of our test data is generated from some external files like Excel, CSV, XML or some database table.
- Frequently we have multiple data sets which we need to run the same tests on. To create an individual test for each data set is a lengthy and time-consuming process.
    - Data Driven Testing framework resolves this problem by keeping the data separate from Functional tests. The same test script can execute for different combinations of input test data and generate test results.

- Software required:
    - Apache POI - to read or write to an Excel spreadsheet. 
        - Note: Apache POI is in active development while Apache JXL is outdated.
        - Note: Apache POI has many more (and less restrictive) features compared to Apache JXL. 
         
- Steps to create a Data Driven Test: 
    1. Identify the test cases
        - Input Correct username and password – Login Success
        - Input incorrect username and correct password – Login Failure
        - Input correct username and incorrect password - Login Failure
    2. Create detailed test cases from the above step

        | Test Case # | Description | Test Steps | Test Data | Expected Results |
        |---|---|---|---|---|
        | 1           | Check for valid credentials | 1. Launch app 2. Enter username, 3. Click login, 4. Check results | Username: valid, password: valid | Login Success
    3. Create the test scripts
    4. Create an excel/csv with the input test data
        | Username  | Password  |
        | ---       | ---       |
        | valid     | valid     |
        | invalid   | valid     | 
        | valid     | invalid   |
    5. Modify the test scripts to loop over input test data. 

- Best practices:
    - It is ideal to use realistic information during the data-driven testing process.
    - Test positive as well as negative outcomes.

- Advantages of Data-Driven Testing:
    - Allows to test application with multiple sets of data values during Regression testing
    - Test data and verification data can be organized in just one file, and it is separate from the test case logic.
    - Some tools generate test data automatically. This is useful when large volumes of random test data are necessary, which helps to save the time.
    - The same test cases can be executed several times which helps to reduce test case and scripts.
    - Any changes in the test script do not effect the test data

- Disadvantages of Data-Driven Testing:
    - Data validation is a time-consuming task when testing large amount of data.
    - Maintenance is a big issue as large amount of coding needed for Data-Driven testing.
    - Quality of the test is depended on the automation skills of the Implementing team
    - High-level technical skills are required. A tester may have to learn an entirely new scripting language.

#
#### Behaviour Driven Testing
- Behaviour Driven Testing is an Agile software development process that encourages collaboration between developers, QA and non-technical or business participants in a software project.
- This communication is achieved through a language called Gherkin.
  - Gherkin uses a set of special keywords to give structure and meaning to executable specifications. 
  - Most lines in a Gherkin document start with one of the keywords:
    - Feature
    - Rule
    - Example (or Scenario)
    - Given
    - When
    - Then
    - And
    - But
    - Background
    - Scenario Outline (or Scenario Template)
    - Examples
  - Comment lines are allowed anywhere in the file. They begin with zero or more spaces, followed by a hash sign (#) and some text. Comments do have to start on a new line.
  - Example login.feature
    ```
    Feature: login to the system. User should be signed into the system when he provides valid username and password 
    Scenario: Successful login with Valid Credentials

    # The website is ...
    Given User is at the Home Page 
    And Navigate to Login Page 
    When User enters credentials 
    | username | password | 
    | testuser_1 | Test@123 | 
    And User login into a system 
    Then user is on the main profile page
    ```

- Once the feature file is created, each step needs to be defined into Step Definitions. All that really means is that you have to write the syntax that Cucumber expects:
  - Using the above example for this example:
    ```
    public LoginStepDefinition {
        Given("User is at the Home Page", () -> {
            driver.navigate().to("https://yourwebsitehere.com/");
        });

        And("Navigate to Login Page", () -> {
            WebElement loginButton = driver.findElementBy...
            loginButton.Click();
        })

        etc.
    }
    ```

- Finally create a runner class that will read the feature files then run the step definitions.
  - Example:
    ```
    import cucumber.api.CucumberOptions;
    
    @RunWith(Cucumber.class)
    @CucumberOptions(
        features = {
            "/path/to/your/login.feature",
            "/path/to/another/featureyouwanttorun.feature"
        },
        glue = {"your.package.containing.step.definitions"},
        plugin = {
            "pretty:target/cucumber-test-report/cucumber-pretty.txt",
			"html:target/cucumber-test-report/",
			"json:target/cucumber-test-report/cucumber-report.json",
			"junit:target/cucumber-test-report/test-report.xml"
        }
    )
    ```

#
#### Database Testing
- In Database testing we validate:
    - Exactly the same data that is in database is retrieved by web or desktop application (front-end applications).
    - The data which is inserted/modified from front-end application the same should be stored in the database.
    - In other words it is the integrity between the data on displayed on UI and the data in the Database.

- How does it work:
    - Usually the web application being tested will have UI that will update a table in a database. 
    - We use Selenium to automate the process of clicking and entering data into the UI.
    - Before we click on Submit or a UI with similar functionality, we run a SQL query that will check the contents of the database for the information we are about to add into it. 
    - Once we click on Submit or a UI element with similar functionality, we run a SQL query that will check the contents of the database for the information that should have been added to it.

- Required Skills: 
    - SQL (Structured Query Language)
        - Syntax
            - Statement Types
                - DML (Data Manipulation Language)
                    - SELECT - is used to retrieve data from the a database.
                    - INSERT - is used to insert data into a table.
                    - UPDATE - is used to update existing data within a table.
                    - DELETE - is used to delete records from a database table.
                - DDL (Data Definition Language)
                    - CREATE - is used to create the database or its objects (like table, index, function, views, store procedure and triggers).
                    - DROP - is used to delete objects from the database.
                    - ALTER - is used to alter the structure of the database.
                    - TRUNCATE - is used to remove all records from a table, including all spaces allocated for the records are removed.
                    - COMMENT - is used to add comments to the data dictionary.
                    - RENAME - is used to rename an object existing in the database.
                - DCL (Data Control Language)
                    - GRANT - gives user’s access privileges to database.
                    - REVOKE - withdraw user’s access privileges given by using the GRANT command.
                - TCL (Transaction Control Language)
                    - COMMIT - commits a Transaction.
                    - ROLLBACK - rollbacks a transaction in case of any error occurs.
                    - SAVEPOINT - sets a save point within a transaction.
                    - SET TRANSACTION - specify characteristics for the transaction.
            - Most used statements    
                - SELECT
                - FROM
                - WHERE
                - GROUP BY
                - HAVING
                - ORDER BY

    - Database Software
        - Relational
            - MySQL
            - MariaDB
            - PostgreSQL
        - Non-Relational/Distributed
            - MongoDB
            - Redis
    - Database Design
        - How to read a database schema -- the skeleton structure that represents the logical view of the entire database. 

#
#### API Testing
- API stands for Application Programming Interface. API acts as an interface between two software applications and allows the two software applications to communicate with each other. API is a collection of software functions which can be executed by another software program usually without GUI involved.

- REST stands for Representational State Transfer. It is an architectural style and an approach for communication used in the development of Web Services. It enables users to connect and interact with cloud services efficiently.

- API testing is a type of software testing that involves testing APIs directly and also as a part of integration testing to check whether the API meets expectations in terms of functionality, reliability, performance, and security of an application. In API Testing our main focus will be on a Business logic layer of the software architecture. API testing can be performed on any software system which contains multiple APIs. API testing won’t concentrate on look and feel of the application. API testing is entirely different from GUI Testing.

#
#### ETL testing 
- ETL testing is done to ensure that the data that has been loaded from a source to the destination after business transformation is accurate. 

- ETL means Extract Transform Load.
    - It is a process of how data is loaded from the source system to the data warehouse.  Data is extracted from an OLTP (On-line Transaction Processing) database, transformed to match the data warehouse schema and loaded into the data warehouse database.  Many data warehouses also incorporate data from non-OLTP systems such as text files, legacy systems and spreadsheets.  
        - OLTP is characterized by a large number of short on-line transactions (INSERT, UPDATE, DELETE). 
        - Example:
        ```
        You are building an online store/website, and you want to be able to :

            - store user data, passwords, previous transactions...
            - store actual products, their associated price

        You want to be able to find data for a particular user, change it's name... Basically perform INSERT, UPDATE, DELETE operations on a user data. Same with products, etc.

        You want to be able to make transactions, possibly involving a user buying a product (that's a relation). Then OLTP is probably a good fit.
        ```
    - Extract: Extract relevant data.
    - Transform: Transform data to DW (Data Warehouse) format
    - Load: Load data into DW (Data Warehouse)

- ETL testing is performed in five stages
    - Identifying data sources and requirements
    - Data acquisition
    - Implement business logics and dimensional modelling
    - Build and populate data
    - Build Reports

#
#### Black Box Testing
- Black box testing is functional testing, not based on any knowledge of internal
software design or code. Black box testing is based on requirements and functionality.

#
#### Grey Box Testing
- Gray Box Testing is a technique to test the software product or application with partial knowledge of the internal workings of an application.

#
#### White Box Testing
- White box testing is based on knowledge of the internal logic of an application’s
code. Tests are based on coverage of code statements, branches, paths and conditions.

#
#### Functional Testing
- Functional testing is a Black-box type testing geared to the functional requirements of an application. This type of testing ignores the internal parts and focuses only on the output to check if it is as per the requirement or not.

#
#### Unit Testing
- Unit Testing is the testing of an individual software component or module. Typically done by programmers, not testers because it requires detailed knowledge of the internal program design and code. 

#
#### Integration Testing
- Integrating testing checks the data flow from one module to other modules. This kind of testing is performed by testers.

#
#### Incremental Integration Testing
- Incremental Integration Testing is continuous testing of an application when a new functionality is added. Application functionality and modules should be independent enough to test separately.

#
#### System Testing
- System testing is a type of black box testing performed on a complete, integrated system. It is based on overall requirement specifications and covers all the combined parts of a system.  It tests the overall interaction of components which involves load, performance, reliability and security testing.

#
#### Acceptance Testing / UAT (User Acceptance Testing)
- An acceptance test is performed by the client and verifies whether the end to end the flow of the system is as per the business requirements or not and if it is as per the needs of the end user. Client accepts the software only when all the features and functionalities work as expected.

- It is the last phase of the testing, after which the software goes into production. This is also called User Acceptance Testing (UAT).

#
#### End-to-end Testing
- Similar to system testing, the macro end of the test scale is testing a complete
application in a situation that mimics real world use, such as interacting with a database,
using network communication, or interacting with other hardware, application, or system.

#
#### Sanity Testing
- Sanity Testing is done to determine if a new software version is performing well enough to accept it for a major testing effort or not.

#
#### Smoke Testing
- Smoke testing is performed whenever cursory testing is sufficient to prove the
application is functioning according to specifications. This level of testing is a subset of
regression testing.

#
#### Regression Testing
- Regression testing is to ensure that the software remains intact. Using a baseline set of data, scripts are executed to verify changes introduced during the release have not "undone" any previous code. 

#
#### Alpha Testing
- Alpha testing is testing of an application when developments is nearing completion.
Minor design changes can still be made as a result of alpha testing. Alpha testing is
typically performed by a group that is independent of the design team, but still within the
company, e.g. in-house software test engineers, or software QA engineers.

#
#### Beta Testing
- Beta testing is testing an application when development and testing are essentially
completed and final bugs and problems need to be found before the final release. Beta
testing is typically performed by end-users or others, not programmers, software
engineers, or test engineers.

#
#### Performance Testing
- Performance testing is described as a part of system testing, it can be
regarded as a distinct level of testing. Performance testing verifies loads, volumes and
response times, as defined by requirements.

#
#### Load Testing
- Load testing is testing an application under heavy loads, such as the testing of a web
site under a range of loads to determine at what point the system response time will
degrade or fail.

#
#### Installation Testing
- Installation testing is testing full, partial, upgrade, or install/uninstall processes. The
installation test for a release is conducted with the objective of demonstrating production
readiness.

#
#### Compatibility Testing
- Compatibility testing is testing how well software performs in a particular hardware,
software, operation system, or network.

#
#### Comparison Testing 
- Comparison testing is testing that compares software weaknesses and strengths to
those of competitors’ products.

#
#### Recovery Testing
- Recovery/error testing is testing how well a system recovers from crashes, hardware
failures, or other catastrophic problems.

#
#### Security Testing / Penetration Testing / Vulnerability Testing
- Security/penetration testing is testing how well the system is protected against
unauthorized internal or external access, or willful damage.

#
#### Parallel Testing / Audit Testing
- Parallel/audit testing is testing where the user reconciles the output of the new system
to the output of the current system to verify the new system performs the operations
correctly.

#
#### Ad-hoc Testing
- Ad-hoc testing is an informal way of finding defects and can be performed by anyone in the project. The objective of this testing is to find the defects and break the application by executing any flow of the application or any random functionality. The very term ad-hoc implies the lack of structure or something that is not methodical.

#
#### Usability Testing
- Usability testing is testing for ‘user-friendliness’. Clearly, this is subjective and
depends on the targeted end-user or customer. User interviews, surveys, video recording
of user sessions and other techniques can be used. Programmers and developers are
usually not appropriate as usability testers.