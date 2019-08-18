package database;

import org.testng.annotations.AfterTest;
import org.testng.annotations.BeforeTest;
import org.testng.annotations.Test;

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

    // Connection to database
    @BeforeTest
    public void setup() {
        try {
            connection = DriverManager.getConnection(DATABASE_URL, USERNAME, PASSWORD);
            if(connection != null) { System.out.println("Connection to the database was opened successfully."); }
            else { System.out.println("Connection could not be made to the database."); }
        } catch (Exception e) {
            System.out.println("Unable to connect to the database due to exception.");
            e.printStackTrace();
        }
    }

    // DDL, DML, DQL, DCL, TCL
    @Test
    public void connectionTest() {
        try {
            if(connection != null && !(connection.isClosed())) {
                System.out.println("Connected.");
            }
        } catch (Exception e) { e.printStackTrace(); }
    }
    // CRUD

    // Joins

    // Queries with subqueries

    // Disconnect from database
    @AfterTest
    public void tearDown() {
        try {
            if(connection != null) { connection.close(); System.out.println("Connection the the database was closed successfully."); }
        } catch (Exception e) {
            System.out.println("Connection could not be closed due to an exception.");
            e.printStackTrace();
        }
    }
}