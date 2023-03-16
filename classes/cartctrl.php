<?php

class CartCtrl extends Cart
{
    public function addItem(string $item_name, int $item_price)
    {
        $name = trim($item_name);
        $lastName = trim($item_price);
        
        return $this->setItem($item_name, $item_price);
    }

    public function deleteItem(int $item_id)
    {
        return $this->removeItem($item_id);
    }

    public function amendItem(int $item_id, string $item_name, int $item_price)
    {
        $name = trim($item_name);
        $lastName = trim($item_price);
        
        return $this->updateItem($item_id, $item_name, $item_price);
    }

    public function amendItemStatus(int $item_id, string $item_status)
    {
        return $this->setItemStatus($item_id, $item_status);
    }
}