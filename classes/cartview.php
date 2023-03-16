<?php


class CartView extends Cart
{
    public function displayItems()
    {
        return $this->getItems();
    }
    
}

