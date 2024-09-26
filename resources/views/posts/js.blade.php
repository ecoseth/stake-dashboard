<script>
$("button#btn-delete").click(function(e) {
    e.preventDefault();
    let dataDelete = $(this).data("id");
    // console.log(dataDelete);
    Swal.fire({
    title: "Are you sure?",
    text: "You cannot revert this! ",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, delete it!"
    }).then((result) => {
    if (result.isConfirmed) {
    $.ajax({
    type:"DELETE",
    dataType: "JSON",
    url: baseUrl+`/post/${dataDelete}/delete`,
    data:{
    "_token":$("meta[name=csrf-token]").attr("content"),
    },
    success:function(response){
    Swal.fire(
    "Deleted!",
    "Your file has been deleted.",
    "success"
    )
    $("#posts-table").DataTable().ajax.reload();

},
    error:function(err){
    console.log(err);
    }
    });
    }
    })
    });

    $("button#editModal").click(function(event) {

    let dataAction = $(this).data("action");
    $("#formData").attr("action",dataAction);


    let id = $(this).data("id");

    $.ajax({
            type: "GET",
            url : "'.route('post.edit',$row->uuid).'",
            dataType: "json",
            success: function(res) {
            $("input[name=title]").val(res.post.title);
            $("input[name=page]").val(res.post.page);
            $("textarea[name=content]").val(res.post.content);
            $("#exampleModal").modal("show");
        },
        error:function(error) {
            console.log(error)
        }
    })

});
</script>