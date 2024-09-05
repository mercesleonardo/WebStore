<?php

declare(strict_types = 1);

namespace Core\Database;

use PDO;
use PDOStatement;

class Connector
{
    protected PDO $connection;

    protected ?string $query = null;

    public function __construct(DatabaseConfig $config)
    {
        $dsn ='mysql:' . http_build_query($config->getConfig(), arg_separator: ';');
        $this->connection = new PDO($dsn, $config->getUsername(), $config->getPassword());
    }

    public function query(string $query): self
    {
        $this->query = $query;
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
        $statement->execute();
        return $statement;

    }

}