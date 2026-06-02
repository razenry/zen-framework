<?php

namespace Database;

use PDO;
use PDOException;

class Database
{
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh;
    private $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            
            if (!empty($this->db_name)) {
                $this->dbh->exec("CREATE DATABASE IF NOT EXISTS `" . $this->db_name . "`");
                $this->dbh->exec("USE `" . $this->db_name . "`");
            }
        } catch (PDOException $e) {
            throw $e;
        }
    }


    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    // --- Query Builder Methods ---

    private $qb_table = '';
    private $qb_select = '*';
    private $qb_where = [];
    private $qb_params = [];
    private $qb_order = '';
    private $qb_limit = '';

    public function table($table)
    {
        $this->qb_table = $table;
        // Reset query builder variables for new query
        $this->qb_select = '*';
        $this->qb_where = [];
        $this->qb_params = [];
        $this->qb_order = '';
        $this->qb_limit = '';
        return $this;
    }

    public function select($columns = '*')
    {
        $this->qb_select = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }

    public function where($column, $operator, $value = null)
    {
        if ($value === null) {
            $value = $operator;
            $operator = '=';
        }
        
        $this->qb_where[] = "$column $operator ?";
        $this->qb_params[] = $value;
        return $this;
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->qb_order = " ORDER BY $column $direction";
        return $this;
    }

    public function limit($limit, $offset = 0)
    {
        $this->qb_limit = " LIMIT $offset, $limit";
        return $this;
    }

    public function get()
    {
        $sql = "SELECT {$this->qb_select} FROM {$this->qb_table}";
        if (!empty($this->qb_where)) {
            $sql .= " WHERE " . implode(' AND ', $this->qb_where);
        }
        $sql .= $this->qb_order . $this->qb_limit;

        $this->query($sql);
        foreach ($this->qb_params as $index => $value) {
            $this->bind($index + 1, $value);
        }
        return $this->resultSet();
    }

    public function first()
    {
        $this->limit(1);
        $result = $this->get();
        return !empty($result) ? $result[0] : null;
    }

    public function insert($data)
    {
        $keys = array_keys($data);
        $fields = implode(', ', $keys);
        $placeholders = implode(', ', array_fill(0, count($keys), '?'));
        
        $sql = "INSERT INTO {$this->qb_table} ($fields) VALUES ($placeholders)";
        $this->query($sql);
        
        $i = 1;
        foreach ($data as $value) {
            $this->bind($i++, $value);
        }
        
        return $this->execute();
    }

    public function update($data)
    {
        $setFields = [];
        foreach (array_keys($data) as $key) {
            $setFields[] = "$key = ?";
        }
        $setClause = implode(', ', $setFields);
        
        $sql = "UPDATE {$this->qb_table} SET $setClause";
        if (!empty($this->qb_where)) {
            $sql .= " WHERE " . implode(' AND ', $this->qb_where);
        }
        
        $this->query($sql);
        
        $i = 1;
        foreach ($data as $value) {
            $this->bind($i++, $value);
        }
        foreach ($this->qb_params as $value) {
            $this->bind($i++, $value);
        }
        
        return $this->execute();
    }

    public function delete()
    {
        $sql = "DELETE FROM {$this->qb_table}";
        if (!empty($this->qb_where)) {
            $sql .= " WHERE " . implode(' AND ', $this->qb_where);
        }
        
        $this->query($sql);
        
        $i = 1;
        foreach ($this->qb_params as $value) {
            $this->bind($i++, $value);
        }
        
        return $this->execute();
    }
}
