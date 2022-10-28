// ---------------------------------- declaring all variable ------------------------------- //
let Priority =document.getElementById("selectProiority");
let Status =document.getElementById("selectStatus");
let save = document.querySelector(".save");
let titre = document.querySelector(".titre");
let typeValue = document.querySelector(".form-check-input:checked");
let titelValue =document.querySelector("#titel");
let date =document.getElementById("date");
let description = document.getElementById("description");
var counTasks =17;
let todoTasksBtn = document.getElementById("to-do-tasks");
let progressBtn = document.getElementById("in-progress-tasks");
let doneBtn = document.getElementById("done-tasks");
//-------------------------------------   function ClairTable     ------------------------------------ //
function clairTable()
{
    document.getElementById("to-do-tasks").innerHTML="";
    document.getElementById("in-progress-tasks").innerHTML ="";
    document.getElementById("done-tasks").innerHTML ="";
}
// ------------------------------------  call function Read Data  ------------------------ //
ReadData();
// ------------------------------------ ReadData from table tasks -----------------------//
function ReadData() {
    clairTable();
    // initialiser task form
    var countasks =0 ,countTodo=0 ,countInporgess =0 , countDone =0 ;
    for(let i = 0; i < tasks.length; i++){
        if(tasks[i].status == "To Do"){
           countTodo++;
            countasks++;
            //tasks[i].id =countasks ;
            todoTasksBtn.innerHTML += `
            <button class="w-100 border-bottom rounded-bottom clr border-0 d-flex btntash " id="task${countasks}" onclick="updatedelete(${countasks})">
            <div class="col-1 mt-4">
            <i class="fa fa-id-card " text-success aria-hidden="true"></i>
            </div>
            <div class="col d-flex flex-column justify-content-start align-items-start">
                <div class="fs-5 text-start">${tasks[i].title}</div>
                <div class="m-2">
                    <div class="text-start">#<span id="idTaskTodo">${tasks[i].id}</span>  ${tasks[i].date}</div>
                    <div class="text-start" title="${tasks[i].description}">${tasks[i].description.substring(0,50)}</div>
                </div>
                <div class="m-2">
                    <span class="btn-sm btn-primary">${tasks[i].type}</span>
                    <span class="btn-sm btn-secondary">${tasks[i].priority}</span>
                </div>
            </div>
        </button>
       `
    }else if(tasks[i].status == "In Progress"){
        countInporgess++;
        countasks++;
       // tasks[i].id =countasks ;
        progressBtn.innerHTML += `
        <button class="w-100 border-bottom clr rounded-bottom border-0 d-flex btntash" id="task${countasks}" onclick="updatedelete(${countasks})">
        <div class="col-1 mt-4">
        <i class="spinner-border spinner-border-sm" aria-hidden="true"></i>
        </div>
        <div class="col d-flex flex-column justify-content-start align-items-start">
            <div class="fs-5 text-start">${tasks[i].title}</div>
            <div class="m-2">
                <div class="text-start">#<span id="idTaskProgress">${tasks[i].id}</span>  ${tasks[i].date}</div>
                <div class="text-start" title="${tasks[i].description}">${tasks[i].description.substring(0,50)}</div>
            </div>
            <div class="m-2">
                <span class="btn-sm btn-primary">${tasks[i].type}</span>
                <span class="btn-sm btn-secondary">${tasks[i].priority}</span>
            </div>
        </div>
    </button>
   `
    }else{
        countDone++;
        countasks++;
       // tasks[i].id =countasks ;
        doneBtn.innerHTML += `
        <button class="w-100 clr rounded-bottom border-bottom border-0 d-flex btntash " id="task${countasks}" onclick="updatedelete(${countasks})">
        <div class="col-1 mt-4">
            <i class="fa fa-check" aria-hidden="true"></i>
        </div>
        <div class="col d-flex flex-column justify-content-start align-items-start">
            <div class="fs-5 text-start">${tasks[i].title}</div>
            <div class="m-2">
                <div class="text-start">#<span id="idTaskdone">${tasks[i].id}</span>  ${tasks[i].date}</div>
                <div class="text-start" title="${tasks[i].description}">${tasks[i].description.substring(0,50)}</div>
            </div>
            <div class="m-2">
                <span class="btn-sm btn-primary">${tasks[i].type}</span>
                <span class="btn-sm btn-secondary">${tasks[i].priority}</span>
            </div>
        </div>
    </button>
   `
    }
    document.getElementById("done-tasks-count").innerText = countDone ;
    document.getElementById("in-progress-tasks-count").innerText = countInporgess ;
    document.getElementById("to-do-tasks-count").innerText = countTodo ;
}  
}
///------------------------------------      create task          ------------------------------//
function createTask(){
    let btnsaveupdate = document.querySelector(".save").innerText;
    if(btnsaveupdate=='Add'){
    clairTable();
    counTasks++;
    const newTasks = {
        title:titelValue.value ,
        type: typeValue.value,
        priority: Priority.value,
        status:  Status.value,
        id:counTasks,
        date:date.value ,
        description: description.value,
    }
    if(Status=="To Do"){
      document.getElementById("to-do-tasks-count").innerText+=1;
    }
    else if(Status=="In Progress"){
        document.getElementById("in-progress-tasks-count").innerText+=1;
    }
    else{
        document.getElementById("done-tasks-count").innerText+=1;  
    }
    tasks.push(newTasks);
    close();
    ReadData();
    Swal.fire({
        position: 'center-center',
        icon: 'success',
        title: 'Your work has been saved',
        showConfirmButton: false,
        timer: 1500
      })
    }
    if(btnsaveupdate.innerText ='Update')
    {
        var idup = document.querySelector("#idup");
        update(idup.value);
        close();
        ReadData();
    }
}
// ------------------------------------   function ClearFrom()    ---------------------------//
function ClearFrom(){
    titelValue.value= '' ;
    document.querySelector("#flexRadioDefault1").checked =true;
    Status.value = '';
    Priority.value = '';
    date.value = '';
    description.value = ''
    save.innerHTML = "Add";
    titre.innerHTML = `Add Task`;
}
//-------------------------------------      function close       -------------------------- //
function close(){
    document.getElementById("btn-close").click(); 
}
//------------------------------------- function update && delete --------------------------//
function updatedelete(id){
    Swal.fire({
        title: 'Do you want to update or remove task?',
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'update',
        denyButtonText: `Delete`,
      }).then((result) => {
        //if confirmed up date
        if (result.isConfirmed) {
          $("#exampleModal").modal('show')
          Remplaireform(id);
        } else if (result.isDenied) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't To delete it !",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
              }).then((result) => {
                //if confirmed delete
                if (result.isConfirmed) {
                    deleteT(id);
                    ReadData();
                }
              })
        }
      })
}
// ------------------------------------  function search by id    --------------------------//
function search(id){
    for(let i =0 ; i<tasks.length;i++)
    {
     if(id == tasks[i].id){
        return tasks[i];
     }   
    }
}
//------------------------------------- function RemplaireForm    --------------------------//
 function Remplaireform(id){
   let obj = search(id);
   titelValue.value= obj.title ;
   checkType(obj.type);
   Status.value = obj.status;
   Priority.value = obj.priority;
   date.value = obj.date;
   description.value = obj.description
   save.innerHTML = "Update";
   titre.innerHTML = `Update id :<div> <input style="display: none ;" type="text" id="idup" value= "${obj.id}"></div>`;
 }
 //------------------------------------     function update       --------------------------//
function update(id)
{
    let pbj =search(id);
    pbj.title = titelValue.value ;
    pbj.type=typeValue.value;
    pbj.priority = Priority.value;
    pbj.status =Status.value;
    pbj.date = date.value;
    pbj.description= description.value;
    tasks[id-1]=pbj;
}
 //------------------------------------     function delete       --------------------------//
 function deleteT(id){
    tasks.splice(id-1,1);
 }
 //-------------------- function checktype of radio button for function up date ------------//
 function checkType(typeV)
 {
    if(typeV =="Bug"){
        document.querySelector("#flexRadioDefault2").checked =true;
    }
    else{
        document.querySelector("#flexRadioDefault1").checked = true;
    }
 }