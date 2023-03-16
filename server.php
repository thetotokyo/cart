<?php

include_once('includes/autoload.inc.php');


if(isset($_GET['add']))
{
    $cartCtrl = new CartCtrl();
    $response = $cartCtrl->addItem($_POST['txtName'], $_POST['txtPrice']);

    echo $response;
}
else if(isset($_GET['update']))
{
    $cartCtrl = new CartCtrl();
    $response = $cartCtrl->amendItem($_GET['id'], $_POST['txtUpdateName'], $_POST['txtUpdatePrice']);

    echo $response;
}
else if(isset($_GET['load']))
{
    $cartView = new CartView();
    $response = $cartView->displayItems();

    echo json_encode($response);
}
else if(isset($_GET['delete']))
{
    $cartCtrl = new CartCtrl();
    $response = $cartCtrl->deleteItem($_GET['id']);

    echo $response;
}
else if(isset($_GET['updateStatus']))
{
    $cartCtrl = new CartCtrl();
    $response = $cartCtrl->amendItemStatus($_GET['id'], $_GET['status']);

    echo $response;
}

?>