<?php
require_once __DIR__ . '/../database/connectDB.php';

class Model
{
    use DbConnection;

    protected static $table;  // Define table name in child classes




    public static function getAll(): array
    {
        try {
            $pdo = self::connect();
            $stmt = $pdo->query("SELECT * FROM " . static::$table);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            }
            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function getById($id): array
    {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            }
            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function getByName($name): array
    {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE name = :name");
            $stmt->execute(['name' => $name]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$result) {
                return [];
            }
            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function exists($data): bool
    {
        try {
            var_dump($data);
            $pdo = self::connect();
            $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $sql = "SELECT * FROM " . static::$table . " WHERE $whereClause";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
 
            return $result ? true : false;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function getByFields($data): array
    {
        try {
            
            $pdo = self::connect();
            $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE $whereClause");


            $stmt->execute($data);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$result) {
                return [];
            }

            return $result;
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function getData(array $filters = [], array $joins = [], array $commonFields = []): array
    {
        try {
            $pdo = self::connect();
            $table = static::$table; // Main table

            // Build JOIN Clause
            $joinStr = self::buildJoinClause($joins);

            // Build WHERE Clause
            [$whereClause, $params] = self::buildWhereClause($filters);

            // Build SELECT Clause
            $selectClause = self::buildSelectClause($table, $joins, $commonFields);

            // Construct SQL query
            $query = "SELECT $selectClause FROM $table $joinStr $whereClause";

            // echo($query);
            // var_dump($params);
            // die();

            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            

            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            throw $e;
        }
    }

    





    public static function create($data): int
    {
        try {
            $pdo = self::connect();
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $stmt = $pdo->prepare("INSERT INTO " . static::$table . " ($columns) VALUES ($values)");
        
            $stmt->execute($data);
            return $pdo->lastInsertId();
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function update($id, $newData): bool
    {
        try {
            $pdo = self::connect();

            // Get existing data
            $stmt = $pdo->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $oldData = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$oldData) {
                throw new Exception("Record with ID $id not found.");
            }

            // Compare and keep only changed fields
            $changedFields = [];
            $params = [];

            foreach ($newData as $key => $value) {
                if (!array_key_exists($key, $oldData) || $oldData[$key] != $value) {
                    $changedFields[] = "$key = :$key"; // Build the SET clause
                    $params[$key] = $value;
                }
            }


            // No changes? Skip the update
            if (empty($changedFields)) {
                return false; // No update performed
            }

            // Prepare and execute update
            $sql = "UPDATE " . static::$table . " SET " . implode(", ", $changedFields) . " WHERE id = :id";

            $params['id'] = $id;
            $stmt = $pdo->prepare($sql);
          

            return $stmt->execute($params);
        } catch (PDOException $e) {
            throw $e;
        }
    }


    public static function delete($id): bool
    {
        try {
            $pdo = self::connect();
            $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE id = :id");
            return $stmt->execute(['id' => $id]);
        } catch (PDOException $e) {
            throw $e;
        }
    }

    public static function deleteByFields($data): bool
    {
        try {
            $pdo = self::connect();
            $whereClause = implode(" AND ", array_map(fn($key) => "$key = :$key", array_keys($data)));
            $stmt = $pdo->prepare("DELETE FROM " . static::$table . " WHERE $whereClause");
            
            return $stmt->execute($data);
        } catch (PDOException $e) {
            throw $e;
        }
    }



    /**
     * Builds the WHERE clause dynamically, supporting AND, OR, and IN conditions.
     */
    private static function buildWhereClause(array $filters): array
    {
        $whereParts = [];
        $params = [];

        foreach ($filters as $key => $value) {
            // Handle OR conditions (array with "OR" key)
            if ($key === 'OR' && is_array($value)) {
                $orParts = [];
                foreach ($value as $orKey => $orValue) {
                    if (is_array($orValue)) {
                        // Handle "IN" condition inside OR
                        $placeholders = implode(", ", array_fill(0, count($orValue), "?"));
                        $orParts[] = "$orKey IN ($placeholders)";
                        $params = array_merge($params, $orValue);
                    } else {
                        $orParts[] = "$orKey = ?";
                        $params[] = $orValue;
                    }
                }
                $whereParts[] = "(" . implode(" OR ", $orParts) . ")";
            }
            // Handle IN conditions
            elseif (is_array($value)) {
                $placeholders = implode(", ", array_fill(0, count($value), "?"));
                $whereParts[] = "$key IN ($placeholders)";
                $params = array_merge($params, $value);
            }
            // Handle simple AND conditions
            else {
                $whereParts[] = "$key = ?";
                $params[] = $value;
            }
        }

        $whereClause = !empty($whereParts) ? "WHERE " . implode(" AND ", $whereParts) : "";

        return [$whereClause, $params];
    }

    /**
     * Builds the JOIN clause dynamically
     */
    private static function buildJoinClause(array $joins): string
    {
        $joinClauses = [];

        foreach ($joins as $joinTable => $joinData) {
            if (!isset($joinData['condition'])) {
                throw new Exception("Join condition for '$joinTable' is missing.");
            }
            $joinType = $joinData['type'] ?? 'INNER'; // Default to INNER JOIN
            $joinClauses[] = "$joinType JOIN $joinTable ON {$joinData['condition']}";
        }

        return implode(" ", $joinClauses);
    }

    private static function buildSelectClause(string $table, array $joins, array $commonFields = ['id']): string
{
    $selectFields = [];
    foreach ($commonFields as $field) {
        $selectFields[] = "$table.$field as $field";
    }
    
    // Select all fields from the main table, except the common fields
    $selectFields[] = implode(", ", array_map(fn($col) => "$table.$col", self::getTableColumns($table, $commonFields)));

    foreach ($joins as $joinTable => $joinData) {
        $alias = isset($joinData['alias']) ? $joinData['alias'] : $joinTable;

        // Select all fields from the joined table, except common fields
        $columns = self::getTableColumns($alias, $commonFields);
        foreach ($columns as $column) {
            $selectFields[] = "$alias.$column";
        }

        // If the common field (e.g., 'id') exists, alias it as tableName_id
        foreach ($commonFields as $field) {
            $selectFields[] = "$alias.$field AS {$alias}_$field";
        }
    }

    return implode(", ", array_unique($selectFields));
}

private static function getTableColumns(string $table, array $excludeFields = []): array
{
    try {
        $pdo = self::connect();
        $stmt = $pdo->query("DESCRIBE $table");
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return array_filter($columns, fn($col) => !in_array($col, $excludeFields));
    } catch (PDOException $e) {
        throw $e;
    }
}

}
