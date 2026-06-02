<?php

namespace Database;

class Blueprint
{
    private $table;
    private $columns = [];

    public function __construct($table)
    {
        $this->table = $table;
    }

    public function id()
    {
        $this->columns[] = "id INT AUTO_INCREMENT PRIMARY KEY";
        return $this;
    }

    public function string($name, $length = 255)
    {
        $this->columns[] = "$name VARCHAR($length)";
        return $this;
    }

    public function text($name)
    {
        $this->columns[] = "$name TEXT";
        return $this;
    }

    public function integer($name)
    {
        $this->columns[] = "$name INT";
        return $this;
    }

    public function boolean($name)
    {
        $this->columns[] = "$name TINYINT(1) DEFAULT 0";
        return $this;
    }

    public function timestamps()
    {
        $this->columns[] = "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        return $this;
    }

    public function unique()
    {
        // Ambil definisi kolom terakhir yang ditambahkan dan tambahkan UNIQUE
        $lastIndex = count($this->columns) - 1;
        if ($lastIndex >= 0) {
            $this->columns[$lastIndex] .= " UNIQUE";
        }
        return $this;
    }

    public function nullable()
    {
        // Ambil definisi kolom terakhir yang ditambahkan dan tambahkan NULL
        $lastIndex = count($this->columns) - 1;
        if ($lastIndex >= 0) {
            $this->columns[$lastIndex] .= " NULL";
        }
        return $this;
    }

    public function default($value)
    {
        $lastIndex = count($this->columns) - 1;
        if ($lastIndex >= 0) {
            $val = is_string($value) ? "'$value'" : $value;
            $this->columns[$lastIndex] .= " DEFAULT $val";
        }
        return $this;
    }

    public function foreignId($name)
    {
        $this->columns[] = "$name INT";
        return $this;
    }

    public function constrained($table = null, $column = 'id')
    {
        // Mendapatkan nama kolom terakhir
        $lastIndex = count($this->columns) - 1;
        if ($lastIndex >= 0) {
            // Asumsi format kolom terakhir: "nama_kolom TIPE_DATA..."
            $parts = explode(' ', $this->columns[$lastIndex]);
            $colName = $parts[0];
            
            if ($table === null) {
                // Infer table name from column name (e.g. user_id -> users)
                $table = str_replace('_id', 's', $colName);
            }
            
            // Tambahkan sebagai constraint baru di array columns
            $this->columns[] = "FOREIGN KEY ($colName) REFERENCES $table($column)";
        }
        return $this;
    }

    public function cascadeOnDelete()
    {
        $lastIndex = count($this->columns) - 1;
        if ($lastIndex >= 0 && strpos($this->columns[$lastIndex], 'FOREIGN KEY') !== false) {
            $this->columns[$lastIndex] .= " ON DELETE CASCADE";
        }
        return $this;
    }

    public function toSql()
    {
        return "CREATE TABLE IF NOT EXISTS `{$this->table}` (\n    " . implode(",\n    ", $this->columns) . "\n)";
    }
}
