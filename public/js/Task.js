

function addTask(){
    // Read value from input
    const title = document.getElementById("taskTitle").value;
    const description = document.getElementById("taskDsc").value;

    // Send to Symfony controller via fetch
    fetch('/job/task/add', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ title: title,description:description })
    })
        .then(response => response.json())
        .then(data => {
            callListTasks();
            document.getElementById("result").innerText =  data["message"];
        })
        .catch(error => console.error('Error:', error));
}
function callListTasks()
{
    window.location.href = "/job/task/list";
}

function markJobDone($taskId){
    // Read value from input
    // Send to Symfony controller via fetch
    fetch('/job/task/'+$taskId, {
        method: 'PATCH',
            })
        .then(response => response.json())
        .then(data => {
            callListTasks();
            document.getElementById("result").innerText =  data["message"];
        })
        .catch(error => console.error('Error:', error));
}

function deleteTask($taskId){
    // Read value from input
    // Send to Symfony controller via fetch
    fetch('/job/task/'+$taskId, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            callListTasks();
            document.getElementById("result").innerText =  data["message"];
        })
        .catch(error => console.error('Error:', error));
}

