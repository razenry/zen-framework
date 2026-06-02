<?php

namespace Database;

class Schema
{
    public static function create($table, callable $callback)
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);
        
        $sql = $blueprint->toSql();
        $db = new Database();
        $db->query($sql);
        $db->execute();
        
        echo "Created table: $table\n";
    }

    public static function dropIfExists($table)
    {
        $sql = "DROP TABLE IF EXISTS `$table`";
        $db = new Database();
        $db->query($sql);
        $db->execute();
        
        echo "Dropped table: $table\n";
    }
}
