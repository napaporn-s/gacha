<!DOCTYPE html>
<html>
	<head>
		<title>RESTFul API CRUD</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="text-center"> <h1> RESTFul API CRUD</h1> </div>

			<div class="text-right">
				<button type="button" name="btnInsert" id="btnInsert" class="btn btn-success btn-xs">Insert</button>
			</div>

			<br>

			<div class="table-responsive">
				<table class="table table-bordered table-striped">
					<thead>
						<tr>
							<th>UserName</th>
							<th>Name</th>
							<th>SurName</th>
							<th>Email</th>
							<th>Edit</th>
							<th>Delete</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>

		<div id="CRUDModal" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<form method="post" id="CRUDForm">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Insert Data</h4>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>UserName</label>
								<input type="text" name="username" id="username" class="form-control" minlength="6" maxlength="30"/>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" name="password" id="password" class="form-control" minlength="6" maxlength="30"/>
							</div>
							<div class="form-group">
								<label>Name</label>
								<input type="text" name="name" id="name" class="form-control" />
							</div>
							<div class="form-group">
								<label>SurName</label>
								<input type="text" name="surname" id="surname" class="form-control" />
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" name="email" id="email" class="form-control" />
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" name="hidden_id" id="hidden_id" />
							<input type="hidden" name="action" id="action" value="insert" />
							<input type="submit" name="button_action" id="button_action" class="btn btn-info" value="Insert" />
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		<script type="text/javascript">
		$(document).ready(function(){

			fetch_data();

			function fetch_data() {
				$.ajax({
					url:"fetch.php",
					success:function(data)
					{
						$("tbody").html(data);
					}
				})
			}

			$("#btnInsert").click(function(){
				$("#action").val("insert");
				$("#button_action").val("Insert");
				$(".modal-title").text("Insert Data");
				$("#CRUDModal").modal("show");
			});

			$("#CRUDForm").on("submit", function(event){
				event.preventDefault();
				if($("#username").val() == "")
				{
					alert("Enter UserName");
				}
				else if($("#password").val() == "")
				{
					alert("Enter Password");
				}
				else if($("#name").val() == "")
				{
					alert("Enter Name");
				}
				else if($("#surname").val() == "")
				{
					alert("Enter SurName");
				}
				else if($("#email").val() == "")
				{
					alert("Enter Email");
				}
				else
				{
					var form_data = $(this).serialize();
					$.ajax({
						url:"action.php",
						method:"POST",
						data:form_data,
						success:function(data)
						{
							fetch_data();
							$("#CRUDForm")[0].reset();
							$("#CRUDModal").modal("hide");
							if(data == "insert")
							{
								alert("Insert Success");
							}
							if(data == "update")
							{
								alert("Update Success");
							}
						}
					});
				}
			});

			$(document).on("click", ".edit", function(){
				var id = $(this).attr("id");
				var action = "fetch_single";
				$.ajax({
					url:"action.php",
					method:"POST",
					data:{id:id, action:action},
					dataType:"json",
					success:function(data)
					{
						$("#hidden_id").val(id);
						$("#username").val(data.username);
						$("#name").val(data.name);
						$("#surname").val(data.surname);
						$("#email").val(data.email);
						$("#action").val("update");
						$("#button_action").val("Update");
						$(".modal-title").text("Update");
						$("#CRUDModal").modal("show");
					}
				})
			});

			$(document).on("click", ".delete", function(){
				var id = $(this).attr("id");
				var action = "delete";
				if(confirm("Delete this record?"))
				{
					$.ajax({
						url:"action.php",
						method:"POST",
						data:{id:id, action:action},
						success:function(data)
						{
							fetch_data();
							alert("Delete Success");
						}
					});
				}
			});

		});
		</script>

	</body>
</html>