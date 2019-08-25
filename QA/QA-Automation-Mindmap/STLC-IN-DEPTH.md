# STLC - Software Testing Life Cycle In Depth

## Software Testing Life Cycle

- Software Testing Life Cycle is the process of executing a program or application with the intent of finding software bugs. It can also be defined as the process of validating and verifying that software program or application or product meets the business and technical requirements that guided it's design and development.
- To paraphrase the above: "software testing is a process to verify that application is working as per user requirements."
- Software Testing is usually associated with the terms verification and validation.
  - Validation - Are we doing the right job?
    - Validation is the process of checking that what has been specified is what the user actually wanted.
  - Verification - Are we doing the job right?
    - Verification is checking or testing of items, including software, for conformance and consistency with an associated specification.
  - Validation is done on software while verification is done on the specification.

1. Requirement Analysis
    1. Documents involved:
        1. Requirements Specification Documents
        2. Functional Specification Documents - How does the particular software works
        3. Design Specification Documents (use cases, etc) - How will the particular software be built
        4. Use Case Documents - How will the customer use the software
        5. Test Traceability Matrix for identifying Test Coverage - How many tests are being run for each particular feature/requirement.
2. Test Planning - Plan out the testing process
    1. Documents involved:
        1. Test Plan - What needs to be tested, when does it need to be tested, how will it be tested? In an agile/scrum environment there is no separate test plan document created. The scrum board will be the test plan. In a waterfall, v-shaped, iterative, or spiral model of software development, there will be a Test Plan Document created during this phase.
        2. Test Scenario
    2. Terms:
        1. Test Scope - In scope (features that must be tested), out of scope (features that we are not worried about currently)
        2. Test Environment - Production environment (prod) - what the customer experiences, QA Environment - will be as similar to the production environment as possible, Development Environment (dev) - Should be as close to production as possible but might have a different setup in order to make it easier for the developer to develop the software.
            1. Code Freeze - Some places don't have more than 2 environments (prod and dev) so they will implement a code freeze where on a certain day, there will be no new code added to the code base by the developers. The QA will now be able to test on the dev environment. Make sure to record the version of the software being tested, when it was tested, and what bugs were found.
        3. Test Methodologies
        4. Manual and Automation Testing
        5. Defect Management
        6. Configuration Management
        7. Risk Management
3. Test Development
    1. Documents involved:
        1. Test Plan
        2. RTM
        3. Test Cases
    2. Terms:
        1. Test Traceability Matrix and Test Coverage
        2. Test Scenarios Identification and Test Case preparation
        3. Test data and test script preparation
        4. Test case reviews and approval
        5. Base lining under configuration management
4. Test Execution
    1. Documents involved:
        1. Test Cases
        2. Test Execution report
        3. Bug report
        4. Requirement traceability matrix
5. Defect Reporting
    1. Documents involved:
        1. Test report
        2. Bug report
    2. Terms:
        1. Defect logging - using specialized software (Jira) record a description of the bug with steps to reproduce it, the software version, and other relevant data.
        2. Assigning defect and fixing - A defect must be assigned to a developer in order to have it fixed. The developer can decide if it is a bug, if they can fix it, and when it will be fixed. Sometimes the bug will be assigned to the project manager or test lead and they will be the ones to reassign the bug to a developer.
        3. Retesting - Once a bug has been marked as fixed or "closed" in the defect tracking software (Jira), you will have to retest using the conditions documented in the bug report.
        4. Defect closing
6. Retest defects
7. Product Delivery - After the software has undergone several tests, the acceptance test is done by the user/client.
    1. Documents involved:
        1. Test summary reports
        2. Test metrics - measuring the correctness of the testing process:
            1. Project Related Metrics
            2. Test size
            3. Number of test cases run per day - Automated (NTTA)
            4. Number of test cases run per day - Manual (NTTM)
            5. Number of test cases created per day - Manual (TCED)
            6. Total number of review defects (RD)
            7. Total number of testing defects (TD)
            8. Process Related Metrics
            9. Schedule Adherence (SA)
            10. Effort Variance (EV)
            11. Schedule Slippage (SS)
            12. Test cases and scripts rework effort
            13. Customer Related Metrics
            14. Percentage of defects leaked per release (PDLRP)
            15. Percentage of automation per release (PAPR)
            16. Application Stability Index (ASI)
        3. UAT Test Plan, UAT Test cases

## 7 Principles of Software Testing

1. Exhaustive testing is not possible.
2. Defect clustering - most of the bugs found will be concentrated into one or two modules withing the whole system.
3. Pesticide paradox - test cases will kill bugs like pesticide does but too many test cases will cause problems much like too much pesticide use. Use as much testing as needed to make sure the product has good quality but not so much that it harms the development and use of the product.
4. Testing shows presence of defects.
5. Absence of error - be cautious when finding out there are little to no bugs in some software. This could mean that the tests were conducting using the wrong requirements  
6. Early testing - the cost involved in fixing defects found in the later stages of SDLC (Software Development Life Cycle) will be more costly than finding it and fixing it earlier.
7. Testing is context dependent - there are many different domains such as: banking, insurance, medical, travel, etc. Different domains must be tested differently since they all have different requirements, functions, risks, and techniques.

## Software Testing Fundamentals

- The goal of software testing is to find bugs as early as possible and to make sure they stay fixed.
- Testing early saves money and reduces errors because once a feature becomes a core part of the software, it becomes harder to debug it.
- Testing is a process of executing a program with the intent of finding an error.
- A good test case is one that has a high probability of finding an undiscovered error.
- A successful test case is on that uncovers an undiscovered error.
- If a bug is found by the tester, it is the fault of the developer.
- If a bug is found by the customer, it is the fault of QA.
- The biggest cause of bugs is from the specification with the design coming in close second.
- Testing should stop once any of the following criteria are met:
  - Deadline has been met.
  - Once test cases are passing with a certain percentage passed.
  - Test budget has been depleted.
  - Coverage of code/functionality/requirements have reached a specified point.
  - Alpha or Beta testing period ends.
    - Alpha testing is conducted by the QA team.
    - Beta testing is conducted by the customers.
  - The risk in the project is under acceptable limit.
- Test execution includes the following:
  - Unit testing - testing individual parts of the software from as small as methods to as large as a single component. Usually done by the developer.
  - Integration testing - testing that multiple parts of the software are able to work as intended.
  - System testing - testing that is conducted when software development is nearing completion and most of the features have been implemented. Testing is done to verify that the system complies with the specified requirements.
  - Acceptance testing - testing is done by the client/customer where they decide if the software complies with the business requirements.

## Required Document Examples

- A traceability matrix is used to track the requirements and to check that the current project requirements are met. Usually one business requirement will generate multiple test cases but for this example, a single test case will satisfy multiple business requirements.
  - Example:
    | Business Requirement | Technical Requirement # | Test Case ID |
    |----------------------|-------------------------|--------------|
    | B1                   | T94                     | 1            |
    | B2                   | T95                     | 3            |
    | B3                   | T96                     | 3            |
    | B4                   | T97                     | 4            |

- A business requirement specification (or BRD - Business Requirement Document) explains how the application should behave.
  - Example:
    | Business Requirement # | Module Name      | Applicable Roles | Description                                                                                                                                                                   |
    |------------------------|------------------|------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
    | B1                     | Login and Logout | Manager Customer | Customer: A customer can login using the login page. Manager: A manager can login using the login page. Post login homepage will show different links based on role.          |
    | B2                     | Enquiry          | Manager Customer | Customer: A customer can have multiple bank accounts. They can view only their own balance. Manager: A manager can view the balance of all customers under their supervision. |
    | B3                     | Fund Transfer    | Manager Customer | Customer: A customer can have transfer funds from their own account to any destination account. Manager: A manager can transfer funds from any account to any other account.  |

- Test cases give a test case number, a name or description, the steps that need to be followed, the data that will be used, and the expected result of the test.
  - Example:

    | Test Case # | Test Case    | Test Steps                                                           | Test Data            | Expected Results |
    |-------------|--------------|----------------------------------------------------------------------|----------------------|------------------|
    | 1           | Verify Login | 1. Go to Login Page 2. Enter UserID 3. Enter Password 4. Click Login | id=johndoe pass=1234 | Login Successful |

- Technical requirement document (or TRD)
  - Example:

    | Test Requirement # | Description                              |
    |--------------------|------------------------------------------|
    | T92                | UserID must not be blank.               |
    | T93                | Password must not be blank.              |
    | T94                | If UserID and password are valid, login. |

- Combining BRD + TRD within a test case:
  - Example:

    | Test Case # | Business Requirement # | Technical Requirement # | Test Case    | Test Steps                                                           | Test Data            | Expected Results |
    |-------------|------------------------|-------------------------|--------------|----------------------------------------------------------------------|----------------------|------------------|
    | 1           | B1                     | T94                     | Verify Login | 1. Go to Login Page 2. Enter UserID 3. Enter Password 4. Click Login | id=johndoe pass=1234 | Login Successful |

## Tasks required for STLC

- Creating test cases from test scenarios.
- Test case reviews.
- Generating test data and preparing test scripts.
- Creating a test plan through the Jira scrum board.
- Execute test scripts.
- Creating defect/bug reports in Jira.
  - Make sure bugs are reproducible and give proper steps to reproduce the bug for the developer to see.

## Test Plan in Agile/Scrum

- In Agile, most of the requirements are not given at the beginning of the project. Instead, the requirements will be added during sprints.
- Even without having all the requirements listed out, the software still needs to be built.
- It is very difficult to generate a plan when new requirements will be added to it at unknown times.
- In the waterfall model of software development and testing, you might have a separate test plan document but in an agile/scrum workflow, the scrum board will be for the most part the test plan itself.
- The test plan will not be a through overview of what to expect but rather it identifies risks and assumptions to reduce surprises later.
- The test plan will communicate objectives to all team members.

## Test coverage

- Not every requirement can be tested. Test coverage is a measure of how many testable requirements you were able to cover with your test.
- For example:
  - Let's say you have 20 requirements to test.
  - Not all 20 of them will be testable.
  - You need to find out which requirements are testable.

## Risk Analysis

- A risk is a potential for loss or damage to an Organization from materialized threats.
- Risk analysis attempts to identify all the risks and severity of the risks.
- Usually done by the product owner.
- Risks can be divided into the following:
  - Software risks
    - Most common risks associated with Software Development on the platform you are working on.
  - Business risks
    - Most common risks associated with the business using the Software.
  - Testing risks
    - Most common risks associated with Software Testing for the platform being worked on, the tools being used, and test methods being applied.
  - Premature release risk
    - Most common risks associated with releasing unsatisfactory or untested Software Products.

## Skills Required for Testers

- Soft Skills (Non-Technical Attributes)
  - Disciple and Perseverance
    - Testing is repetitive
      - Have to withstand the pressure and workload
      - Be able to say "no" when quality is insufficient
    - Reading Skills
      - Be able to study many documents and specifications
    - Communication and Interpreter Skills
      - Both verbal and written communication
      - Diplomatic skill (sensitive in dealing with others)
      - Be able to communicate with technical and non-technical people.
    - Attitude
      - Have a test to break attitude
      - Negative thinking
        - Be able to foresee that things can and usually do go wrong, evaluate and manage risks.
    - Time Management and Effort Prioritization

## Error, Bug, Fault, Failure

- Error - an error is a human action that produces the incorrect result that results in a fault.
- Bug - the presence of error at the time of execution of the software.
- Fault - the state of the software that an error causes.
- Failure - deviation of the software from its expected result. This is an event.

1. Error
2. Fault
3. Bug
4. Failure
5. Defect

## Bug Life Cycle

1. New defect has been found and reported.
   1. Defect can be marked as invalid (cannot reproduce bug)
   2. Defect can be marked as designed (it's not a bug, it's a feature)
   3. Defect can be marked as deferred (will be handled in a later version)
   4. Defect can be marked as duplicate (same bug as another bug that's already been reported)
2. If the defect is valid, it will be assigned to a developer to fix.
3. Once the defect has been marked as fixed, it needs to undergo retesting.
4. If the defect is still found, it gets reopened and reassigned to a developer.
5. If the defect is no longer found, then the defect is closed.
6. If the same defect is found again, the the defect is reopened and goes through these same steps again.

## Bug Status

1. New - The bug has just been reported by the qa team.
2. Open - The bug will now be considered by the dev team.
3. Assigned - The bug has been assigned to a developer to fix.
4. Test - The software is currently being tested to check for the existence of the bug.
5. Verified - The bug has been properly tested and it is no longer in the software.
6. Deferred - The bug will be fixed in a later version of the software.
7. Reopened - The bug reappeared even after it was marked as fixed before.
8. Duplicate - The bug has been reported before.
9. Rejected - The bug isn't reproducible or isn't thought of as a bug.
10. Closed - The bug has been fixed.

## Bug Priority

1. Critical - This type of bug prevents further testing of the product.
    - Example: A missing menu option or security permission required to access a function.
2. Major/High - This type of bug causes other functionality to fail to meet requirements.
    - Example: The wrong field is being updated.
3. Average/Medium - This type of bug does not follow a standard or convention.
    - Example: Matching visual and text links which lead to different end points.
4. Minor/Low - This type of bug is one that does not affect the functionality of the system. (Purely cosmetic)

## Test Scenario vs Test Case

- A test case is a set of test data and test programs (test scripts) and their expected results.
- A test case validates one or more system requirements and generates a pass or fail output.
- A test case contains the following elements:
  - Pre-conditions (prerequisites)
  - Steps to execute
  - Test data
  - Expected behavior
  - Pass/Fail criteria
- A test scenario is a business requirement to be tested.
- A test scenario contains a set of test cases that ensure that the business process flow are being tested.
- A test scenario can be derived from BRS/SRS/Use case document where functionality of the application is described in a broader sense.
- While a test case is concerned with a single functionality, a test scenario is concerned with end to end transaction with a business point of view.

## Creating test cases from requirement analysis

- Let's say that we have some software that records students grades where the values can be between 0 and 100. How many test cases can you think of?
    1. Positive test cases + boundary value analysis
       1. Test with a value of 0.
       2. Test with a value of 1.
       3. Test with a value of 99.
       4. Test with a value of 100.
    2. Negative test cases + boundary value analysis
       1. Test with a value of -1.
       2. Test with a value of 101.
    3. Negative test cases
       1. Test with letters of the alphabet "abc"
       2. Test with letters of another language such as korean.
       3. Test with a mix of letters and numbers "13abc"
       4. Test with a mix of letters and number "bc35"
       5. Test with special characters "$#@!%^"
       6. Test with special characters "3#"
       7. Test with special characters "%42"
       8. Test with float values with one place after the decimal "50.5"
       9. Test with float values with two places after the decimal "32.17"

- If you have limited time to test then negative test cases are worth the time to think of and implement because of the following example:
  - Say for example that you are in charge of testing a e-commerce application. You login and add products to cart and go to buy the items while providing invalid credit card information. The application allows you to buy the item and updates the database to ship you the item. This would make the company lose money in shipping and giving you the product without getting money equal to the set cost of the product.
  - The above negative test passing would bankrupt the company if every person was able to follow the same steps and get products for free.
  - Think of the opposite positive test of logging in, adding products to cart, going to buy the items and giving a valid credit card information. If the test passes, great! The company gets money for the bought product. Even if the test fails, it's not as bad as the negative test case passing because if a user can't buy the product then the company doesn't make money but at the very least it doesn't LOSE money.

## Writing good test cases

- Write test cases such that only one thing is being tested at a time.
- Ensure that you are testing both positive and negative scenarios.
  - Example:
    - Positive test case - Login feature where your login is successful.
    - Negative test case - Login feature where you use incorrect username and are unsuccessful in logging in.
  - Write in simple and easy to understand language.
  - Use an active voice such as "do this" or "do that"
  - Use exact and consistent names (of forms, fields, etc)
  - Be accurate with what the purpose of the test is.
  - Be economical with your words. Do not include unnecessary steps or words.
  - Make sure that you are able to trace the test case to the requirement it was created from.
  - Make sure the test can be repeated over and over again.
  - Make the test case as reusable as possible.
  - Make sure others can understand your test cases because you will not always be the one implementing or running the test cases.
  - Test cases are derived from test scenarios. Test scenarios are derived from use cases.
    - Examples:
      - Use case: User logs into the web application using a username and password.
      - Test Scenario: Validate the login page.
        - Test case 1: Enter a valid username and password.
        - Test case 2: Reset your password.
        - Test case 3: Enter invalid credentials.
  - Creating test cases from use cases
    - Examples:
      - The "normal" basic flow of your application would be the "happy path"
        - You go to amazon, sign in, shop for a tie, add tie to cart, go to cart and buy.
      - There are several alternate flows that may happen. Checking these alternate flows usually find bugs.
        - You go to amazon, and try to sign in but you are greeted by an error page with no way back.
        - You go to amazon, and sign in but are unable to add anything to your cart.
      - Try to do things in an our of order way
        - You go to amazon but you look for a tie first, then add it to your cart then you sign in and buy.
        - You go to amazon but you go to your cart then you sign in then you look for a tie.

## Examples of how to figure out test cases

- Think about anything that could possibly go wrong.
- There should usually be a single positive case and multiple negative cases being tested.
- Doing the wrong things will produce the correct errors.

Start by going to <http://spree.shiftedtech.com/>

1. Check that there are no broken images on the home page.
2. Check that all the navigation buttons take you to their intended pages.
3. Check that you are able to click on either the image or the name to visit the product description for any given product.
4. Check that the image of the product is displayed on the product description page and that it is the CORRECT image.
5. Check that hovering the mouse over the thumbnails under the main image of the product changes the main image to the thumbnail's image.
6. Some products might not have thumbnails showing different images of the same product so you will have to check for the existence of extra images.
7. Check that the title of the product is listed next to the image on the product description page.
8. Check that the price is the same as what was shown on the home page.
9. Check that the description of the product is correct.
10. Check the properties of the product matches what is listed on the product description page.
11. Check that you are able to add the product to the shopping cart.
12. Go back to the product page and try adding it to the cart again.
13. Check that the cart now displays that you are trying to buy 2 of the same product.
14. Check that the total in the cart displays an updated total.
15. When you select Mugs under Shop By Categories, you expect to see only mugs.
    1. Query your database for the amount of mugs that the database contains.
    2. Check that the amount from the query is the amount found on the GUI of your application.
16. Select the following price ranges: $10-$15 AND $15-$18.
    1. Query your database for the amount of mugs that fit this price range.
    2. Check that the amount from the query is the amount found on the GUI of your application.
17. Check that the search bar returns proper results.
    1. Is the search bar able to find products when given a fully capitalized search criteria: "T-SHIRT"
    2. Is the search bar able to handle an empty string in the search bar without crashing the application?
    3. Is the search bar able to handle escape characters properly in order to avoid SQL injection attacks?
    4. Is the search bar able to handle partial matches of search criteria: "t-sh"
18. Try to create a new account.
    1. Check that a taken email cannot be used.
    2. Check that a email that is not taken can be used.
    3. Check that you can create an account without using an email.
    4. Check that the password contains more than 6 characters.
    5. Check that the password does not contain CERTAIN special characters as decided by the password acceptance criteria.
    6. Check that you cannot create a new account if your password and password confirmation is different.
