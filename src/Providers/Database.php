<?php

declare(strict_types=1);

namespace App\Providers;

use App\ServiceProvider;
use Exception;
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
            dsn: "sqlite:{$this->app->config('database')}",
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
     * @param  array<int|string, int|string>  $bindings
     * @return array<int, array<string, string>>
     */
    public function fetch(string $query, array $bindings = []): array
    {
        if (is_int($result = $this->execute($query, $bindings, true))) {
            throw new Exception('Expecting fetch to get array type result');
        }

        return $result;
    }

    /**
     * Execute an SQL statement and return the number of affected rows.
     *
     * @param  array<int|string, int|string>  $bindings
     * @return int|array<int, array<string, string>>
     */
    public function execute(string $query, array $bindings = [], bool $fetchMode = false): int|array
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
                $statement->bindValue(
                    is_string($key) ? $key : $key + 1,
                    $value,
                    $this->getPdoType($value)
                );
            }

            // Execute the query against the database.
            $statement->execute();

            if ($fetchMode) {
                if (false === $result = $statement->fetchAll(PDO::FETCH_ASSOC)) {
                    throw new Exception('Failed to fetch from database');
                }

                // Return the selected rows.
                return $result;
            } else {
                // Return the number of rows affected by the statement.
                return $statement->rowCount();
            }
        } catch (PDOException $e) {
            $this->app->log('error', $e->getMessage());
            throw $e;
        } finally {
            // Closes the cursor, enabling the statement to be executed again.
            if ($statement !== false) {
                $statement->closeCursor();
            }
        }
    }

    /**
     * Dangerously run query.
     */
    public function executeRaw(string $query): int
    {
        if (! $this->connection) {
            $this->connection = $this->connect();
        }

        try {
            $res = $this->connection->exec($query);

            if ($res !== false) {
                return $res;
            }
        } catch (PDOException $e) {
            $this->app->log('error', $e->getMessage());
            throw $e;
        }

        return 0;
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
