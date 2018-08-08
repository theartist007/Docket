<?php
include ("connect.php");
include("functions.php");
if(!logged_in())("Location: login.php");

  if(isset($_POST['id'])){
    $id = $_POST['id'];
    $sql="DELETE FROM tasks WHERE id='$id'";
    $result = mysqli_query($con, $sql) or die("Unable to delete database entry.");
  }

  $name = $_SESSION['username'];
  $query = "SELECT * FROM tasks WHERE name='$name' and pin=1 ORDER BY task";
  if(isset($_POST['genre']) && $_POST['genre']!='All'){
    $genre = $_POST['genre'];
    $query = "SELECT * FROM tasks WHERE name='$name' and genre = '$genre' and pin=1 ORDER BY task";
  }
  $sqlresult = mysqli_query($con, $query) or die ("Unable to query tasks");

  while($Row = mysqli_fetch_array($sqlresult)){
   $id = $Row['id'];
   echo "<div class='list-li clearfix'>
   <div class='info pull-left'>
                  <div class='name'>".$Row['task']."<br>Date of Creation : ".$Row['dateofcreation']."</div>
                 </div><p class='name'><br><br>&nbsp;&nbsp;Date of Completion : ";
                              echo $Row['dateofcompletion'];
                                    echo '</p><div class="action pull-right"><a id="edit_task"  onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
                  echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star"></i></a>';
                  echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a></div></div>';
 }

   $query = "SELECT * FROM tasks WHERE name='$name' and pin=0 ORDER BY task";
   if(isset($_POST['genre']) && $_POST['genre']!='All'){
     $genre = $_POST['genre'];
     $query = "SELECT * FROM tasks WHERE name='$name' and genre = '$genre' and pin=0 ORDER BY task";
   }
   $sqlresult = mysqli_query($con, $query) or die ("Unable to query tasks");

   while($Row = mysqli_fetch_array($sqlresult)){
    $id = $Row['id'];
    echo "<div class='list-li clearfix'>
    <div class='info pull-left'>
                  <div class='name'>".$Row['task']."<br>Date of Creation : ".$Row['dateofcreation']."</div>
                  </div><p class='name'><br><br>&nbsp;&nbsp;Date of Completion : ";
                              echo $Row['dateofcompletion'];
                                    echo '</p><div class="action pull-right"><a id="edit_task"  onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
                  echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star"></i></a>';
                  echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a></div></div>';
  }


 ?>
