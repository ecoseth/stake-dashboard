const baseUrl = 'http://localhost:8000';
// function for show posts without refresh
// table row with ajax

$('#openModal').click(function() {
    let url = $(this).data('action');
    editorInstance.setData('');
    $('#exampleModal').modal('show');
    $('input[name=title]').val('');
    $('[id=title]').css('display','block');
    $('#formData').trigger("reset");
    $('#formData').attr('action',url);
    })
    // $("#posts-table").ajax.reload();
    // Event for created and updated posts
    $('#formData').submit(function(e) {
       e.preventDefault();

       $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var editorContent = editorInstance.getData();

        let formData = new FormData(this);

        var title = $("input[name=title]").val();

        var page = $("#page").val();

        var token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            type: 'POST',
            data : {_token: token,title: title, page: page, content: editorContent},
            dataType: 'JSON',
            url: $(this).attr('action'),
            beforeSend:function(){
            $('#btn-create').addClass("disabled").html("Processing...").attr('disabled',true);
            $(document).find('span.error-text').text('');
    },
    complete: function(){
    $('#btn-create').removeClass("disabled").html("Save Change").attr('disabled',false);
    },
    success: function(res){
    console.log(res);
    // to reload
    
    if(res.success == true){
    $('#formData').trigger("reset");
    $('#exampleModal').modal('hide');
    
    $("#posts-table").DataTable().ajax.reload();


    Swal.fire(
    'Success!',
    res.message,
    'success'
    )
    }
    },
    error(err){
    $.each(err.responseJSON,function(prefix,val) {
    $('.'+prefix+'_error').text(val[0]);
    })
    console.log(err);
    }
    })
    })


       
  
    $(document).ready(function(){

        $('#page').on('change', function() {

            var selectedValue = $(this).val();
            $('.error-text').text(' ');

            if(selectedValue == 'About')
            {
                $('input[name=title]').val('About');
                $('[id=title]').css('display','none');
                $('#partner-section').css('display','block');



            }else if(selectedValue == 'Support')
            {
                $('input[name=title]').val('');
                $('[id=title]').css('display','block');

            }
            
        });

        $("#close-modal-btn").on('click', function () {

            $('[id=title]').css('display','block');
            $('input[name=title]').val();
            $('.error-text').text(' ');

        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#posts-table').DataTable({
            processing: true,
            createdRow: function(row, data) {
                                let id = data[0]; // amend 'data[0]' here to be the correct column for your dataset
                                $(row).prop('id', id).data('id', id); 
                        },
            serverSide: true,
            ajax: "/post",
            columns: [{
                    data: 'page',
                    name: 'page'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'content',
                    name: 'content'
                },
                {
                    data: 'author',
                    name: 'author'
                },
                {
                    data: 'order',
                    name: 'order'
                },
                
                
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });

        $( "#posts-table" ).sortable({
            items: "tr",
            cursor: 'move',
            opacity: 0.6,
            update: function() {
            sendOrderToServer();
            }
            });
            function sendOrderToServer() {
            
            var order = [];
            var token = $('meta[name="csrf-token"]').attr('content');
            $('[id="editModal"]').each(function(index,element) {
            order.push({
            id: $(this).attr('data-id'),
            position: index+1
            });
            });
            console.log(order)
            $.ajax({
            type: "POST",
            dataType: "json",
            url: "/sortabledatatable",
            data: {
            order: order,
            _token: token
            },
            success: function(response) {
            if (response.message == "success") {
            $('#posts-table').DataTable().ajax.reload();

            } else {
            console.log(response)
            }
            }
            });
            }

            $('#posts-table').on('click', '#editModal', function() {

                let dataAction = $(this).data('action');
                $('input[name=title]').val('');
                $('input[name=page]').val('');
                $('#content').val(' ');
                $('#formData').attr('action',dataAction);
            
            
                let id = $(this).data('id');   
                
                $.ajax({
                    type: 'GET',
                    url : baseUrl+`/post/${id}/edit`,
                    dataType: "json",
                    success: function(res) {
                    if(res.post.page == 'About')
                    {
                        $('[id=title]').css('display','none');
                    }
                    $('.error-text').text(' ');
                    $('#page').val(res.post.page);                
                    // $('#btn-create').addClass("disabled").html("Processing...").attr('disabled',true);

                    $('input[name=title]').val(res.post.title);
                    $('input[name=page]').val(res.post.page);
                    
                    editorInstance.setData(res.post.content);

                    $('#exampleModal').modal('show');
                        console.log(res);
                    },
                    error:function(error) {
                        console.log(error)
                    }
                })
            
            });
            
            $('#posts-table').on('click', '#btn-delete', function(e) {
                e.preventDefault();
                let dataDelete = $(this).data('id');
                // console.log(dataDelete);
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this! ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.isConfirmed) {
                $.ajax({
                type:'DELETE',
                dataType: 'JSON',
                url: baseUrl+`/post/${dataDelete}/delete`,
                data:{
                '_token':$('meta[name="csrf-token"]').attr('content'),
                },
                success:function(response){
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
                $('#posts-table').DataTable().ajax.reload();
        
            },
                error:function(err){
                console.log(err);
                }
                });
                }
                })
                });
            
    })
    