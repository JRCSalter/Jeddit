<?php

declare(strict_types=1);

namespace Core;

use Core\Response;
use Core\Log;
use PDO;
use PDOException;

/**
 * Defines methods for connecting to, retrieving data from, and updating a
 * database.
 */
class Database {
    /** @var \PDO Holds the database connection */
    public \PDO $conn;

    /** @var \PDOStatement Holds a query string. */
    public \PDOStatement $stmt;

    private string $dsn;

    public function __construct(
        private array $config = [],
        private string $username = 'root',
        private string $password = ''
    ) {
        if (! $config) {
            $this->config = [
                'host'    => 'jrcsalter',
                'dbname'  => 'jrcs',
                'charset' => 'utf8mb4',
            ];
        }

        $this->dsn = 'mysql:' . http_build_query($this->config, '', ';');

        $this->connect();
    }

    /**
     * Connects to the database.
     * 
     * Aborts script on failure.
     * 
     * @return static
     */
    private function connect(): static
    {
        try {
            $this->conn = new PDO(
                $this->dsn,
                $this->username,
                $this->password,
                [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ],
            );
        } catch( PDOException $e ) {
            $this->disconnect();
            Log::insertAndAbort(
                ['message' => $e->getMessage()],
                Response::NOT_IMPLEMENTED
            );
        }

        return $this;
    }

    /**
     * Prepares and executes a SQL query.
     * 
     * Aborts on failure.
     * 
     * @param string $query The full query string with placeholders.
     * @param array  $params A list of placeholders and their relevant values.
     *     Defaults to empty array
     * 
     * @return static
     */
    public function query(string $query, array $params = []): static
    {
        try {
            $this->stmt = $this->conn->prepare($query);
            $this->stmt->execute($params);
        } catch(PDOException $e) {
            $this->disconnect();
            Log::insertAndAbort(
                [
                    'message' => $e->getMessage(),
                    'e'       => $e,
                ],
                Response::NOT_IMPLEMENTED
            );
        }

        return $this;
    }

    /**
     * Builds an insert query statement.
     * 
     * @param string $table The table to be used.
     * @param array  $dtata The data to be entered.
     * 
     * @return string
     */
    protected function buildInsertQuery(string $table, array $data): string
    {
        $query = "INSERT INTO {$table} (";

        while ($field = current($data)) {
            $query .= key($data);
            if (next($data)) $query .= ', ';
        }

        $query .= ") VALUES (";

        reset($data);
        
        while ($field = current($data)) {
            $query .= ':' . key($data);
            if (next($data)) $query .= ', ';
        }

        $query .= ")";

        return $query;
    }

    /**
     * Inserts a row into a table.
     * 
     * Returns the entry submitted, and false if not found.
     * The first element in the array should be a unique identifier in order
     * for this to work.
     * Also, each element in $fields and $data needs to have the same index as one another.
     * 
     * @param string $table  The table to be used.
     * @param array  $fields An array of fields to enter.
     * @param array  $data   The data to be entered.
     * 
     * @return object|bool
     */
    public function insert(string $table, array $data, string $class = NULL): object|bool
    {

        $query = $this->buildInsertQuery($table, $data);

        $this->query($query, $data);

        reset($data);

        if (! $class) {
            $class = 'Core\\' . ucfirst($table);
            $class[-1] = ' ';
            $class = trim($class);
        }

        $table = "v_{$table}";

        return $this->query(
            'SELECT * FROM ' . $table . ' WHERE ' . key($data) . ' = "' . current($data) . '"'
        )->findClass($class);
    }
  
    /**
     * Finds a single row in the database.
     * 
     * Returns false if no row is found.
     * 
     * @param ?string $class The class to be used.
     * 
     * @return object|array|bool
     */
    public function find(?string $class = NULL): object|array|bool
    {
        if ($class) $this->stmt->setFetchMode(PDO::FETCH_CLASS, $class);

        return $this->stmt->fetch();
    }
  
    /**
     * Finds a single row in the database.
     * 
     * If a row cannot be found, this aborts the script.
     * 
     * @param ?string $class The class to be used.
     *     Defaults to NULL
     * 
     * @return object|array
     */
    public function findOrFail(?string $class = NULL): object|array
    {
        $result = $this->find($class);

        if ($result) {
            Container::resolve($class);
            return $result;
        }

        abort();
    }
  
    /**
     * A helper method for Database\findOrFail that requires a class.
     * 
     * If a row cannot be found, this aborts the script.
     * 
     * @param string $class The class to be used.
     * 
     * @return object
     */
    public function findClass(string $class): object
    {
        return $this->findOrFail($class);
    }
  
    /**
     * Get all rows from a query.
     * 
     * @param ?string $class If we want to return a list of objects, state the
     *     class here.
     *     Defaults to NULL.
     * 
     * @return array
     */
    public function get(?string $class = NULL): array
    {
        if ($class) $this->stmt->setFetchMode(PDO::FETCH_CLASS, $class);

        return $this->stmt->fetchAll();
    }
  
    /**
     * A helper method for Database\get that requires a class.
     * 
     * @param string $class The class to be used.
     * 
     * @return array
     */
    public function getClass(string $class): array
    {
        return $this->get($class);
    }
  
    /**
     *  Not sure if this is still needed.
     */
    // public function __call( $name, $arguments = [] )
    // {
    //   return $this[ $name ];
    // }
    
    /**
     * Disconnects from the database.
     * 
     * @return void
     */
    public function disconnect(): void
    {
        unset($this->conn);
    }
}