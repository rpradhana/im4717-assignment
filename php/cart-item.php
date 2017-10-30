<?php
    class CartItem {
        public $id;
        public $color;
        public $size;
        public $quantity;

        public function __construct($id, $color, $size, $quantity) {
            $this->id = $id;
            $this->color = $color;
            $this->size = $size;
            $this->quantity = $quantity;
        }
    }

    function get_item_index_in_cart (CartItem $item , $cart_array) {
        for ($i = 0 ; $i < sizeof($cart_array); $i++) {
            $cart_item = $cart_array[$i];
            if (($cart_item->id == $item->id) && ($cart_item->color == $item->color) && ($cart_item->size == $item->size)) {
                return $i;
            }
        }
        return -1;
    }
?>