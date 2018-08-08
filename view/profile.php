<?php

include("connect.php");
include("functions.php");

if(!logged_in())
{
	header("location:login.php");
	exit();
}
function profile_image_show(){
	$filesearch = $_SESSION['username'];
	$files = glob("img/*".$filesearch."*");
	if(count($files)>0) {
		foreach($files as $kk){return($kk);}
	}
	else return "pro.jpg";
}
?>
<!doctype html>
<html>
<head>
	<title> Docker App - Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="profile.css">
	<link rel="icon" href="icon.png" />
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

			  <script>

			  $(document).ready(function() {
			    $("#datepicker1").datepicker();
		  });
			   $(document).ready(function() {
			    $("#datepicker2").datepicker();
		  });

		function pinned(id){
					$.ajax({
						type:'GET',
						url : 'pinned.php',
						data :{'id':id},
						success : function(data){
							$("#show-tasks").html(data);
						}
					});
		}
		$(document).ready(function(){
			$(document).on('click','#genre',function(){
				var genre = $('#genre').val();
				if(genre == 'new-genre'){
					$('#add-new-genre').html('<input id="new-genre" type="text" placeholder="Enter genre here.." name="genre" class="add" maxlength="255" ><br>');
				}
				else{
					$('#add-new-genre').html('');
				}
			});
		});
		$(document).ready(function() {
			var len = 0;
			var maxchar = 255;
			$( "#remainingC" ).html( "Remaining characters: " +"255" );
			$( '#new-task' ).keyup(function(){
				len = this.value.length
				if(len > maxchar){
					return false;
				}
				else if (len > 0) {
					$( "#remainingC" ).html( "Remaining characters: " +( maxchar - len ) );
				}
				else {
					$( "#remainingC" ).html( "Remaining characters: " +( maxchar ) );
				}
			})
		});

		$(document).ready(function(){
			$(document).on('click','#sortby-genre',function(){
				var sortby = $('#sortby-genre').val();
				$.ajax({
					type:'POST',
					url : 'remove.php',
					data :{'genre':sortby},
					success : function(data){
						$("#show-tasks").html(data);
					}
				});
			});
		});

		function remove(id){
			var sortby = $('#sortby-genre').val();
			$.ajax({
				type:'POST',
				url : 'remove.php',
				data :{'id':id,'genre':sortby},
				success : function(data){
					$("#show-tasks").html(data);
				}
			});
		}
		function edit(id){
			$.ajax({
				type:'GET',
				url : 'edit.php',
				data :{'id':id},
				success : function(data){
					$("#add-edit").html(data);
				}
			});
		}

		$(document).ready(function(){
			$(document).on('click','#add-task',function(){
				var task = $('#new-task').val();
				var dateofcreation = $('#datepicker1').val();
				var dateofcompletion = $('#datepicker2').val();
				var genre = $('#genre').val();
				if(genre == 'new-genre'){
					genre = $('#new-genre').val();
				}
				if(genre == '' || genre == undefined){
					genre = 'general';
					window.alert('You can add a genre if you like. I won\'t mind.');
							// return;
				}
				var options = document.getElementById('genre').getElementsByTagName('option');
				var i;
			 	var flag = true;
				for (i = 0; i < options.length; i++) {
		    			if(options[i].getAttribute('value') == genre){
		    				$('#genre').val(genre);
		    				flag = false;
		    			}
					}

				if(flag){
					$('#genre').append('<option selected="selected" value='+genre+'>'+genre+'</option>');
					$('#sortby-genre').append('<option selected="selected" value='+genre+'>'+genre+'</option>');
				}
				$('#add-new-genre').html('');
				var id  = $('#task-id').val();
				var sortby = $('#sortby-genre').val();
				if(task!=''){
					if(id!=''){
						/*  For Editing Notes   */
						$.ajax({
							type:'POST',
							url : 'add.php',
							data :{'task':task,'id':id,'genre':genre,'sortby':sortby,'dateofcreation':dateofcreation,'dateofcompletion':dateofcompletion},
							success : function(data){
								$("#show-tasks").html(data);
							}
						});
					}
					else{
						/* For Adding New Notes */
						$.ajax({
							type:'POST',
							url : 'add.php',
							data :{'task':task,'genre':genre,'sortby':sortby,'dateofcreation':dateofcreation,'dateofcompletion':dateofcompletion},
							success : function(data){
								$("#show-tasks").html(data);
							}
						});
					}
				}
				else{
					window.alert("Seems like you are trying to add an EMPTY task !!!!!!");
				}
				$("#new-task").val('');
				$("#task-id").val('');
				$("#add-task").val('add-task');
			});
		});

		$(document).ready(function(){
			$('#images').on("change",function (event){
				var form = document.querySelector('form');
				var formdata =new FormData(form);
				var file = event.target.files[0];

				if(!file.type.match('image/.*')){
					window.alert( "Only Image formats are allowed.");
					return;
				}
				if(file.size >= 2*1024*1024){
					window.alert("Seems like you are trying to upload a very BIG file. ("+parseInt(file.size/1024/1024)+" mb)(File Limit : 2 mb)");
					return;
				}

				if (formdata) {
					$.ajax({
						url: "upload.php",
						type: "POST",
						data: formdata,
						processData: false,
						contentType: false,
						success: function (res) {
							document.getElementById("profile-image").innerHTML = res;
						}
					});
				}
			});
		});


	</script>
</head>
<body>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="#"><img src="icon.png"  style="position:relative; top:-20%; width:25pt; height:25pt;"></a>
			</div>
			<ul class="nav navbar-nav navbar-left">
				<li><a href="#" style="font-size:15pt;"> Docket | Make your Life productive once again.</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li><a href="changepassword.php"><span class="glyphicon glyphicon-lock"></span> Change Password</a></li>
				<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
			</ul>
		</div>
	</nav>

	<div class="window">
		<div class="overlay"></div>
		<div class="box header">
				<div id="profile-image">
					<img src="pro.png">
				</div>

			<h2><?php echo $_SESSION['firstname']." ".$_SESSION['lastname']; ?></h2>
			<h4><?php echo  "@".$_SESSION['username']; ?></h4>
		</div>
		<div class="box footer">
			<div id="add-edit">
				<input id="task-id" hidden value="">
				<select  id='genre' name="genre" class='form-control' style="background-color: #cbe07d">
					<?php
					$name  = $_SESSION['username'];
					$sqlresult = mysqli_query($con, "SELECT distinct(genre) FROM tasks WHERE name = '$name'") or die ("Unable to query genre tasks");
					while($Row = mysqli_fetch_array($sqlresult)){
						echo "<option value='".$Row['genre']."'>".$Row['genre']."</option>";
					}
					?>
					<option value='new-genre'>Add New</option>
				</select>

				<div class="wrap">
					<span id = 'add-new-genre'></span>
					
					<input id="new-task" type="text" placeholder="Enter task here.." name="task" class="add" maxlength="255" >
					<span id='remainingC'></span>
					<br/><input id="datepicker1" type="text" placeholder="Date of Creation" name="dateofcreation"/>
					<br/>
					<br/><input id="datepicker2" type="text" placeholder="Date of Completion" name="dateofcompletion"/>
					
					<!-- <div class="bg"></div> -->
				</div>
                               <br><br>
				<input id="add-task" type="submit"  class="btn"  name="submit" value="add-task" />
			</div>
		</div>
	</div>


	<div class="material-wrap">
		<div class="material clearfix">
			<div class="top-bar">
				
				<span class="title">Tasks</span>
			</div>
			<div class="profile">
					<img src="taskbg.jpg" width=100% height="175px">
			</div>
			<div class="tabs clearfix">
				<a href="#" style="position: relative; top: -10px;">Your Tasks</a>
			</div>
				<select id = 'sortby-genre' name="Sort By" class = "form-control" style="background-color: #e2b883">
					<option value = 'All' >All</option>
					<?php
					$name  = $_SESSION['username'];
					$sqlresult = mysqli_query($con, "SELECT distinct(genre) FROM tasks WHERE name = '$name'") or die ("Unable to query genre tasks");
					while($Row = mysqli_fetch_array($sqlresult)){
						echo "<option value='".$Row['genre']."'>".$Row['genre']."</option>";
					}
					?>
				</select>

			<div class="tabs-content">
				<div class="friend-list">
					<div class="list-ul">
						<div id="show-tasks">
							<?php
							$name = $_SESSION['username'];
							$genre = 'general';

							$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE name='$name' and pin=1 ORDER BY task");

														while($Row = mysqli_fetch_array($sqlresult)){
															$id = $Row['id'];
															echo "<div class='list-li clearfix'>
															<div class='info pull-left'>
															<div class='name'>".$Row['task']."<br> Date of Creation : ".$Row['dateofcreation']."</div>
															</div><p class='name'><br> Date of Completion : ";
															echo $Row['dateofcompletion'];
          													echo '</p><div class="action pull-right"><a id="edit_task"  onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
															echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star"></i></a>';
															echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a></div></div>';

							}

							$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE name='$name' and pin=0 ORDER BY task");

							while($Row = mysqli_fetch_array($sqlresult)){
								$id = $Row['id'];
								echo "<div class='list-li clearfix'>
								<div class='info pull-left'>
								<div class='name'>".$Row['task']."<br>Date of Creation : ".$Row['dateofcreation']."</div>
								</div><p class='name'><br><br>&nbsp;&nbsp;Date of Completion : ";
															echo $Row['dateofcompletion'];
          													echo '</p><div class="action pull-right"><a id="edit_task"  onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
								echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star-o"></i></a>';
								echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a></div></div>';

							}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>
</html>
