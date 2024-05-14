<?php

namespace Backend\Models;

use Backend\Models\Model;


class Product extends Model
{
  protected static $table = 'sample_products';

  static function getTableName(): string
  {
    return static::$table;
  }

  public function getAllProducts()
  {
    $result = $this->sqlQuery("SELECT * FROM " . static::$table . " ORDER BY id DESC");
    $numRows = $result->num_rows;
    if ($numRows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    } else {
      $data = [];
    }

    return $data;
  }

  public function saveProduct(object $params)
  {

    $sql = "INSERT INTO " . static::$table . "(";
        foreach($params as $key=>$val)
        {
            $sql .= "$key".",";
        }
        $sql = rtrim($sql,",");
        $sql .= ") VALUES(";
            foreach($params as $key=>$val)
            {
                $sql .= "'"."$val"."',";
            }
            $sql = rtrim($sql,",");
            $sql .= ")";

    $result = $this->sqlQuery($sql);

    if (!$result) {
      throw new \PDOException($this->getError(), 500);
    }

    return $result;
  }

  public function delete(string $csvIds)
  {
    $result = $this->sqlQuery("DELETE FROM " . static::$table . " WHERE id IN ($csvIds)");

    if (!$result) {
      throw new \PDOException($this->getError(), 500);
    }

    $rows = mysqli_affected_rows($this->connection);

    return $rows;
  }
}
