<?php

namespace App\Models;

use PDO;

/**
 * Order Item Model
 */
class OrderItem extends \Core\Model
{

    /**
     * Get all the order items
     *
     * @return array
     */
    public static function getAll()
    {
        $db = static::getDB();
        $stmt = $db->query('SELECT *  FROM order_items');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
