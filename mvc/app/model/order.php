<?php

/**
 * Order model.
 */

class model_order {
    var $id;
    var $client_id;
    var $contract_id;


    /**
     * Loads an order by ID.
     */

    public static function load_by_id($id) {
        $db = model_database::instance();
        $sql = 'SELECT *
			FROM orders
			WHERE order_id = ' . intval($id);
        if ($result = $db->get_row($sql)) {
            $order = new model_order;
            $order->id = $result['order_id'];
            $order->client_id = $result['client_id'];
            $order->contract_id = $result['contract_id'];
            return $order;
        }
        return FALSE;
    }



}