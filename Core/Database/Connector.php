<?php

declare(strict_types = 1);

namespace Core\Database;

use PDO;
use PDOStatement;

class Connector
{
    protected PDO $connection;
    protected ?string $query = null;
    protected array $params = [];

    public function __construct(DatabaseConfig $config)
    {
        $dsn ='mysql:' . http_build_query($config->getConfig(), arg_separator: ';');
        $this->connection = new PDO($dsn, $config->getUsername(), $config->getPassword());
    }

    public function query(string $query, array $params = []): self
    {
        $this->query = $query;
        $this->params = $params;

        return $this;
    }

    public function get(): array
    {
        return $this->getStatement()->fetchAll(PDO::FETCH_OBJ);
    }

    public function first(): object
    {
        return $this->getStatement()->fetch(PDO::FETCH_OBJ);
    }

    private function getStatement(): PDOStatement
    {
        $statement = $this->connection->prepare($this->query);

        $this->bindParameters($statement);

        $statement->execute();

        return $statement;

    }

    private function bindParameters(PDOStatement $statement): void
    {
        if (empty($this->params)) {
            return;
        }

        foreach ($this->params as $key => $value) {
            $key = is_int($key) ? $key + 1 : $key;
            $pdoParams = is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR;

            $statement->bindValue($key, $value, $pdoParams);
        }
    }

    public function insert(): false | string
    {
        $this->getStatement();

        return $this->connection->lastInsertId();
    }

}