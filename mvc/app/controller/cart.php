<?php
/**
 * Controller for cart.
 */
class controller_cart {

    // Include the cart_view.tpl.php to display all products from $_SESSION['cart']
    public function action_view() {

        @include_once APP_PATH . 'view/cart_view.tpl.php';
    }

    // Delete a row from shopping cart
    public function action_deleteProduct() {
        $product_id = intval($_POST['form']['id']);
        $quantity = intval($_POST['form']['quantity']);
        model_cart::resetQuantity($product_id,$quantity);
        unset($_SESSION['cart'][$product_id]);
        header('Location:'. APP_URL.'cart/view');
        die();
    }

    //Add a product to shopping cart
    public function action_addProduct($idProduct) {
        $product=model_product::load_by_id($idProduct);
        $_SESSION['cart'][$product->id] = $_POST['form']['amount'];
        $quantity = $product->amount - $_POST['form']['amount'];
        $product::edit_product_by_id($product->id,$product->name,$product->description,$product->price,$quantity);

        header('Location: ' . APP_URL . 'cart/view/' );

        // Include view for this page.
        @include_once APP_PATH . 'view/cart_view.tpl.php';
    }



}