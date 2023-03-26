
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
            
            <form method="POST">
              <input class="p-2 px-5 my-5 text-white bg-green-600 rounded" type="submit" id="btnAddItem" name="btnAddItem" value="Add New Item"/>
            </form>
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

                                $shoppingCart->load()
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
            
            if(isset($_POST['btnAddItem']))
            {
              $shoppingCart->page = 'Add';
            }
      

            if($shoppingCart->page == 'Add')
            {
              $shoppingCart->page = 'Add';
              $shoppingCart->toggleAddEdit('Add');
            }
            else if($shoppingCart->page == 'Edit')
            {
              $shoppingCart->page = 'Edit';
              $shoppingCart->toggleAddEdit('Edit', $shoppingCart->selectItem);
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
            else if(isset($_POST['btnAdd']))
              {
                if($_POST['txtID'] == '')
                {
                    $shoppingCart->add($_POST['txtName'], $_POST['txtPrice']);
                }
                else
                {
                    $shoppingCart->update($_POST['txtID'] , $_POST['txtName'], $_POST['txtPrice']);
                }
              }
            ?>
        </div>
    </div>

    <!-- <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script> -->
    <!-- <script src="./js/main.js"></script> -->
    
</body>
</html>