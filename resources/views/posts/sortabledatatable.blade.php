<!DOCTYPE html>
<html>
<head>
<title>Create Drag and Droppable Datatables Using jQuery UI Sortable in Laravel</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css"/>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<body>
<div class="row mt-5">
<div class="col-md-10 offset-md-1">
<h3 class="text-center mb-4">Create Drag and Droppable Datatables Using jQuery UI Sortable in Laravel</h3>
<table id="table" class="table table-bordered">
<thead>
<tr>
<th width="30px">#</th>
<th>Name</th>
<th>Status</th>
<th>Date</th>
</tr>
</thead>
<tbody id="tablecontents">
@foreach($sorting as $sort)
<tr class="row1" data-id="{{ $sort->id }}">
<td>
<div style="color:rgb(124,77,255); padding-left: 10px; float: left; font-size: 20px; cursor: pointer;" title="change display order">
<i class="fa fa-ellipsis-v"></i>
<i class="fa fa-ellipsis-v"></i>
</div>
</td>
<td>{{ $sort->name }}</td>
<td>{{ ($sort->status == 1)? "active" : "inactive" }}</td>
<td>{{ date('d-m-Y ',strtotime($sort->date)) }}</td>
</tr>
@endforeach
</tbody>
</table>
<hr>
<h5>Drag and Drop the table rows and <button class="btn btn-success btn-sm" onclick="window.location.reload()">REFRESH</button> </h5>
</div>
</div>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>
<script type="text/javascript">
$(function ()
 {
$("#table").DataTable();
$( "#tablecontents" ).sortable({
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
$('tr.row1').each(function(index,element) {
order.push({
id: $(this).attr('data-id'),
position: index+1
});
});
$.ajax({
type: "POST",
dataType: "json",
url: "{{ url('dragDrop') }}",
data: {
order: order,
_token: token
},
success: function(response) {
if (response.status == "success") {
console.log(response);
} else {
console.log(response)
}
}
});
}
});
</script>
</body>
</html>