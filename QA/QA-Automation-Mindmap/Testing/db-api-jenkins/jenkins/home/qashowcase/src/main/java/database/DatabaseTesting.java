package database;

import org.testng.ITestContext;
import org.testng.annotations.*;

import java.lang.reflect.Method;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;

public class DatabaseTesting {

    private static final String DATABASE_URL = "jdbc:mysql://localhost:3306/database";
    private static final String USERNAME = "database-tester";
    private static final String PASSWORD = "password";

    private Connection connection;
    private PreparedStatement preparedStatement;
    private ResultSet resultSet;

    // Connection to database before each test is run.
    @BeforeTest
    public void setup() {
        try {
            System.out.println("===============================================================================");
            connection = DriverManager.getConnection(DATABASE_URL, USERNAME, PASSWORD);
            if(connection != null) { System.out.println("Connection to the database was opened successfully."); }
            else { System.out.println("Connection could not be made to the database."); }
        } catch (Exception e) {
            System.out.println("Unable to connect to the database due to exception.");
            e.printStackTrace();
        }
        System.out.println("Setup has been completed.");
    }

    // This method runs before every test method and prints the name and description of the test.
    @BeforeMethod
    public void beforeMethod(Method method) {
        Test test = method.getAnnotation(Test.class);
        System.out.println("Running test: " + method.getName());
        System.out.println("Test description: " + test.description());
    }

    @Test(priority = 1, description = "Check if the connection has been made with the database.")
    public void connectionTest() {
        try {
            if(connection != null && !(connection.isClosed())) {
                System.out.println("Connected.");
            }
        } catch (Exception e) { e.printStackTrace(); }
    }

    // Query types: DDL, DML, DCL, TCL
    // CRUD: Create, Read, Update, Delete
    // DDL: Data Definition Language - Data definition statement are use to define the database structure or table.
    // Contains the following queries: CREATE, ALTER, TRUNCATE, RENAME, DROP
    @Test(priority = 2, description = "CREATE: Create new database/table.")
    public void createTable() {

    }

    @Test(priority = 3, description = "ALTER: Modifies the structure of database/table.")
    public void alterTable() {

    }

    @Test(priority = 4, description = "TRUNCATE: Remove all table records including allocated table spaces.")
    public void truncateTable() {

    }

    @Test(priority = 5, description = "RENAME: Rename the database/table.")
    public void renameTable() {

    }

    @Test(priority = 6, description = "DROP: Deletes a database/table.")
    public void dropTable() {

    }

    // DML: Data Manipulation Language - Data manipulation statement are use for managing data within table object.
    // Contains the following queries: SELECT, INSERT, UPDATE, DELETE, MERGE, (NOT INCLUDED IN THIS FILE: LOCK TABLE, CALL EXPLAIN PLAN)
    @Test(priority = 7, description = "SELECT: Retrieve data from the table.")
    public void selectFromTable() {

    }

    @Test(priority = 8, description = "INSERT: Insert data into a table.")
    public void insertIntoTable() {

    }

    @Test(priority = 9, description = "UPDATE: Updates existing data with new data within a table.")
    public void updateInTable() {

    }

    @Test(priority = 10, description = "DELETE: Deletes the records rows from the table.")
    public void deleteFromTable() {

    }

    @Test(priority = 10, description = "MERGE: statements to INSERT new records or UPDATE existing records depending on condition matches or not.")
    public void mergeIntoTable() {

    }

    // Joins:
    // Types of joins: inner, full, left, right
    @Test(priority = 11, description = "INNER JOIN: ")
    public void innerJoin() {

    }

    @Test(priority = 12, description = "FULL JOIN: ")
    public void fullJoin() {

    }

    @Test(priority = 13, description = "LEFT JOIN: ")
    public void leftJoin() {

    }

    @Test(priority = 14, description = "RIGHT JOIN: ")
    public void rightJoin() {

    }

    // Queries with subqueries
    @Test(priority = 15, description = "RIGHT JOIN: ")
    public void subqueryJoin() {

    }

    // Disconnect from database each time a test has been completed.
    @AfterTest
    public void tearDown() {
        try {
            if(connection != null) { connection.close(); System.out.println("Connection the the database was closed successfully."); }
        } catch (Exception e) {
            System.out.println("Connection could not be closed due to an exception.");
            e.printStackTrace();
        }
        System.out.println("Teardown has been completed.");
        System.out.println("===============================================================================");
    }
}