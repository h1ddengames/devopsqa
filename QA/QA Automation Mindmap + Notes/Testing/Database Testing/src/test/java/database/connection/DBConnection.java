package database.connection;
import java.sql.*;

class DBConnection {
    private static Connection con = null;
    private static String USERNAME = "database-tester";
    private static String PASSWORD = "database";
    private static String DRIVER = "com.mysql.jdbc.Driver";
    private static String URL = "jdbc:mysql://192.168.0.17:3306/classicmodels";

    public static Connection getDatabaseConnection(){
        try{
            //Class.forName(DRIVER);
            return con = DriverManager.getConnection(URL,USERNAME,PASSWORD);
        } catch (SQLException e) {
            throw new IllegalStateException("Cannot connect the database!", e);
        }
    }

    public static void main(String[] args) {
        DBConnection.getDatabaseConnection();
        try{
            System.out.println(con.isClosed());

            Statement stmt = con.createStatement();
            ResultSet rs;

            rs = stmt.executeQuery("SELECT * FROM customers WHERE contactFirstName = 'Alexander'");
            while ( rs.next() ) {
                String lastName = rs.getString("contactLastName");
                String firstName = rs.getString("contactFirstName");
                System.out.println(lastName + " " + firstName);
            }

            con.close();
            System.out.println(con.isClosed());
        } catch (SQLException e) {
            System.out.println("Exception reached: SQLException.");
            e.printStackTrace();
        } catch (Exception e) {
            System.out.println("Other Exception reached: " + e.getCause());
        }
    }
}
