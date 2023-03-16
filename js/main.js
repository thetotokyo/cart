$(document).ready(function(){

    let currentID = -1;

    loadItems();

    function loadItems()
    {
        $.getJSON('./server.php?load=true', function(data){
            $('#dashboardTable').empty();
            $.each(data, function(i, field){
                $('#dashboardTable').append(
                '<tr class="border-b dark:border-neutral-500">'+
                    '<td class="whitespace-nowrap px-6 py-4 font-medium">'+(i+1)+'</td>'+
                    '<td class="whitespace-nowrap px-6 py-4">'+field.item_name+'</td>'+
                    '<td class="whitespace-nowrap px-6 py-4">'+field.item_price+'</td>'+
                    '<td class="whitespace-nowrap px-6 py-4"><input id="check_'+field.item_id+'" type="checkbox" /></td>'+
                    '<td class="whitespace-nowrap px-6 py-4">'+
                        '<div class="flex flex-rowstify-content-center align-items-center">'+
                            '<button id="edit_'+field.item_id+'" type="button" class="rounded-lg text-blue-600">Edit</button>'+
                            '<button id="dlt_'+field.item_id+'" type="button" class="rounded-lg m-3 text-red-600">Delete</button>'+
                        '</div>'+
                    '</td>'+
                '</tr>'
                );
                
                if(field.item_status === 'true')
                {
                    $('#check_'+field.item_id).attr('checked', 'checked');
                }

                $('#check_'+field.item_id).change(function(){
                    let status = 'true';
                    if($('#check_'+field.item_id).attr('checked'))
                    {
                        status = 'false';
                    }

                    $.get('./server.php?updateStatus=true&status='+status+'&id='+field.item_id, function(res){
                        if(res)
                        {
                            alert('Item successfully updated!')
                        }
                        else
                        {
                            alert('Sever Error!')
                        }
                    });
                });

                $('#dlt_'+field.item_id).click(function(){
                    if(window.confirm('Are you sure you want to delete this item?') == true)
                    {
                        $.get('./server.php?delete=true&id='+field.item_id, function(res){
                            if(res)
                            {
                                alert('Item successfully deleted!');
                                loadItems();
                            }
                            else
                            {
                                alert('Sever Error!')
                            }
                        });
                    }
                });

                $('#edit_'+field.item_id).click(function(){

                    currentID = field.item_id;

                    $('#addForm').hide();
                    
                    $('#updateForm').show();

                    $('#txtUpdateName').val(field.item_name);
                    $('#txtUpdatePrice').val(field.item_price);
                    
                });

            });
        });
    }
    
    $('#btnAddItem').click(function(){
        $('#updateForm').hide();

        if($('#addForm').css('display') === 'none')
        {
            $('#addForm').show();
        }
        else
        {
            $('#addForm').hide();
        }
    });

    $('#addForm').submit(function(e){
        
        e.preventDefault();
        $('#btnAdd').val('Please wait...');
        $('#btnAdd').attr('disabled','disabled');
            
            $.ajax({
                url: './server.php?add=true',
                type: 'POST',
                data: new FormData(document.getElementById('addForm')),
                contentType:false,
                cache:false,
                processData:false,
                success: function(res){
                    if(res)
                    {
                        alert('Added Successfully');
                        $('#addForm').trigger("reset");
                        $('#addForm').hide();
                        loadItems();
                    }
                    else
                    {
                        alert('Error');
                        $('#btnAdd').val('Submit');
                        $('#btnAdd').removeAttr('disabled');
                    }
                }
            });
    });

    $('#updateForm').submit(function(e){
        
        e.preventDefault();
        $('#btnUpdate').val('Please wait...');
        $('#btnUpdate').attr('disabled','disabled');
            
            $.ajax({
                url: './server.php?update=true&id='+currentID,
                type: 'POST',
                data: new FormData(document.getElementById('updateForm')),
                contentType:false,
                cache:false,
                processData:false,
                success: function(res){
                    if(res)
                    {
                        alert('Updated Successfully');
                        $('#updateForm').hide();
                        loadItems();
                    }
                    else
                    {
                        alert('Error');
                        $('#btnUpdate').val('Submit');
                        $('#btnUpdate').removeAttr('disabled');
                    }
                }
            });
    });
    

});