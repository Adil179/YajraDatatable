<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Laravel 8 AJAX CRUD using DataTable js Tutorial From Scratch - Tutsmake.com</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<!-- sweet alert -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
 <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>

</head>
<body>
<div class="container mt-2">
<div class="row">
<div class="col-lg-12 margin-tb">
<div class="pull-left">
<h2>Laravel 8 Ajax CRUD DataTables Tutorial</h2>
</div>
<div class="pull-right mb-2">
	<a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Company</a>
	<a class="btn btn-warning" href="{{ route('export') }}">Export User Data</a>
</div>
</div>
</div>
<div class="card-body">
<table class="table table-bordered" id="ajax-crud-datatable">
<thead>
<tr>
<th>Id</th>
<th>Name</th>
<th>Email</th>
<th>Address</th>
<th>Created at</th>
<th>Action</th>
</tr>
</thead>
</table>
</div>
</div>
<!-- boostrap company model -->
<div class="modal fade" id="company-modal" aria-hidden="true">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<h4 class="modal-title" id="CompanyModal"></h4>
</div>
<div class="modal-body">
<form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
<input type="hidden" name="id" id="id">
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Company Name</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="name" name="name" placeholder="Enter Company Name" maxlength="50" >
<div class="text-danger" id="name_error"></div>
</div>
</div>  
<div class="form-group">
<label for="name" class="col-sm-2 control-label">Company Email</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="email" name="email" placeholder="Enter Company Email" maxlength="50" >
<div class="text-danger" id="email_error"></div>
</div>
</div>
<div class="form-group">
<label class="col-sm-2 control-label">Company Address</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="address" name="address" placeholder="Enter Company Address" >
<div class="text-danger" id="address_error"></div>
</div>
</div>
<div class="col-sm-offset-2 col-sm-10">
<button type="submit" class="btn btn-primary" id="btn-save">Save changes
</button>
</div>
</form>
</div>
<div class="modal-footer">
</div>
</div>
</div>
</div>
<!-- end bootstrap model -->
</body>
<script type="text/javascript">
$(document).ready( function () {
$.ajaxSetup({
headers: {
'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
}
});
$('#ajax-crud-datatable').DataTable({
processing: true,
serverSide: true,
ajax: "{{ url('ajax-crud-datatable') }}",
columns: [
{ data: 'id', name: 'id' },
{ data: 'name', name: 'name' },
{ data: 'email', name: 'email' },
{ data: 'address', name: 'address' },
{ data: 'created_at', name: 'created_at' },
{data: 'action', name: 'action', orderable: false},
],
order: [[0, 'desc']]
});
});
function add(){

$('.text-danger').empty(); 

$('#CompanyForm').trigger("reset");
$('#CompanyModal').html("Add Company");
$('#company-modal').modal('show');
$('#id').val('');
}   
function editFunc(id){
$.ajax({
type:"POST",
url: "{{ url('edit-company') }}",
data: { id: id },
dataType: 'json',
success: function(res){
$('#CompanyModal').html("Edit Company");
$('#company-modal').modal('show');
$('#id').val(res.id);
$('#name').val(res.name);
$('#address').val(res.address);
$('#email').val(res.email);
}
});
}  
function deleteFunc(id) {
    swal({
        title: "Delete?",
        text: "Please ensure and then confirm!",
        type: "warning",
        showCancelButton: !0,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: !0
    }).then(function (e) {

        if (e.value === true) {

            $.ajax({
                type: 'POST',
                url: "{{url('delete-company')}}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				data: { id: id },
                dataType: 'JSON',
                success: function (results) {

                    if (results.success === true) {
                    	var oTable = $('#ajax-crud-datatable').dataTable();
						oTable.fnDraw(false);
                        swal("Done!", results.message, "success");
                    } else {
                        swal("Error!", results.message, "error");
                    }
                }
            });

        } else {
            e.dismiss;
        }

    }, function (dismiss) {
        return false;
    })
}
$('#CompanyForm').submit(function(e) {
e.preventDefault();
var formData = new FormData(this);
$.ajax({
type:'POST',
url: "{{ url('store-company')}}",
data: formData,
cache:false,
contentType: false,
processData: false,
success: (data) => {
swal("Success", "Data Saved Successfully", "success");
$("#company-modal").modal('hide');
var oTable = $('#ajax-crud-datatable').dataTable();
oTable.fnDraw(false);
$("#btn-save").html('Submit');
$("#btn-save"). attr("disabled", false);

$('.text-danger').empty();

},
error:function(data){
      console.log(data);
      if(data.responseJSON.errors.name){
        $('#name_error').text(data.responseJSON.errors.name);
      }else{
        $('#name_error').empty();
      }
      if(data.responseJSON.errors.email){
         $('#email_error').text(data.responseJSON.errors.email);
       }else{
         $('#email_error').empty(); 
       }
       if(data.responseJSON.errors.address){
         $('#address_error').text(data.responseJSON.errors.address);
       }else{
         $('#address_error').empty();
       }
     
    }
});
});
</script>
</html>