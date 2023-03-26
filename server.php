<?php

include_once('includes/autoload.inc.php');

class ShoppingCart 
{
    public $selectItem = array();
    public $page = '';
        
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



    function load()
    {
        $cartView = new CartView();
        $response = $cartView->displayItems();

        //return $response;

        $count = 0;

        foreach($response as $row)
        {
          $count++;
          $status = $row['item_status'] === 'true' ? 'checked' : '';
          
          
          ?><tr class="border-b dark:border-neutral-500">
                <td class="whitespace-nowrap px-6 py-4 font-medium"><?php echo $count ?></td>
                <td class="whitespace-nowrap px-6 py-4"><?php echo $row['item_name'] ?></td>
                <td class="whitespace-nowrap px-6 py-4"><?php echo 'R'.$row['item_price'] ?></td>
                <td class="whitespace-nowrap px-6 py-4 text-center"><input id="check_<?php echo $row['item_id'] ?>" name="check_<?php echo $row['item_id'] ?>" onchange="window.location.href = '?updateStatus=true&item_id=<?php echo $row['item_id'] ?>&item_status=<?php echo $row['item_status'] ?>'" <?php echo $status ?> type="checkbox" /></td>
                <td class="whitespace-nowrap px-6 py-4">
                    <form class="row text-white" method="POST">
                        <button id="edit_<?php echo $row['item_id'] ?>" name="edit_<?php echo $row['item_id'] ?>" type="submit" class="bg-blue-600 mx-2 p-2 rounded">Edit</button>
                        <button id="dlt_<?php echo $row['item_id'] ?>" name="dlt_<?php echo $row['item_id'] ?>" type="submit" class="bg-red-600 p-2 rounded">Delete</button>
                    </form>
                </td>
              </tr>
            <?php
          
          if(isset($_POST['edit_'.$row['item_id']]))
          {
            $this->selectItem = $row;
            $this->page = 'Edit';
            //header('Location: ?edit=true&item_id='.$row['item_id'].'&item_name='.urlencode($row['item_name']).'&item_price='.$row['item_price']);
          }
          else if(isset($_POST['dlt_'.$row['item_id']]))
          {
            $res = $this->delete($row['item_id']);
            if($res)
            {
                header("Refresh:0");
            }
          }
        }

    }

    function viewAddEdit($type, $item = ['item_id'=> '', 'item_name'=> '', 'item_price'=> '', 'item_status'=> ''])
    {
        ?>
              <form id="addForm" class="bg-blue-600 p-10 w-full" method="POST" enctype="multipart/form-data" >
                  <h1 class="font-bold text-2xl"><?php echo $type ?> Item</h1>
                  <div class="mt-5">
                      <label>Item Name</label><br>
                      <input class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black" type="text"  required name="txtName" placeholder="Name"/>
                  </div>
                  <div class="mt-5">
                      <label>Item Price</label><br>
                      <input class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black" type="number"  step="0.1" required name="txtPrice" placeholder="Price"/>
                  </div>
                  <div class="row">
                    <input class="p-3 px-5 mt-5 text-white bg-green-600 rounded" type="submit" id="btnSubmit" name="btnSubmit" value="Submit"/>
                    <input class="p-3 px-5 mt-5 text-white bg-red-600 rounded" type="button" onclick="window.location.href = './'" value="Cancel"/>
                  </div>
              </form>
              <?php

              if(isset($_POST['btnSubmit']))
              {
                if($type === 'Add')
                {
                    $this->add($_POST['txtName'], $_POST['txtPrice']);
                }
                else
                {
                    $this->update($item['item_id'] , $_POST['txtName'], $_POST['txtPrice']);
                }
              }
              
    }

    
}


?>