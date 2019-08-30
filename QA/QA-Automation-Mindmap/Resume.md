# Resume

- This document contains all information related to any questions that can be asked about your resume.

***

## Typical Day on the Job

- Typical day on the job includes the following:

***

## Script Design

- Combining tests where possible in order to avoid webdriver start up time:
  - Example: Combining login and cart functionality checking.
    - Assert/Verify statements will let us know what part of the test failed so it's ok to combine these two.
- Using a RemoteWebDriver on another machine or using DesiredCapabilities in order to set the WebDriver to run in headless mode.
- Depending on use case, think of adding cross browser support/tests.

***

## Framework Design

- Utilizing an Object-Oriented design to make webdriver reuse possible for parallel testing.
- Abstracting away the need for Selenium knowledge
  - Creating self explanatory methods/ method names with simple method signatures.
- Combining POM (Page Object Model) + BDD(T) (Behaviour Driven Development/Testing with Cucumber) and/or KDD(T) (Keyword Driven Development/Testing with Robot Framework) and/or DDT (Data Driven Testing with Apache POI/JXL, Excel, MySQL)

## Example Projects

- Create an example project highlighting Keyword Driven Testing skills.
- Create an example project highlighting Data Driven Testing skills.
- Create an example project highlighting Behavior Driven Testing skills.
- Create an example project highlighting API testing skills.
- Create an example project highlighting Database testing skills.
- Create an example project highlighting Database testing skills.
- Create an example project highlighting mastery of Selenium and TestNG where you test a well known website skills.
- Go to a website like Hacker Rank or Leet Code and create a local project where you store the answers you've thought up to the given coding questions.

***

## First day/week/month on the job

## Typical day on the job

- Making a test plan with the help of the more senior members of my team.
- Making test cases
  - Creating scripts out of the test cases.
  - Updating/removing unused tests.
  - Updating/removing broken tests.
- Bug reporting
  - When tests fail, report when and what test failed.
  - Update status of features on JIRA after getting test results from finished tests.
- Updating our core automation framework that's used throughout our testing scripts.
  - Updating our POM repository.
  - Adding new feature files for our BDD framework.
- Talk with my designated developer to brainstorm potential causes for bugs.

***

## Documentation

- Documentation is material that provides official information or evidence or serves as a record.
- Here are some examples of where documentation is critical to software testing:
  - When a client contracts a company this contract is in fact documentation that states the requirements, terms and conditions between the client and the company.
    - Without a contract a client might get angry and sue the company because the company had not provided functionality that the client thought they were paying for. In reality, the company would have no idea what the requirements are since there was no documentation on what was expected and what needed to be delivered.
  - Documentation can serve as a standard or guideline for common tasks carried out within a company.
    - You are tasked with creating test scripts.
      - Without documentation you would have to look through the entirety of the test scripts created by the company you work for in order to figure out what new tests must be created and what unused/unnecessary tests/scripts need to be updated.
        - Additionally all the scripts made by other people will all be very different from one another since no standards were set by the company in the form of documentation.
      - With documentation, you would know what scripts were implemented, which ones needed updating/removal and what guidelines/standards to follow when creating tests/scripts of your own.
  - Documentation can make or break a project.
    - Testing should be fully documented in order to provide efficient resource control, monitoring, and allocation.
      - Referring back to the previous example about being tasked with creating test scripts:
        - If everyone on the QA team did the same thing as you where they look through all the current scripts for tests then try to create new ones or update old ones, every once in a while two or more people will generate the same test.
          - Now your code base contains the same test which wastes development time for creating the test and test time for when you run all the tests.
            - This is a loss of both resource control and resource allocation. 
        - Since no one has documented which scripts were created, what they are used for, and what they contain there is no resource monitoring over the QA code base.

***

## Requirements Document

***

## Traceability Matrix

- Traceability Matrix can also be called Requirement Traceability Matrix (RTM) and it captures all requirements proposed by the client or software development team and their traceability in a single document delivered at the conclusion of the Software Development Life Cycle.

## Feasibility Matrix

## Responsibility Matrix

## Test Plan

- Test Plan is a document that describes the scope, approach, objectives, resources, and schedule of a software testing effort.
- It is the document that outlines the who, what, when, and how of a testing project.
- The first thing that should be done during the testing process.
- The plan is broken down into manageable pieces and serves as a record of the testing objectives.
  - Just like how software engineers break down a problem into simple steps then write comments, each step of the test process is outlined in the documentation.
- The value in a test plan comes from the following:
  - The test plan acts as a quick guide for testing process
  - It helps avoid testing of "out of scope" functionality
    - Limiting the scope means more focus on the parts that matter the most.
    - Additionally, not having clear objectives will make it uncertain when the test process ends or what needs to be tested.
  - Determining the time, cost, and effort that will be required to test the functionality of any given software.
    - Without knowing how long the testing effort is going to take or the total cost, projects can get delayed or cancelled.
  - Defining roles and responsibilities for testers.
    - Helps avoid having multiple people working on the same tests.
  - Provides a schedule for testing activities.
  - Outlines the resource requirements and equipment
  - Is a source of proof should you need it in the future.
- An important note: update your test plan as you make changes to it.
- There are three types of test plans:
  - Master test plan: a single high-level test plan for a project/product that unifies all other test plans
  - Level specific test plan: intermediate plans specifically related to a level of software testing
  - Type specific test plan: plans for major types of testing like performance testing plan and security test plan
- In order to create a test plan there are 6 steps:
  - Analyze the product
    - Understand the features and functionality as well as the business requirements of the product.
    - Understand the use cases and evaluate the product from the user's point of view.
    - Who was the product made for?
    - How will this product work?
    - What is this product for?
    - Interview the client, designer, developer.
    - Perform a product walkthrough:
      - Try out the product as if you are the end user and see if it satisfies the requirements.
  - Develop test strategy
    - Define the project/product's testing objectives, scope, and the means to achieve them.
    - Determine testing effort and costs.
    - Depending on the requirements of the product you'll need to adjust the testing type (Identify the testing type):
      - If there will be thousands of users, perform load testing.
      - If there are online transactions, perform penetration and security testing.
    - Document the risks and issues.
    - Create the test logistics.
  - Define test objectives
    - Define the scope
      - List the features that needs to be tested.
      - List the features that are NOT to be tested.
      - Define the goal based on above features.
  - Resource planning
    - This is a detailed summary of all types of resources required to complete project task.
      - Different software and hardware requirements (server, computers, network, test tools)
      - Employee requirement (test manager, testers, developers, test admin, etc)
  - Schedule and estimation
    - Define the roles and responsibilities of the testing team along with a schedule that tells everyone what to do and when to do it.
    - There are components to break the above task down into such as the following:
      - Tasks
      - Members responsible for tasks
      - Estimated effort
      - Employee and project deadline
      - Project estimation
      - Possible project risks
  - Determine test deliverables
    - A list of all the documents, tools, and other components that has to be developed and maintained in support of the testing effort.
    - Separate out the deliverables into these parts:
      - Before testing
        - Test plan documents
        - Test cases documents
        - Test design specifications
      - During testing
        - Test scripts
        - Simulators
        - Test data
        - Test matrix
        - Error logs
        - Execution logs
      - After testing
        - Test results
        - Defects report
        - Release notes
    - The standard for test plan documentation:
  
        | Parameter                 | Description  |
        | ---                       | ---       |
        | Test Plan Identifier      | Uniquely identifies the test plan and may include the version number     |
        | Introduction              | Sets objectives, scope, goals, resource, and budget constraints     |
        | Test Items                | Lists the systems and subsystems which can be tested   |
        | Features to be tested     | All the feature and functionality to be tested are listed here |
        | Features not to be tested | Lists the characteristics of products that need not be tested |
        | Approach                  |  Has sources of test data, inputs and outputs, testing priorities |
        | Item pass/fail            | Describes a success criteria for evaluating the test results |
        | Suspension Criteria       | Has criteria that may result in suspending testing activities |
        | Test Deliverables | Includes test cases, simple data, test report, issue log |
        | Testing Tasks | Describes dependencies between tasks and resources needed |
        | Environmental Needs | Lists software, hardware or other testing requirements |
        | Responsibilities | Lists roles and responsibilities assigned to the testing team |
        | Staffing Needs | Describes the additional training needs for the staff |
        | Schedule | Details on when the testing activities will take place are listed |
        | Risks | Lists overall risk of the project as it pertains to testing |
        | Approvals | Contains signature of approval from stakeholders |

***

## Test Case

- Test Case is a set of actions executed to verify a particular feature or functionality of your software application. The Test Case has a set test data, precondition, certain expected and actual results developed for specific test scenario to verify any requirement.

- A test case includes specific variables or conditions, using which a test engineer can determine as to whether a software product is functioning as per the requirements of the client or the customer.

***

## Test Scenario

- Test Scenario is defined as any functionality that can be tested. It is a collective set of test cases which helps the testing team to determine the positive and negative characteristics of the project.

- Test Scenario gives a high-level idea of what we need to test.
- Defines which area of the application will be tested.

***

## Test Schedule

***

## Test Script

***

## Risk Analysis

***

## Database Schema

***

## Class Diagram

***

## QA Roles

## Junior Tester

    Executes test procedures prepared by seniors. Does mostly manual testing. Be able to report bugs into JIRA.

## Senior Tester

    Prepares test plans. Aware of various metrics and testing techniques which help them communicate project health. Should be able to independently prepare test plans by looking at the requirement document.

## Test Engineer / QA Test Engineer / QA Tester

    Specialized in testing. Creates test cases, procedures, scripts and generate data. Executes system/integration/regression testing. 

## QA Automation Test Engineer

    Does the tasks of Test Engineer / QA Test Engineer / QA Tester but also is able to create automation testing frameworks and test scripts.

## Project Manager Tester

    Collects accurate metrics and reports the same to the project manager of the project. Responsible for interacting with SQA (Software Quality Assurance - the process which assures that all software engineering processes, methods, activities, and work items are monitored and comply against the defined standards. These defined standards could be a combination of any like ISO 9000, CMMI model, ISO15504, etc.) to give updates about the quality of the project. Involved from the requirement phase onwards. 

## Team Lead Tester

    Mainly helps and guides senior testers. They are primarily involved in decision making of the test strategy, what kind of automation tools will be used. They act as the bridge between the project manager and other team members. 

## Software Development Engineer in Test (SDET)

    Creates automated testing frameworks, analyzes requirements, codes and runs automated test scripts, and reports defects. SDETs write code where as QA Engineers do not. Typically SDETs test APIs and databases. Responsible for setup and management of any continuous integration or continuous delivery tools. Works closely with DevOps.

## QA Lead/ Test Lead / QA Team Lead

    Determines test strategy and process, manages QA teams, prioritize QA tasks, creates status reports, tracks applicable test metrics, and manages test devices. Not only manages QA teams but interfaces with external teams while pitching in whenever and wherever they are needed to keep projects on track. Needs to be prepared to do manual testing and automated testing.
