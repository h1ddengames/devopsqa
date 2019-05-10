## Project Management
- This document contains all information related to any questions that can be asked about project management.
#

#### Agile Methodology
- Agile Methodology is 

    #
    #### Scrum
    - Scrum is 

        #
        #### Standups
        - Standups are 

        #
        #### Sprints
        - Sprints are

    #
    #### Kanban
    - Kanban is 

    #
    #### Gantt Chart
    - Gantt Chart is 

    #
    #### Burndown Chart
    - Burndown Chart is 
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