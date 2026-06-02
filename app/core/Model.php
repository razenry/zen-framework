<?php

namespace App\Core;

use Database\Database;

class Model
{
    protected $table;
    protected $db;
    protected $attributes = [];

    public function __construct()
    {
        $this->db = new Database();
        $this->db->table($this->table);
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public static function all()
    {
        $instance = new static();
        $results = $instance->db->get();
        return array_map(function($data) {
            return static::hydrate($data);
        }, $results);
    }

    public static function find($id)
    {
        $instance = new static();
        $data = $instance->db->where('id', $id)->first();
        return $data ? static::hydrate($data) : null;
    }

    public static function where($column, $operator, $value = null)
    {
        $instance = new static();
        $instance->db->where($column, $operator, $value);
        return $instance;
    }

    public function get()
    {
        $results = $this->db->get();
        return array_map(function($data) {
            return static::hydrate($data);
        }, $results);
    }

    public function first()
    {
        $data = $this->db->first();
        return $data ? static::hydrate($data) : null;
    }

    public static function create($data)
    {
        $instance = new static();
        $instance->db->insert($data);
        return static::find($instance->db->lastInsertId());
    }

    public function update($data)
    {
        return $this->db->update($data);
    }

    public function delete($id = null)
    {
        if ($id !== null) {
            $this->db->where('id', $id);
        }
        return $this->db->delete();
    }

    protected static function hydrate($data)
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            $instance->{$key} = $value;
        }
        return $instance;
    }
}
