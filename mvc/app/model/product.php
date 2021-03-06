<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ale
 * Date: 5/8/13
 * Time: 11:44 AM
 * To change this template use File | Settings | File Templates.
 */

class model_product {

    var $id;
    var $category_id;
    var $name;
    var $price;
    var $description;
    var $amount;
    var $image;
    var $url;
    var $average;


    /**
     * Loads a product by id.
     * @param $id
     * @return bool|model_product
     */
    public static function load_by_id($id) {
        $db = model_database::instance();
        $sql = 'SELECT *
			FROM product
			WHERE product_id = ' . intval($id);
        if ($result = $db->get_row($sql)) {
            $product = new model_product;
            $product->id = $result['product_id'];
            $product->category_id = $result['category_id'];
            $product->name = $result['product_name'];
            $product->price = $result['product_price'];
            $product->description = $result['product_description'];
            $product->amount = $result['product_amount'];
            $product->image = $result['product_image'];
            $product->url = $result['product_url'];
            $product->average = $result['average'];
            return $product;
        }
        return FALSE;
    }


    /**
     * Gets all products by category_id.
     * @param $category_id
     * @return array|bool
     */
    public static function load_by_category_id($category_id){
        $db = model_database::instance();
        $sql = 'SELECT *
                FROM product
                WHERE category_id = ' . intval($category_id);

        $result[] = array();
        if ($result = $db->get_rows($sql)) {
            return $result;
        }
        return FALSE;
    }


    /**
     * Obtain a product id when we specifying a concrete product name.
     * @param $product_name
     */
    public static function get_id_by_name ($product_name) {
        $db = model_database::instance();
        $sql = "SELECT product_id FROM product WHERE product_name = '" . $product_name . "'";
        $result = $db->get_row($sql);
        $id = intval($result['product_id']);
        return $id;
    }



    /**
     * @param $category_id
     * @return bool|model_category
     */
    public static function get_category($category_id){
        $result = new model_category();
        if(($result::load_by_id($category_id))!=FALSE) {
            return $result =$result::load_by_id($category_id);
        }
        return FALSE;
    }


    /**
     * Add a new product.
     * @param $name
     * @param $description
     * @param $price
     * @param $amount
     * @param $category
     * @return bool|model_product
     */
    public static function add_product($name,$description,$price,$amount,$category){
        $db = model_database::instance();
        $sql = 'Insert into product (product_name,product_description,product_price,product_amount,category_id)
                values("' . mysql_real_escape_string($name) . '","' . mysql_real_escape_string($description) . '",'   . intval(mysql_real_escape_string($price)) . ',' . intval(mysql_real_escape_string($amount)) .','. intval($category) .')';
        $db->execute($sql);

        return model_product::load_by_id($db->last_insert_id());

    }
    public function update_rating($result) {
        $db = model_database::instance();
        $sql = 'update product set average = ' . intval($result) . ' where product_id = ' . intval($this->id);
        $db->execute($sql);
        return TRUE;
    }



    /**
     * Delete a product by id
     * @param $idProduct
     */
    public static function delete_product_by_id($idProduct){
        $db = model_database::instance();
        $sql = 'delete from product where product_id = ' .intval($idProduct);
        $db->execute($sql);
    }


    /**
     * Edit a product by id.
     * @param $id
     * @param $name
     * @param $description
     * @param $price
     * @param $amount
     */
    public static function edit_product_by_id($id,$name,$description,$price,$amount){
        $db = model_database::instance();
        $sql = 'update product set product_name  = "' . mysql_real_escape_string($name) . '", product_description = "' . mysql_real_escape_string($description) . '",product_price = '   . intval(mysql_real_escape_string($price)) . ',product_amount = ' . intval(mysql_real_escape_string($amount)) .' where product_id = ' . intval($id);
        $db->execute($sql);
    }

    /**
     * Obtain all products name from db.
     */
    public static function get_all_productsName() {
        $db = model_database::instance();
        $sql = 'SELECT product_name from product';
        $products = $db->get_rows($sql);
        return $products;
    }

    /**
     * Search a product by a given word
     * @param $word
     * @return boolean/array
     */
    public static function search_product($word) {
        $db = model_database::instance();
        $sql = "SELECT *
                FROM product
                WHERE product_description REGEXP '[[:<:]]" . $word . "[[:>:]]'
                   or product_name REGEXP '[[:<:]]" . $word . "[[:>:]]'";
        $products_list[] = array();
        if ($products_list = $db->get_rows($sql)) {
            return $products_list;
        }
        return FALSE;
    }

/*
    public static function init_search_table(){
        $db = model_database::instance();
        $sql = "DROP TABLE search";
        $db->execute($sql);
        $sql = "CREATE TABLE search (id_word int primary key auto_increment,
                                     word varchar(20),
                                     product_id int)";
        $db->execute($sql);
    }
*/

    public static function insert_words() {
        $db = model_database::instance();
        $sql = "TRUNCATE TABLE search";
        $db->execute($sql);

        $sql = 'SELECT product_description, product_id
                FROM product';
        $result[] = array();
        $result = $db->get_rows($sql);

        foreach($result as $row) {
            $words[] = array();
            $words = split(" ", $row['product_description']);

            foreach($words as $word){
                $sql = "INSERT INTO search ( word , product_id )
                        VALUES ('" . $word . "', " . $row['product_id'] . ")";
                $db->execute($sql);
            }
        }
    }

    public static function get_products($word){
        $db = model_database::instance();
        $sql = "SELECT product_id
                FROM search
                WHERE word = '" . $word . "'";
        $id_list[] = array();
        $id_list = $db->get_rows($sql);

        foreach($id_list as $id) {
            $sql = "SELECT product_name
                    FROM product
                    WHERE product_id = " . $id['product_id'];
            $products_list[] = array();
            $products_list = $db->get_rows($sql);

            return $products_list;

        }

    }


    public  function edit_product_amount_by_id($amount){
        $db = model_database::instance();
        $sql = 'update product set product_amount  = product_amount = ' . intval(mysql_real_escape_string($amount)) .' where product_id = ' . intval($this->id);
        $db->execute($sql);
    }

}

