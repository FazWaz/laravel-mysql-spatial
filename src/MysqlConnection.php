<?php

namespace Limenet\LaravelMysqlSpatial;

use Illuminate\Database\MySqlConnection as IlluminateMySqlConnection;
use Limenet\LaravelMysqlSpatial\Schema\Builder;
use Limenet\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar;

class MysqlConnection extends IlluminateMySqlConnection
{
    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        parent::__construct($pdo, $database, $tablePrefix, $config);
    }

    /**
     * Get the default schema grammar instance.
     */
    protected function getDefaultSchemaGrammar(): \Illuminate\Database\Grammar
    {
        return $this->withTablePrefix(new MySqlGrammar());
    }

    /**
     * Get a schema builder instance for the connection.
     */
    public function getSchemaBuilder(): \Illuminate\Database\Schema\MySqlBuilder
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new Builder($this);
    }
}
