# STLC - Software Testing Life Cycle In Depth

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

## Examples of how to figure out test cases

Start by going to http://spree.shiftedtech.com/

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
    1. Is the search bar able to find products when given a fully capitalized search critera: "T-SHIRT"
    2. Is the search bar able to handle an empty string in the search bar without crashing the application?
    3. Is the search bar able to handle escape characters properly in order to avoid SQL injection attacks?
    4. Is the search bar able to handle partial matches of search critera: "t-sh"
