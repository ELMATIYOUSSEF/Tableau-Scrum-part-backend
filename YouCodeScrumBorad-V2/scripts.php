<?php

    //INCLUDE DATABASE FILE
    include('database.php');
    //SESSSION IS A WAY TO STORE DATA TO BE USED ACROSS MULTIPLE PAGES
    session_start();
    //ROUTING
    if(isset($_POST['save']))   saveTask($connection);
    
    // function get Tasks 
    function getTasks($connection,$St)
    {
        //SQL SELECT
        $Query = "SELECT tasks.id ,tasks.title, types.name as typeT, statuses.name as statusT , priorities.name as Prioritie , tasks.task_datetime as dateT , tasks.description as descP FROM (((tasks INNER JOIN types ON tasks.type_id= types.id)INNER JOIN priorities ON tasks.priority_id = priorities.id)INNER JOIN statuses ON tasks.status_id=statuses.id);";
        //CODE HERE
        $query=mysqli_query($connection, $Query) ;
        while($rows=mysqli_fetch_assoc($query) ){
            if($rows['statusT']===$St){
            
            echo '<a class="text-decoration-none " href="modle.php?id=' .$rows['id'].'"?>
            <button class="w-100  border-bottom rounded-bottom clr border-0 d-flex btntash ">
            <div class="col-1 mt-4">
            <i class="fa fa-id-card " text-success aria-hidden="true"></i>
            </div>
            <div class="col d-flex flex-column text-wrap justify-content-start align-items-start">
                <div class="fs-5 w-100 over text-start">'. $rows['title'].' </div>
                <div class="m-2">
                    <div class="text-start">#<span id="idTaskTodo">' .$rows['id'].' </span>' .$rows['dateT'].'</div>
                    <div class="text-start over description" title="'.$rows['descP'].'">'.$rows['descP'].'</div>
                </div>
                <div class="m-2">
                    <span class="btn-sm btn-primary">' .$rows['Prioritie'].'</span>
                    <span class="btn-sm btn-secondary">' .$rows['typeT'].'</span>
                </div>
            </div>
        </button> </a>' ;
      
            }
        }
    }
    // function save Task 
    function saveTask($connection)
    {
        //CODE HERE
        $title =$_POST['title'];
        $type_id =intval($_POST['task-type']);
        $priority =intval ($_POST['priority']);
        $status_id =intval($_POST['status']);
        $task_datetime =$_POST['task_datetime'];
        $description =$_POST['description'];
        //SQL INSERT
        if($connection -> connect_error){
            die('Connection Failed : '. $connection->connect_error);
        }else{
        $stmt=$connection->prepare("insert into tasks(title,type_id, priority_id, status_id, task_datetime, description)
            values(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiss",$title, $type_id, $priority, $status_id, $task_datetime, $description);
        $stmt->execute();
        $stmt->close();
        $connection->close();
        }
        $_SESSION['message'] = "Task has been added successfully !";
		header('location: index.php');
    }
    // function Count Task 
    function countTask($connection , $n){
        // SQL Count 
        $query = "SELECT COUNT(tasks.id) as countT from tasks WHERE tasks.status_id = $n ;";
        $result = mysqli_query($connection,$query);
        $count=mysqli_fetch_assoc($result);
        echo $count['countT'] ;
    }

?>