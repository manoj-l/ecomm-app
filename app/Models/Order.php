<?php

namespace App\Models;

use PDO;

/**
 * Order Model
 */
class Order extends \Core\Model
{

    /**
     * Get all the orders
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT *  FROM orders');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
