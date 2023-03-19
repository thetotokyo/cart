$(document).ready(function(){

    const baseURL = 'https://mainmethod.co.za/cart';
    let currentID = -1;

    loadItems();

    function loadItems()
    {
        $.getJSON(baseURL+'/server.php?load=true', function(data){
            $('#dashboardTable').empty();
            $.each(data, function(i, field){

                let color = '';
                if(i % 2 == 0)
                {
                    color = 'rgba(3,3,3,0.1)';
                }

                $('#dashboardTable').append(
                '<tr class="border-b dark:border-neutral-500" style="background: '+color+'">'+
                    '<td class="whitespace-nowrap px-6 py-4 font-medium" style="margin: 5px 0px;">'+(i+1)+'</td>'+
                    '<td class="whitespace-nowrap px-10 py-4" style="margin: 5px 0px;">'+field.item_name+'</td>'+
                    '<td class="whitespace-nowrap px-6 py-4" style="margin: 5px 0px;">R'+field.item_price+'</td>'+
                    '<td class="whitespace-nowrap px-6 py-4" style="margin: 5px 0px;"><input id="check_'+field.item_id+'" type="checkbox" /></td>'+
                    '<td class="whitespace-nowrap px-6 py-4" style="margin: 5px 0px;">'+
                        '<div style="display: inline;">'+
                            '<button id="edit_'+field.item_id+'" type="button" style="color: blue;">Edit</button>'+
                            '<button id="dlt_'+field.item_id+'" type="button" style="color: red;">Delete</button>'+
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

                    $.get(baseURL+'/server.php?updateStatus=true&status='+status+'&id='+field.item_id, function(res){
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
                        $.get(baseURL+'/server.php?delete=true&id='+field.item_id, function(res){
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
                url: baseURL+'/server.php?add=true',
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
                url: baseURL+'/server.php?update=true&id='+currentID,
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