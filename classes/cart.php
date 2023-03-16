<?php


class Cart extends DbConnect
{
    protected function getItems()
    {
        $queryStr = 'SELECT * FROM items';
        $query = $this->connect()->query($queryStr);
        $response = $query->fetchAll();

        return $response;
    }


    protected function setItem(string $item_name, int $item_price)
    {
        $queryStr = 'INSERT INTO items (item_id, item_name, item_price, item_status) VALUES (NULL, ?, ?, ?)';
        $query = $this->connect()->prepare($queryStr);
        $response = $query->execute([$item_name, $item_price, 'false']);

        return $response;
    }

    protected function removeItem(int $item_id)
    {
        $queryStr = 'DELETE FROM items WHERE item_id = ?';
        $query = $this->connect()->prepare($queryStr);
        $response = $query->execute([$item_id]);

        return $response;
    }

    protected function updateItem(int $item_id, string $item_name, int $item_price)
    {
        $queryStr = 'UPDATE items SET item_name = ?, item_price = ? WHERE item_id = ?';
        $query = $this->connect()->prepare($queryStr);
        $response = $query->execute([$item_name, $item_price, $item_id]);

        return $response;
    }

    protected function setItemStatus(int $item_id, string $item_status)
    {
        $queryStr = 'UPDATE items SET item_status = ? WHERE item_id = ?';
        $query = $this->connect()->prepare($queryStr);
        $response = $query->execute([$item_status, $item_id]);

        return $response;
    }
}
