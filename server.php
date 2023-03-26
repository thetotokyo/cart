<?php

include_once('includes/autoload.inc.php');

class ShoppingCart 
{
        
    function add($item_name, $item_price)
    {
        $cartCtrl = new CartCtrl();
        $response = $cartCtrl->addItem($item_name, $item_price);

        echo $response;
    }

    function update($item_id, $item_name, $item_price)
    {
        $cartCtrl = new CartCtrl();
        $response = $cartCtrl->amendItem($item_id, $item_name, $item_price);

        return $response;
    }

    function load()
    {
        $cartView = new CartView();
        $response = $cartView->displayItems();

        return $response;
    }

    function delete($item_id)
    {
        $cartCtrl = new CartCtrl();
        $response = $cartCtrl->deleteItem($item_id);

        return $response;
    }

    function updateStatus($item_id, $item_status)
    {
        $cartCtrl = new CartCtrl();
        $response = $cartCtrl->amendItemStatus($item_id, $item_status);

        return $response;
    }
}


?>