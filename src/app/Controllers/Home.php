<?php
declare(strict_types=1);

namespace App\Controllers;

use App\View;

class Home
{
    public function index(): string
    {
        try {
            // Connect to the database using environment variables
            $db = new \PDO("mysql:host={$_ENV["DB_HOST"]};dbname={$_ENV["DB_DATABASE"]}", $_ENV["DB_USER"], $_ENV["DB_PASSWORD"], [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
            ]);

            // Begin a transaction
            $db->beginTransaction();

            // Dynamic data
            $email = "fsfds@doe.com";
            $fullName = "fsdfs Doe";
            $isActive = 1;

            // Prepare and execute the INSERT statement
            $query = 'INSERT INTO users (email, full_name, is_active) VALUES (:email, :name, :isActive)';
            $insertStatement = $db->prepare($query);
            $insertStatement->execute(["email" => $email, "name" => $fullName, "isActive" => $isActive]);

            // Get the last inserted ID
            $id = $db->lastInsertId();

            // Prepare and execute the SELECT statement to retrieve the inserted user
            $selectQuery = 'SELECT * FROM users WHERE id = :id';
            $selectStatement = $db->prepare($selectQuery);
            $selectStatement->execute(["id" => $id]);

            // Fetch the user data
            $user = $selectStatement->fetch();

            // Commit the transaction
            $db->commit();
        } catch (\PDOException $e) {
            // Rollback the transaction on PDO exception
            $db->rollBack();
            throw new \PDOException("PDO Exception: " . $e->getMessage(), $e->getCode());
        } catch (\Throwable $e) {
            // Handle other exceptions
            throw new \Exception("Transaction Error: " . $e->getMessage(), $e->getCode());
        }

        // Output the user data
        echo "<pre>";
        var_dump($user);
        echo "</pre>";

        // Render the view
        return View::make('index', ["title" => "First post"])->render(true);
    }
}
