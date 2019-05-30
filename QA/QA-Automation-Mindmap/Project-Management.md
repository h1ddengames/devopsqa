## Project Management
- This document contains all information related to any questions that can be asked about project management.
#

#### Agile Methodology/Manifesto
- Agile Methodology/Manifesto is a set of core values and beliefs that can be applied towards software development. In this manifesto we need to value the elements in the column on the left rather than the right:
    | Left                          | Right                         |
    | -----                         | -----                         |
    | Individual and interactions   | Processes and tools           |
    | Working software              | Comprehensive documentation   |
    | Customer collaboration        | Contract negotiation          |
    | Responding to change          | Following a plan              |

- To reiterate: while the contents of the entire table are important, we should value the elements on the left more.

- How we achieve these goals are left to the methods below:

    #
    #### Scrum
    - Scrum is an implementation of Agile. It is a simple framework for effective team collaboration on complex products. 
    - Scrum replaces a programmed algorithmic approach with a heuristic one, with respect for people and self-organization to deal with unpredictability and solving complex problems.

        #
        #### Product Backlog
        - The product backlog is a list of requirements that the customer or product owner gives to the developers.

        #
        #### Sprints
        - Sprints are an allocated time to complete several items from the product backlog based on team size and a concensus on the duration of the allocated time (usually 2 weeks). 
        - Before a sprint starts, there is a sprint planning phase where the developers choose tasks based on a priority system.
        - At the end of this sprint planning phase, a sprint backlog is created. This is essentially a list of all the tasks that need to be completed before the sprint is finished.
        - Once the sprint has finished, there is a meeting called a sprint review where usually the product is demoed to the product owner or customer.
        - Finally a sprint retrospective is done to help the team members understand what processes went well and what needs to be worked on for the following sprint.

        #
        #### Standups
        - Standups are a way for effective communication between team members.
        - Everyday for about 15 minutes, the team gathers together and explains what's been accomplished and what the team needs to wait for in order to continue finishing the items on the sprint backlog.

    #
    #### Kanban
    - Kanban is a workflow management method designed to help you visualize your work, maximize efficiency and be agile.
    - There is a board where tasks are divided based on completion. 
        - The number of tasks are based on the amount of developers/testers
        - The number of divisions will be based on the team and what tasks they have to do but in general this is what the board looks like:

    | To-Do     | Development   | Test    | Done    |
    | --        | --            | --      | --      |
    | Task 7    | Task 5        | Task 3  | Task 1  |
    | Task 8    | Task 6        | Task 4  | Task 2  |
    
    - Whenever a task has finished within each column, it will wait until the column on the right has an available space.
        - For example: Once task 5 is done, it must wait until task 3 has moved from Test to Done then it may be moved into the Test column. Then everything to the right of it moves over one column. 

    - This system doesn't have sprints like Scrum does but is instead a continuous pace that is kept through the lifecycle of a product.

    #
    #### Gantt Chart
    - Gantt Chart is a visual representation of a project schedule which shows all the tasks as well as dependencies.

    #
    #### Burndown Chart
    - Burndown Chart is a graph that helps track the relationship between the remaining days of a sprint and the number of hours.
  
#
#### SDLC - Software Development Life Cycle
- There are 7 key points:
    1. Planning
    2. Requirements Analysis
    3. Design
    4. Implementation / Programming
    5. Testing
    6. Deployment
    7. Maintainence

OR 
- It can also look like this:
    1. Requirements Phase
    2. Analysis Phase
    3. Design Phase
    4. Development Phase
    5. Testing Phase
    6. Deployment and Maintainence Phase

- At each point in the process, there are deliverables that will be outlined below:

- <b> Planning Phase Starts </b>
    - The customer has a product idea and money so they talk to various software development companies.
    - Once a company has been chosen, the product owner (project manager) talks with the customer to come to a deal. A contract is then created and signed.
    - The customer and product owner defines the application.
      - Example:
        1. User Registration
        2. Login
        3. Logout
        4. Dashboard Landing Page
- <b> Planning Phase Ends. A Business Requirement Specification will be delivered by the Business Analysts. </b>
- <b> Requirements Analysis Phase Starts </b>
  - The project manager, operations, developers, and testers meet up and define more planning details based on the requirements.
      - Example (User Registration):
          1. Username input field
          2. Password input field
          3. Checkbox - for terms and conditions
          4. Submit button
          5. Save User in Database
      - Example (Login):
          1. Username input field
          2. Password input field
          3. Submit button
          4. Read user from database 
          5. Log user into system
      - etc.
  - Tickets for tasks are defined into a project management system such as Jira.
- <b> Requirements Analysis Phase Ends. The software requirement specification will be delivered by the Project Manager, Business Analysts, and Senior members of the team. </b>
- <b> Design Phase Starts </b>
  - All the requirements are put into design software such as Adobe XD where things are explained such as:
    - Programming languages used
    - Layout: responsive web design/ mobile support
    - Business Rules: clear session on logout
    - Color Scheme: Blue/Grey
    - Frameworks
    - System Server Design
    - Database Relationships
    - System Architecture
    - Supported Browsers
- <b> Design Phase Ends. A High Level Design (gives the architecture of the product) will be delivered by the architects and senior developers. A Low Level Design (describes how each and every feature in the product should work) will be delievered by senior developers. </b>
- <b> Implementation/Programming Phase Starts </b>
  - Operations will setup hardware/software.
  - Developers will start writing the code.
  - The designers will plan the user interface.
  - The testers will analyze the requirements and start creating test plans and test cases.
    - Imagine the usability of the application and see how it flows.
    - Help the desiners redesign around fundamental flaws in the application.
- <b> Implementation/Programming Phase Ends. Software developers will deliver Source Code Document and the developed product. </b>
- <b> Testing Phase Starts </b>
  - The developers have finished coding the core application with some features.
  - Execute test cases from our test plans.
  - Validate that all the requirements have been met.
  - All the functionality is working as intended.
  - Find as many bugs as possible such as user interface bugs, color scheme is incorrect, unable to login or register.
  - Bugs need to be reported into a bug tracking system.
  - Then the bugs need to be assigned to a developer.
- <b> Testing Phase Ends. QA (Quality Assurance) will deliever the Quality Product and Testing Artifacts. </b>
- <b> Deployment Phase Starts </b>
  - Operations team will create the production environment from the staging environment.
  - The application will then go live.
- <b> Deployment Phase Ends. The application is delievered to the customer. Maintainence will be done as per the Service Level Agreement described in the contract. </b>
- <b> Maintainence Phase Starts </b>
  - Users are logging in, registering, using the application.
  - The servers need to be monitored for stress/load.
  - Bugs will be found in production.
  - Users will email with issues.
  - Write up a bug report, assign it, get it fixed.
  - New features will be asked for and will be added, so the process starts again from here.

#
#### STLC - Software Testing Life Cycle
- STLC identifies what test activities to carry out and when to accomplish those test activities. While testing will be different based on the organization, there is a testing life cycle.
  
- There are 7 key points:
    1. Requirement Analysis
    2. Test Planning
    3. Test Design
    4. Test Environment Setup
    5. Test Execution
    6. Test Closure
   
- Each key point has a definite entry and exit criteria (delieverables)

- <b> Requirement Analysis Phase Starts. </b>
    - Entry criteria is a Business Requirement Specification (name depends on the organization but here is another name for it: business requirements document)
    - This phase helps determine whether the requirements are testable or not.
    - During this phase if any requirement is not testable, the test team can communicate with various stakeholders so that a mitigation strategy can be planned.
- <b> Test Planning Phase Starts. </b>
  - Test manager/test lead determines the effort and cost estimates for the entire project.
  - Preparation of the Test Plan will be done based on the requirement analysis.
  - Activities such as:
    - Resource planning
    - Determining roles and responsibilities
    - Tool selection (if using automation testing)
    - Training requirement
  - Exit criteria or the deliverables for this phase is a test plan and effort estimation documents.
- <b> Test Design Phase Starts </b>
  - Test team starts with test case development.
  - Test team prepares test cases, test scripts, and test data.
  - Test cases are peer reviewed.
  - Test team will then prepare the Requirement Traceability Matrix.
  - The RTM traces the requirements to the test cases that are needed to verify whether the requirements are fulfilled.
- <b> Test Environment Setup Starts </b>
    - This phase can be started parallel with the Test Design Phase.
    - Test environment setup is done based on the hardware and software requirement list.
    - In some cases the test team may not be involved with this phase.
    - The development team or the customer provides the test environment.
    - Meanwhile test team should create smoke test cases to check the readiness of the given test environment.
    - Exit criteria is the smoke test results.
- <b> Test Execution Phase Starts </b>
    - Test team executes test cases based on the test plan.
    - Defect reports should be created for failed test cases and bugs should be entered into the bug tracking tool.
    - Retesting will occur one the defect was marked as resolved.
    - Exit criteria are test case execution report, defect report, RTM. 
- <b> Test Closure Phase Starts </b>
  - Create the test closure report and test metrics.
  - Testing team will be called out for a meeting to evaluate cycle completion criteria based on test coverage, quality, time, cost, software, and business objectives.
  - Test team analyses the test artifacts (test cases, defect reports, etc) to identify strategies that have to be implemented in the future which will remove process bottlenecks in the upcoming projects.
  - Exit criteria are test metrics and test closure report.

#
#### Source Control/ Version Control
- Source Control (or version control) is the practice of tracking and managing changes to code.  
- Source control management (SCM) systems provide a running history of code development and help to resolve conflicts when merging contributions from multiple sources.

    #
    #### Git
    - Git is a free and open source distributed version control system designed to handle everything from small to very large projects with speed and efficiency.

    - Installing and Using Git:
        - Installing Git
            - Git can be downloaded from https://git-scm.com/downloads
                - You can choose the download corresponding to your operating system.
            - Once the download is finished, start the installer and use the default settings unless you know what you're doing. 
            - To check that Git has been installed, open a command line and type in the following command:
                ```
                git --version
                ```
        - Using Git
            - Cloning a repository
                - In order to get started with git you can either clone an existing repository or create your own
            - Creating a repository
            - Saving changes and Uploading changes:
                - Saving Changes: 
                    - In order to save any changes made to the project, you must add the files to the list of files that git is tracking.
                        - Adding single files
                            ```
                            git add file1.txt
                            ```
                        - Adding multiple files
                            ```
                            git add file2.txt file3.txt file4.txt
                            ```
                        - Adding all files in a directory
                            ```
                            git add .
                            ```
                    - Create a branch to hold the changes
                        ```
                        git branch newFeatureBeingAdded
                        ```
                    - Change to the new branch
                        ```
                        git checkout newFeatureBeingAdded
                        ```
                    - Commit the changes made so far
                        ```
                        git commit -m "This should be a REALLY short summary of changes" -m "This should be a larger more detailed explination of what changes have been made and why"
                        ```
                - Uploading Changes:
                    - Push the changes to the remote repository
                        ```
                        git push origin newFeatureBeingAdded
                        ```
                    - Go onto the website that the remote repository is being hosted on
                        - Example: github
                        - Example: gitlab
                        - Example: bitbucket
                    - Create a pull request to allow newFeatureBeingAdded branch to be added to master branch. 
                    - Wait until a peer has reviewed the changes and cleared it. 