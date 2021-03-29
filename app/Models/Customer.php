<?php

namespace App\Models;

use PDO;

/**
 * Customer Model
 */
class Customer extends \Core\Model
{

    /**
     * Get all the customers
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT *  FROM customers');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
