<?php 
     // function update 
    if (isset($_POST['update']))
    {
        require "database.php";
        //CODE HERE
		$id = $_GET['id'];
        $title =$_POST['title'];
        $type_id =intval($_POST['task-type']);
        $priority =intval ($_POST['priority']);
        $status_id =intval($_POST['status']);
        $task_datetime =$_POST['task_datetime'];
        $description =$_POST['description'];
        //SQL UPDATE
        $sql = "UPDATE tasks
        SET title = '$title', type_id =$type_id,priority_id = $priority,status_id = $status_id,task_datetime = '$task_datetime', description = '$description'
        WHERE tasks.id = $id";
          mysqli_query($connection, $sql);
          $connection->close();
        $_SESSION['message'] = "Task has been updated successfully !";
		header('location: index.php');
		
    }
	//routing de function delete
	if (isset($_POST['delete']))
    {
		// call function delete
		deleteTask() ;
	}
	// function delete 
	function deleteTask()
        {
			require "database.php";
			$id = $_GET['id'];
			//SQL DELETE
			$Quiry = "delete from tasks where tasks.id = $id";
			//CODE HERE
			mysqli_query($connection, $Quiry) ;
			$connection->close();
			$_SESSION['message'] = "Task has been deleted successfully !";
			header('location: index.php');
			
       
        }
      // function remplaire form pour up dating tasks 
    function RemplaireFormUpDate()
    {
        require "database.php";
        if (isset($_GET['id']))
            {
                $id = $_GET['id'];
				// SQL SELECT
                $sql = "SELECT tasks.id as id , tasks.title as title, tasks.task_datetime as dateT , tasks.description as descpT , types.name as typeTask , statuses.id as statusT ,statuses.name as statusTName , priorities.id as PrioritieT , priorities.name as PrioritieTName from (((tasks INNER JOIN types ON tasks.type_id = types.id ) INNER JOIN statuses on statuses.id = tasks.status_id ) INNER JOIN priorities on priorities.id = tasks.priority_id ) WHERE tasks.id = $id";
				 //CODE HERE
                $result = $connection->query($sql);
                $result = $result->fetch_assoc();
                
                $_SESSION['id'] = $id;
                $connection->close();
                return $result;
            } 
            else echo ' id is null';
    }
    $result = RemplaireFormUpDate();
	

     ?>
<!DOCTYPE html>
<html lang="en" >
<head>
	<meta charset="utf-8" />
	<title>YouCode | Scrum Board</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	
	<!-- ================== BEGIN core-css ================== -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="assets/css/vendor.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="./style.css">
	<link href="assets/css/default/app.min.css" rel="stylesheet" />
	<!-- ================== END core-css ================== -->
</head>
<body>
	<!-- TASK MODAL -->
<
				<form action="" method="POST" >
					<div class="modal-header">
						<h4 class="modal-title">Up Date</h4>
					</div>
					<div class="modal-body">
							<!-- This Input Allows Storing Task Index  -->
							<input type="hidden" id="task-id">
							<div class="mb-3">
								<label class="form-label">Title</label>
								<input name="title" type="text" class="form-control" value="<?php echo $result['title'] ?>" id="task-title" required/>
							</div>
							<div class="mb-3">
								<label class="form-label">Type</label>
								<div class="ms-3">
									<div class="form-check mb-1">
										<input class="form-check-input" name="task-type" type="radio" value="1"
                                        <?php 
                                        if($result['typeTask']=='Feature')
                                        {
                                            echo 'checked';
                                        };
                                        ?>
                                        id="task-type-feature" />
										<label class="form-check-label" for="task-type-feature">Feature</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" name="task-type" type="radio" value="2" 
                                        <?php 
                                        if ($result['typeTask']=='Bug')
                                        {
                                            echo 'checked';
                                        };                                  
                                        ?>
                                        id="task-type-bug"/>
										<label class="form-check-label" for="task-type-bug">Bug</label>
									</div>
								</div>
								
							</div>
							<div class="mb-3">
								<label class="form-label">Priority</label>
								<select class="form-select" name="priority" id="task-priority" required>
									<option value="1">Low</option>
									<option value="2">Medium</option>
									<option value="3">High</option>
									<option value="4">Critical</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="form-label">Status</label>
								<select class="form-select"  name="status" id="task-status" required>
									<option value="1">To Do</option>
									<option value="2">In Progress</option>
									<option value="3">Done</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="form-label">Date</label>
								<input type="datetime-local" value="<?php echo $result['dateT'] ?>"  name="task_datetime" class="form-control" id="task-date" required/>
							</div>
							<div class="mb-0">
								<label class="form-label">Description</label>
								<textarea  value="<?php echo $result['descpT'] ?>" name="description" class="form-control" rows="10" id="task-description" required><?php echo $result['descpT'] ?></textarea>
							</div>
						
					</div>
					<div class="modal-footer">
						<a href="./index.php" class="btn btn-white" data-bs-dismiss="modal">Cancel</a>
						<button type="submit" name="delete" class="btn btn-danger task-action-btn" id="task-delete-btn">Delete</button>
						<button type="submit" name="update" class="btn btn-warning task-action-btn" id="task-update-btn">Update</button>

					</div>
				</form>	
	<!-- ================== BEGIN core-js ================== -->
	<script src="assets/js/vendor.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<!-- ================== END core-js ================== -->
	<script src="scripts.js"></script>
	<?php
	// j'ai utilise js pour controle la valuer de priorite est statuse a la form up date 
	echo "
				<script>
					document.getElementById('task-priority').value = ".(int)$result['PrioritieT']."
					document.getElementById('task-status').value = ".(int)$result['statusT'].";
				</script>
				";
	?>

</body>
</html>