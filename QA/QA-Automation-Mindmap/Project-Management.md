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


#
#### STLC - Software Testing Life Cycle


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