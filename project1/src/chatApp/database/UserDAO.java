package chatApp.database;

import java.sql.DriverManager;
import java.sql.Connection;
import java.sql.SQLException;

public class UserDAO {

    public static void main(String[] argv) {

        System.out.println("-------- MySQL JDBC Connection Testing ------------");

        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
        } catch (ClassNotFoundException e) {
            System.out.println("Where is your MySQL JDBC Driver?");
            e.printStackTrace();
            return;
        }

        System.out.println("MySQL JDBC Driver Registered!");
        Connection connection = null;

        try {
            connection = DriverManager
                    .getConnection("jdbc:mysql://localhost:3306/cmpe275?useLegacyDatetimeCode=false&serverTimezone=UTC","root", "pass");

        } catch (SQLException e) {
            System.out.println("Connection Failed! Check output console");
            e.printStackTrace();
            return;
        }

        if (connection != null) {
            System.out.println("You made it, take control your database now!");
        } else {
            System.out.println("Failed to make connection!");
        }
    }
}

/*
2017-10-28T06:52:56.518851Z 1 [Note] A temporary password is generated for root@localhost: 75G;-dskS2JN

If you lose this password, please consult the section How to Reset the Root Password in the MySQL reference manual.
* */