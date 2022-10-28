<?php 
     function check()
     {

     }
    function update()
    {
        require "database.php";
        if (isset($_GET['id']))
            {
                $id = $_GET['id'];
                $sql = "SELECT tasks.id as id , tasks.title as title, tasks.task_datetime as dateT , tasks.description as descpT , types.name as typeTask , statuses.id as statusT ,statuses.name as statusTName , priorities.id as PrioritieT , priorities.name as PrioritieTName from (((tasks INNER JOIN types ON tasks.type_id = types.id ) INNER JOIN statuses on statuses.id = tasks.status_id ) INNER JOIN priorities on priorities.id = tasks.priority_id ) WHERE tasks.id = $id";

                $result = $connection->query($sql);
                $result = $result->fetch_assoc();
                
                $_SESSION['id'] = $id;
                $connection->close();
                return $result;
            } 
            else echo ' id is null';
    }
    $result = update();
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
				<form action="scripts.php" method="POST" >
					<div class="modal-header">
						<h4 class="modal-title">Up Date</h4>
						<!-- <a href="#" class="btn-close" data-bs-dismiss="modal"></a> -->
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
								<select class="form-select" value="<?php echo $result['priority_id'] ?>"  name="priority" id="task-priority"required>
									<option value="<?php echo $result['PrioritieT'] ?>"  ><?php echo $result['PrioritieTName'] ?></option>
									<option value="1">Low</option>
									<option value="2">Medium</option>
									<option value="3">High</option>
									<option value="4">Critical</option>
								</select>
							</div>
							<div class="mb-3">
								<label class="form-label">Status</label>
								<select class="form-select" value="<?php echo $result['statusT'] ?>"  name="status" id="task-status" required>
                                <option value="<?php echo $result['statusT'] ?>"><?php echo $result['statusTName'] ?></option>
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
						<a href="#" class="btn btn-white" data-bs-dismiss="modal">Cancel</a>
						<button type="submit" name="update" class="btn btn-warning task-action-btn" id="task-update-btn">Update</a>
						<button type="submit" name="save" class="btn btn-primary task-action-btn" id="task-save-btn">Save</button>
					</div>
				</form>	
	<!-- ================== BEGIN core-js ================== -->
	<script src="assets/js/vendor.min.js"></script>
	<script src="assets/js/app.min.js"></script>
	<!-- ================== END core-js ================== -->
	<script src="scripts.js"></script>

	<script>
		//reloadTasks();
	</script>

</body>
</html>