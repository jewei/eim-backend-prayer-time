<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application;
use App\ServiceProvider;
use PDO;
use PDOException;

/**
 * Basic database class that only support basic PDO operations for SQLite3.
 *
 * In real world or production, we should use proper database libraries like
 * Eloquent or Doctrine which supports transactions, profiling, error handling,
 * and support other type of databases etc.
 */
final class Database extends ServiceProvider
{
    /**
     * @var ?PDO
     */
    protected $connection;

    protected string $database;

    public function boot(Application $app): void
    {
        $this->database = $app->config('database') ?? '';
        $this->connect();
    }

    /**
     * Connects to the database.
     */
    public function connect(): PDO
    {
        if ($this->connection) {
            return $this->connection;
        }

        // Create a new PDO connection.
        $this->connection = new PDO(
            dsn: "sqlite:{$this->database}",
            options: [
                PDO::ATTR_CASE => PDO::CASE_NATURAL,
                PDO::ATTR_ORACLE_NULLS => PDO::NULL_NATURAL,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );

        return $this->connection;
    }

    /**
     * Execute an SQL statement and return the number of affected rows.
     *
     * @param  array<string, string>  $bindings
     */
    public function execute(string $query, array $bindings = []): int
    {
        // Reconnect to the database if the PDO connection is missing.
        if (! $this->connection) {
            $this->connection = $this->connect();
        }

        $statement = false;

        try {
            // Prepare SQL statement.
            $statement = $this->connection->prepare($query);

            // Bind values to given parameters in the statement.
            foreach ($bindings as $key => $value) {
                $statement->bindValue($key, $value, $this->getPdoType($value));
            }

            // Execute the query against the database.
            $statement->execute();

            // Return the number of rows affected by the statement.
            return $statement->rowCount();
        } catch (PDOException $e) {
            throw $e;
        } finally {
            // Closes the cursor, enabling the statement to be executed again.
            if ($statement !== false) {
                $statement->closeCursor();
            }
        }
    }

    /**
     * Disconnects from the database.
     */
    public function disconnect(): void
    {
        $this->connection = null;
    }

    private function getPdoType(mixed $value): int
    {
        return match (true) {
            is_int($value) => PDO::PARAM_INT,
            is_bool($value) => PDO::PARAM_BOOL,
            is_null($value) => PDO::PARAM_NULL,
            is_resource($value) => PDO::PARAM_LOB,
            default => PDO::PARAM_STR,
        };
    }
}
