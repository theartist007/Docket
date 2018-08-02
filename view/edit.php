<?php
include ("connect.php");
include("functions.php");
if(!logged_in())("Location: login.php");

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE id='$id'") or die ("Unable to query tasks");
$res = mysqli_fetch_array($sqlresult);
$task = $res['task'];
$dateofcreation = $res['dateofcreation'];
$dateofcompletion = $res['dateofcompletion'];
echo '
        <input id="task-id" hidden value="'.$id.'">
                <select  id="genre" name="genre" class="form-control" style="background-color: #cbe07d">';
                    $name  = $_SESSION['username'];
                    $sqlresult = mysqli_query($con, "SELECT distinct(genre) FROM tasks WHERE name = '$name'") or die ("Unable to query genre tasks");
                    while($Row = mysqli_fetch_array($sqlresult)){
                        if($Row['genre'] == $res['genre'])
                            echo "<option selected='selected' value='".$Row['genre']."'>".$Row['genre']."</option>";
                        else
                            echo "<option value='".$Row['genre']."'>".$Row['genre']."</option>";
                    }
                    echo'
                    <option value="new-genre">Add New</option>
                </select>

                <div class="wrap">
                    <span id = "add-new-genre"></span>
                    <br/>
                    <input id="new-task" type="text" placeholder="Enter task here.." name="task" class="add" maxlength="255" value = "'.$task.'">
                    <span id="remainingC"></span>
                   <br/>
					<br/><input id="datepicker1" type="text" placeholder="Date of Creation" value="'.$dateofcreation.'" />
					<br/>
                    <input id="datepicker2" type="text" placeholder="Date of Completion" value="'.$dateofcompletion.'" />
                    <br/>
                    <!-- <div class="bg"></div> -->
                </div>
                <br><br>
                <input id="add-task" type="submit"  class="btn"  name="submit" value="edit-task" />

';

?>

<script>
$(document).ready(function() {

    var len = document.getElementById('new-task').value.length;
    var maxchar = 255;

    $('#remainingC').html("Remaining characters: " + (maxchar - len));
    $('#new-task').keyup(function() {
        len = this.value.length
        if (len > maxchar) {
            return false;
        } else if (len > 0) {
            $("#remainingC").html("Remaining characters: " + (maxchar - len));
        } else {
            $("#remainingC").html("Remaining characters: " + (maxchar));
        }
    });

    function hello()
    {
    	console.log(this.value.length);
    }

});
 $(document).ready(function() {
		    $("#datepicker1").datepicker();
		  });
 $(document).ready(function() {
            $("#datepicker2").datepicker();
          });
</script>
