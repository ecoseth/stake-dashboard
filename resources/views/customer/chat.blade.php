@extends("layouts.app")
@section('content')
<style>

:root {
  --animate-duration: 800ms;
  --animate-delay: 0.9s;
}
   
.field{
  outline:none;
  background-color:transparent;
  font-family:"open sans";
  font-weight:100;
  letter-spacing: 10px;
  border-radius:8px;
  width:220px;
  font-size:1.1em;
  border:1px solid white;
  height:45px;
  color:white;
  text-align:center;
  margin-top:-15px;
  position:absolute;
  margin-top:15px;
  margin-left:30px;
  display:inline-block;
}

.number{
  width:40px;
  height:40px;
  font-size:1.3em;
  font-weight:200;
  color:white;
  font-family:"open sans";
  border-radius:100%;
  border:1px solid white;
  text-align:center;
  line-height:43px;
  display:inline-block;
  margin:10px;
  cursor:pointer;
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
  transition:0.4s;
}
.number:hover{
      box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}
.number:active{
  box-shadow:none;
}
/* another class just like number, so the x and check buttons wont interrupt to the javascript */
.numberS{
  width:40px;
  height:40px;
  font-size:1.3em;
  font-weight:200;
  color:white;
  font-family:"open sans";
  border-radius:100%;
  border:1px solid white;
  text-align:center;
  line-height:43px;
  display:inline-block;
  margin:10px;
  cursor:pointer;
}
#x{
  display:inline-block;
  margin-left:300px;
  color:#F44336;
  border:none;
  color:#9E9E9E;
  transition:0.4s;
   box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
#x:hover{
 color:white;
    box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
}
#x:active{
  box-shadow:none;
}
#y{
  font-size:1.0em;
  border:none;
  transition:0.6s;
  color:#9E9E9E;
}
#y:hover{
  color:white;
}
</style>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2"></div>
    </div>
</div>

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="modal fade" id="pinForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Enter Your Pin</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <h2>Enter The Code</h2> --}}

                        <section class="container text-center p-2">
                            <div id="y" class="x numberS animate__animated animate__bounceInUp" onclick="check()">Check</div>
                              <input type="tel" class="field animate__animated" id="field" maxlength="4"  pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" />
                              <div id="x" class="x numberS animate__animated animate__bounceInUp"><i class="fas fa-times-circle"></i></div>
                              <div class="row">
                                <div class="col-md-12 " id="cont">
                                </div>
                                
                              </div>
                        </section>
                    </div>
                    {{-- <form action="{{route('fetch.tokens')}}" method="POST"> --}}
                        {{-- @csrf --}}
                       
                    {{-- </form> --}}
                </div>
            </div>
        </div>
        <div class="row flex justify-content-center">
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Customer Chat</h3><small><i class="fa fa-check-circle text-green" id="chat_icon_success" aria-hidden="true" style="display: none;"></i></small>
                        <div class="card-tools">
                           <i class="fas fa-comments"></i>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <textarea cols="30" rows="15" class="form-control" id="chat-config" {{ $data->chat_config ? 'disabled' : ''}}>{{ $data->chat_config ? $data->chat_config : ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    @if ($data->chat_config)

                                        <span class="d-none" id="or-content">{{$data->chat_config}}</span>
                                        <input type="submit" class="btn btn-primary" id="chat-config-edit" value="Edit" />
                                        <input type="submit" class="btn btn-primary d-none" id="chat-config-store" value="Update" />
                                        <input type="submit" class="btn btn-danger d-none" id="chat-config-cancel" value="Cancel" />


                                        
                                    @else

                                        <input type="submit" class="btn btn-primary" id="chat-config-store" value="Save" />

                                    @endif

                                </div>
                                <div class="col-md-6 text-right">
                                    <span class="text-sm">Update By <span class="text-secondary" id="chat_author"> {{ \App\Models\User::find($data->user_id)->name }}</span></span>
                                </div>
                                
                            </div>
                            <div class="col-md-6">
                                <small class="text-right"> <i class="fa fa-times-circle text-warning" id="empty_warning" style="display: none;"></i></small>

                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/animate.css-jquery@1.0.1/dist/animate.jquery.min.js"></script>

<script>

    $("#chat-config-store").click(function(e) {


        var config = $("#chat-config").val();
    
        e.preventDefault();

        if(config != ''){

            $('#pinForm').modal({
                backdrop: 'static',
                keyboard: false  // to prevent closing with Esc button (if you want this too)
            });

        }else{

            Swal.fire(
            'Warning!',
            'Field can not be empty',
            'warning'
            )

        }
        
    });

    $("#chat-config-edit").click(function(e) {

        $("#chat-config").removeAttr('disabled');
        $("#chat-config-store").removeClass('d-none');
        $("#chat-config-cancel").removeClass('d-none');
        $("#chat-config-edit").addClass('d-none');

    })

    $("#chat-config-cancel").click(function(e)
    {
        $("#chat-config-store").addClass('d-none');
        $("#chat-config-cancel").addClass('d-none');
        $("#chat-config-edit").removeClass('d-none');
        $("#chat-config").val($("#or-content").text())
        $("#chat-config").attr('disabled','disabled');

 
    });


    
    /*
Code In Line 113
*/
for(var count =1; count<11;count++){
  var text = document.createTextNode(count);
  var conta = document.getElementById("cont");
  var newNum = document.createElement("div");
  var br = document.createElement("br");
  if(count==4 || count==7 || count==10){
    conta.appendChild(br)
  }
  newNum.classList.add("number");
  newNum.classList.add("animated");
  newNum.classList.add("bounceIn");
  newNum.id = "yo"+count
  if(count==10){
    text = document.createTextNode("0");
  }
  newNum.appendChild(text);
  conta.appendChild(newNum);
}
var x = document.getElementById("x");
x.addEventListener("click", function(){
  document.getElementById("field").value = "";

  document.getElementById("field").classList.remove("bounceInUp");
  document.getElementById("field").classList.add("fadeOutUp");
  document.getElementById("field").classList.remove("fadeOutUp");
  document.getElementById("field").classList.add("bounceInUp");
 
  counter=0;


  
});

var field = document.getElementById("field").innerHTML;
var nums = document.getElementsByClassName("number");

//making buttons add their values but not do more then 4 digits with counter
//function just to get rid of this mess
var counter =0
func()

function func(){
nums[0].onclick = function(){
  if(counter<4){
    document.getElementById("field").value = document.getElementById("field").value + "1";
  counter= counter+1
  }//else{check()} For Auto Check
};
nums[1].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "2";
  counter= counter+1
    }
};

nums[2].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "3";
  counter= counter+1
  }
};

nums[3].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "4";
  counter= counter+1
  }
};

nums[4].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "5";
  counter= counter+1
  }
};

nums[5].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "6";
  counter= counter+1
  }
};
nums[6].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "7";
  counter= counter+1
  }
};

nums[7].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "8";
  counter= counter+1
  }
};
nums[8].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "9";
  counter= counter+1
  }
};

nums[9].onclick = function(){
    if(counter<4){
        document.getElementById("field").value = document.getElementById("field").value + "0";
  counter= counter+1
  }
};


}

document.querySelector("section").classList.add("animate__animated")
var animation="bounce"
function check(){
    
  if(document.getElementById("field").value=="4003"){
    document.querySelector("h4").innerHTML = "Correct";

    $('#pinForm').modal('hide');

    var config = $("#chat-config").val();


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: "{{ route('chat.store') }}",
        data: {
            config: config,
        },
        beforeSend: function() {
            $("#loader").removeClass('d-none');
        },
        success: function(data) {
          
        if(data.message == 'ok')
        {
                $("#chat_icon_success").css('display','block');
                $("#chat_icon_success").delay(3000).fadeOut('slow');
                $("#chat-config-store").addClass('d-none');
                $("#chat-config-cancel").addClass('d-none');
                $("#chat-config-edit").removeClass('d-none');
                $("#chat-config").attr('disabled','disabled');
                $("#chat_author").text(data.updated_by);

                      
        }else if(data.message == 'no-data')
        {
                $("#empty_warning").text('All fields cannot be empty');
                $("#empty_warning").css('display','block');
                $("#empty_warning").delay(3000).fadeOut('slow');
        }

        $("#loader").addClass('d-none');


        }
    });

  }else{
    document.querySelector("h4").innerHTML = "Incorrect";
    document.getElementById("field").value = "";
      if(animation=="bounce"){
        document.querySelector("section").classList.remove("animate__shakeX");
        document.querySelector("section").classList.add("animate__shakeY");
        animation="shake";
      }else{
        document.querySelector("section").classList.remove("animate__shakeY");
        document.querySelector("section").classList.add("animate__shakeX");
        animation="bounce";
      }
    counter=0
  }
}

</script>

@endpush