<?php
namespace App\Http\Controllers;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Content::with('user')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('page', function($row){
                return $row->page;
             })
            ->addColumn('title', function($row){
                return $row->title;
             })
             ->addColumn('content', function($row){
                return Str::words(strip_tags($row->content), 11, '...');
             })
             ->addColumn('author', function($row){
                return $row->user->name;
             })
            ->addColumn('action', function($row){
                $btn = '<button id="editModal" data-action='.route('post.update',$row->uuid).' data-id='.$row->uuid.' class="btn btn-warning btn-sm">Edit</button>
                <script type="text/javascript">
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
                </script>';

                $btn = $btn.'<button id="btn-delete" data-id='.$row->uuid.' class="btn btn-danger btn-sm">Delete</button>
                <script type="text/javascript">
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
                </script>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('posts.index');
    }

    public function getPost(Request $request)
    {
     
        $posts = Content::all();
        return $posts;
        return response()->json([
            'success' => true,
            'posts' => $posts
        ]);
    
    }

    public function create()
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        $sort = Content::count('sort');

        $sort_value = '';

        if($sort == 0)
        {   
            $sort_value = 1;

        }else{
            $sort_value = Content::orderBy('created_at','desc')->first();

            $sort_value = $sort_value->sort + 1;
        }

        $uuid = Str::uuid()->toString();

        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'content' => 'required',
            'page' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }

        $data = [

            'uuid' => Str::uuid(),
            'title' => $request->title,
            'content' => $request->content,
            'page' => $request->page,
            'author' => Auth::id(),
            'sort' => $sort_value

        ];
        Content::create($data);
        return response()->json([
        'success' => true,
            'message' => 'Success created post',
        ]);
    }

    public function edit($id)
    {
        $post = Content::where('uuid',$id)->first();
            return response()->json([
            'success' => true,
            'post' => $post
        ]);
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required|min:5',
            'content' => 'required',
            // 'sort' => 'required|unique:contents,sort,'.$id
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(),400);
        }


        $post = Content::where('uuid',$id)->first();
        $data = $request->all();
        Content::where('uuid',$id)->update([
            'title' => $request->title,
            'content' => $request->content,
            'page' => $request->page,
            'author' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Success Updated post',
        ]);
    }
    public function destroy($id)
    {
    $post = Content::where('uuid',$id)->first();
    if($post){
        Content::where('uuid',$id)->delete();
        return response()->json([
        'success' => true,
        'message' => 'Success Deleted post',
        ]);
    }
}
}