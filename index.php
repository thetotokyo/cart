
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Shopping Cart</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="stylesheet" href="./css/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
    <div class="p-3 w-full flex flex-row gap-5 justify-center">
        <div id="dashboard w-full">
            <h1 class="font-bold text-2xl">Shopping Card</h1>
            
            <input class="p-2 px-5 my-5 text-white bg-green-600 rounded" type="button" id="btnAddItem" name="btnAddItem" onclick="window.location.href='?add=true'" value="Add New Item"/>
                
                <div class="flex flex-col gap-10">
                    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                      <div class="inline-block py-2 sm:px-6 lg:px-8">
                        <div class="overflow-hidden">
                          <table class="text-left text-sm font-light border dark:border-neutral-500">
                            <thead class="border-b font-medium dark:border-neutral-500">
                              <tr>
                                <th scope="col" class="px-6 py-4">#</th>
                                <th scope="col" class="px-6 py-4">Name</th>
                                <th scope="col" class="px-6 py-4">Price</th>
                                <th scope="col" class="px-6 py-4">Status</th>
                                <th scope="col" class="px-6 py-4">Action</th>
                              </tr>
                            </thead>
                            <tbody id="dashboardTablee">
                              <?php
                                ob_start();
                                include_once('server.php'); 

                                $shoppingCart = new ShoppingCart();

                                //print_r($shoppingCart->load());
                                $count = 0;

                                foreach($shoppingCart->load() as $row)
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
                                    header('Location: ?edit=true&item_id='.$row['item_id'].'&item_name='.urlencode($row['item_name']).'&item_price='.$row['item_price']);
                                  }
                                  else if(isset($_POST['dlt_'.$row['item_id']]))
                                  {
                                    $res = $shoppingCart->delete($row['item_id']);
                                    if($res)
                                    {
                                      header('Location: ./');
                                    }
                                  }
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
        </div>
        <div class="mt-20 w-80 text-white">
            <?php
            
            if(isset($_GET['add']))
            {
              ?>
              <form id="addForm" class="bg-blue-600 p-10 w-full" method="POST" enctype="multipart/form-data" >
                  <h1 class="font-bold text-2xl">Add Item</h1>
                  <div class="mt-5">
                      <label>Item Name</label><br>
                      <input class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black" type="text" required name="txtName" placeholder="Name"/>
                  </div>
                  <div class="mt-5">
                      <label>Item Price</label><br>
                      <input class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black" type="number" step="0.1" required name="txtPrice" placeholder="Price"/>
                  </div>
                  <div class="row">
                    <input class="p-3 px-5 mt-5 text-white bg-green-600 rounded" type="submit" id="btnAdd" name="btnAdd" value="Submit"/>
                    <input class="p-3 px-5 mt-5 text-white bg-red-600 rounded" type="button" onclick="window.location.href = './'" value="Cancel"/>
                  </div>
              </form>
              <?php

              if(isset($_POST['btnAdd']))
              {
                $shoppingCart->add($_POST['txtName'], $_POST['txtPrice']);
              }

            }
            else if(isset($_GET['edit']))
            {
              ?>

                <form id="updateForm" class="bg-blue-600 p-5 w-full" method="POST" enctype="multipart/form-data" >
                  <h1 class="font-bold text-2xl">Edit Item</h1>
                  <div class="mt-5">
                      <label>Item Name</label><br>
                      <input class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black" type="text" required id="txtUpdateName" name="txtUpdateName" value="<?php echo urldecode($_GET['item_name']) ?>" placeholder="Name"/>
                  </div>
                  <div class="mt-5">
                      <label>Item Price</label><br>
                      <input class="h-10 border mt-1 rounded px-4 w-full bg-gray-50 text-black" type="number" step="0.1" required id="txtUpdatePrice" name="txtUpdatePrice" value="<?php echo urldecode($_GET['item_price']) ?>" placeholder="Price"/>
                  </div>
                  <div class="row">
                    <input class="p-3 px-5 mt-5 text-white bg-green-600 rounded" type="submit" id="btnUpdate" name="btnUpdate" value="Submit"/>
                    <input class="p-3 px-5 mt-5 text-white bg-red-600 rounded" type="button" onclick="window.location.href = './'" value="Cancel"/>
                  </div>
                </form>

              <?php

              if(isset($_POST['btnUpdate']))
              {
                $res = $shoppingCart->update($_GET['item_id'], $_POST['txtUpdateName'], $_POST['txtUpdatePrice']);
                if($res)
                {
                  header('Location: ./');
                }
                
              }
            }
            else if(isset($_GET['updateStatus']))
            {
              if(isset($_GET['item_id']) && isset($_GET['item_status']))
              {
                $res = $shoppingCart->updateStatus($_GET['item_id'], $_GET['item_status'] == 'true' ? 'false' : 'true');
                if($res)
                {
                  header('Location: ./');
                }
              }
            }
            

            ?>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script> --> -->
    <!-- <script src="./js/main.js"></script> -->
    
</body>
</html>