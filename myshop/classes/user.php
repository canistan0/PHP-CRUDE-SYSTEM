<?php

// Requires the file containing the Database class
require_once 'database.php';

class User
{
    private $conn;

    // Constructor
    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    // Execute queries SQL
    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    // Insert
    public function insert($name, $email)
    {
        try {
            // Prepare the SQL statement for insertion
            $stmt = $this->conn->prepare("INSERT INTO crud_users (name, email) VALUES(:name, :email)");

            // Bind the parameters to the prepared statement to prevent SQL injection
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);

            // Execute the prepared statement
            $stmt->execute();

            // Return the statement object (useful for checking success or getting the last insert ID)
            return $stmt;
        } catch (PDOException $e) {
            // Catch and display any database-related errors
            echo $e->getMessage();
        }
    }

    // Update
    public function update($name, $email, $id)
    {
        try {
            // Prepare the SQL statement for updating a record based on ID
            $stmt = $this->conn->prepare("UPDATE crud_users SET name = :name, email = :email WHERE id = :id");

            // Bind the new name, new email, and the ID parameter
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":id", $id);

            // Execute the prepared statement
            $stmt->execute();

            // Return the statement object
            return $stmt;
        } catch (PDOException $e) {
            // Catch and display any database-related errors
            echo $e->getMessage();
        }
    }

    // Delete
    public function delete($id)
    {
        try {
            // Prepare the SQL statement for deleting a record based on ID
            $stmt = $this->conn->prepare("DELETE FROM crud_users WHERE id = :id");

            // Bind the ID parameter
            $stmt->bindParam(":id", $id);

            // Execute the prepared statement
            $stmt->execute();

            // Return the statement object
            return $stmt;
        } catch (PDOException $e) {
            // Catch and display any database-related errors
            echo $e->getMessage();
        }
    }

    // Redirect URL method
    public function redirect($url)
    {
        // Uses the header function to redirect the browser to the specified URL
        // NOTE: This must be called before any other output (HTML, echo, print_r, etc.)
        header("Location: $url");
        exit(); // Always use exit() after header redirect to ensure immediate termination
    }
}
