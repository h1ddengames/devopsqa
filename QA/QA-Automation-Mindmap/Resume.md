## Resume
- This document contains all information related to any questions that can be asked about your resume. 
#

#### Typical Day on the Job
- Typical day on the job includes the following:

    #
    #### Script Design
    - Combining tests where possible in order to avoid webdriver start up time:
        - Example: Combining login and cart functionality checking.
            - Assert/Verify statements will let us know what part of the test failed so it's ok to combine these two.
    - Using a RemoteWebDriver on another machine or using DesiredCapabilities in order to set the WebDriver to run in headless mode. 
    - Depending on use case, think of adding cross browser support/tests.

    #
    #### Framework Design
    - Utilizing an Object-Oriented design to make webdriver reuse possible for parallel testing.
    - Abstracting away the need for Selenium knowledge
        - Creating self explanatory methods/ method names with simple method signatures. 
    - Combining POM (Page Object Model) + BDD(T) (Behaviour Driven Development/Testing with Cucumber) and/or KDD(T) (Keyword Driven Development/Testing with Robot Framework) and/or DDT (Data Driven Testing with Apache POI/JXL, Excel, MySQL)

    #
    #### Example Projects
    <b>Note: With all of these projects, put them up on Github or Gitlab or Bitbucket in order to be able to share them with the hiring staff. </b>
    - Create an example project highlighting Keyword Driven Testing skills.
    - Create an example project highlighting Data Driven Testing skills.
    - Create an example project highlighting Behaviour Driven Testing skills.
    - Create an example project highlighting API testing skills.
    - Create an example project highlighting Database testing skills.
    - Create an example project highlighting Database testing skills.
    - Create an example project highlighting mastery of Selenium and TestNG where you test a well known website skills.
    - Go to a website like Hacker Rank or Leet Code and create a local project where you store the answers you've thought up to the given coding questions. 
  
    #
    #### First day/week/month on the job

    #
    #### Typical day on the job
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
    - Talk with my designated developer to brainstorm potential fixes to bugs. 

#
#### Documentation
- Documentation includes the following:

    #
    #### Requirements Document

    #
    #### Traceability Matrix

    #
    #### Feasibility Matrix

    #
    #### Responsibility Matrix

    #
    #### Test Plan

    #
    #### Test Schedule 

    #
    #### Test Case

    #
    #### Test Script

    #
    #### Risk Analysis

    #
    #### Database Schema

    #
    #### Class Diagram

#
#### QA Roles
- QA Roles include the following: 

    #### Junior Tester
    Executes test procedures prepared by seniors. Does mostly manual testing. Be able to report bugs into JIRA. 

    #### Senior Tester
    Prepares test plans. Aware of various metrics and testing techniques which help them communicate project health. Should be able to independently prepare test plans by looking at the requirement document.

    #### Test Engineer / QA Test Engineer / QA Tester 
    Specialized in testing. Creates test cases, procedures, scripts and generate data. Executes system/integration/regression testing. 

    #### QA Automation Test Engineer
    Does the tasks of Test Engineer / QA Test Engineer / QA Tester but also is able to create automation testing frameworks and test scripts.

    #### Project Manager Tester
    Collects accurate metrics and reports the same to the project manager of the project. Responsible for interacting with SQA (Software Quality Assurance - the process which assures that all software engineering processes, methods, activities, and work items are monitored and comply against the defined standards. These defined standards could be a combination of any like ISO 9000, CMMI model, ISO15504, etc.) to give updates about the quality of the project. Involved from the requirement phase onwards. 

    #### Team Lead Tester
    Mainly helps and guides senior testers. They are primarily involved in decision making of the test strategy, what kind of automation tools will be used. They act as the bridge between the project manager and other team members. 

    #### Software Development Engineer in Test (SDET)
    Creates automated testing frameworks, analyzes requirements, codes and runs automated test scripts, and reports defects. SDETs write code where as QA Engineers do not. Typically SDETs test APIs and databases. Responsible for setup and management of any continuous integration or continuous delivery tools. Works closely with DevOps.

    #### QA Lead/ Test Lead / QA Team Lead
    Determines test strategy and process, manages QA teams, prioritize QA tasks, creates status reports, tracks applicable test metrics, and manages test devices. Not only manages QA teams but interfaces with external teams while pitching in whenever and wherever they are needed to keep projects on track. Needs to be prepared to do manual testing and automated testing. 