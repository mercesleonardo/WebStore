<?php

declare(strict_types = 1);

namespace Core\Database;

use DateTime;
use PDO;
use PDOStatement;

class Connector
{
    protected PDO $connection;

    protected ?string $query = null;

    protected array $params = [];

    public function __construct(DatabaseConfig $config)
    {
        $dsn = 'mysql:' . http_build_query($config->getConfig(), arg_separator: ';');

        $this->connection = new PDO($dsn, $config->getUsername(), $config->getPassword());
    }

    public function query(string $query, array $params = []): self
    {
        $this->query  = $query;
        $this->params = $params;

        return $this;
    }

    public function get(): array
    {
        return $this->executeQuery()->fetchAll(PDO::FETCH_ASSOC);
    }

    public function first(): array | false
    {
        return $this->executeQuery()->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(): int | string
    {
        $this->executeQuery();

        $lastInsertId = $this->connection->lastInsertId();

        return is_numeric($lastInsertId) ? (int) $lastInsertId : $lastInsertId;
    }

    public function update(): bool
    {
        return $this->affectingStatement();
    }

    public function delete(): bool
    {
        return $this->affectingStatement();
    }

    public function affectingStatement(): bool
    {
        return $this->executeQuery()->rowCount() > 0;
    }

    private function executeQuery(): PDOStatement
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

            $pdoParams = match (true) {
                is_int($value)  => PDO::PARAM_INT,
                is_bool($value) => PDO::PARAM_BOOL,
                is_null($value) => PDO::PARAM_NULL,
                default         => PDO::PARAM_STR,
            };

            if ($value instanceof DateTime) {
                $value = $value->format('Y-m-d H:i:s');
            }

            $statement->bindValue($key, $value, $pdoParams);
        }
    }

    public function queryBuilder(): Query\Builder
    {
        return new Query\Builder($this, new Query\Compiler());
    }
}
