const baseUrl = 'http://localhost:8000';
// function for show posts without refresh
// table row with ajax
// showPosts();
function table_post_row(res){
let htmlView = '';
   if(res.posts.length <= 0){
       htmlView+= `
        <tr>
          <td colspan="4">No data.</td>
         </tr>`;
}
for(let i = 0; i < res.posts.length; i++){
      htmlView += `
          <tr>
             <td>`+ (i+1) +`</td>
             <td>`+res.posts[i].title+`</td>
              <td>`+res.posts[i].content+`</td>
              <td>
                <button id="editModal" data-action="`+baseUrl+`/post/`+res.posts[i].uuid+`/update" data-id="`+res.posts[i].uuid+`" class="btn btn-warning btn-sm">Edit</button>
<button id="btn-delete" data-id="`+res.posts[i].uuid+`" class="btn btn-danger btn-sm">Delete</button>
</td>
</tr>
`;
}
$('#tbody').html(htmlView);
}
function showPosts(){
   $.ajax({
      type : 'GET',
      dataType: "json",
      url  : baseUrl+'/post',
      success : function (res) {
           table_post_row(res);
   },error : function(error){
    console.log(error);
   }
})
}
$('#openModal').click(function() {
    let url = $(this).data('action');
    $('#exampleModal').modal('show');
    $('#formData').trigger("reset");
    $('#formData').attr('action',url);
    })
    // $("#posts-table").ajax.reload();
    // Event for created and updated posts
    $('#formData').submit(function(e) {
       e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
             type: 'POST',
             data : formData,
             contentType: false,
              processData: false,
              url: $(this).attr('action'),
              beforeSend:function(){
              $('#btn-create').addClass("disabled").html("Processing...").attr('disabled',true);
       $(document).find('span.error-text').text('');
    },
    complete: function(){
    $('#btn-create').removeClass("disabled").html("Save   Change").attr('disabled',false);
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
       
    $("button#editModal").click(function(event) {

        let dataAction = $(this).data('action');
        $('#formData').attr('action',dataAction);
    
    
        let id = $(this).data('id');
    
        $.ajax({
                type: 'GET',
                url : baseUrl+`/post/${id}/edit`,
                dataType: "json",
                success: function(res) {
                $('input[name=title]').val(res.post.title);
                $('input[name=page]').val(res.post.page);
                $('textarea[name=content]').val(res.post.content);
                $('#exampleModal').modal('show');
                    console.log(res);
            },
            error:function(error) {
                console.log(error)
            }
        })
    
    });
    
    $('button#btn-delete').click(function(e) {
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

    $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#posts-table').DataTable({
                processing: true,
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
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });
    
    })
    