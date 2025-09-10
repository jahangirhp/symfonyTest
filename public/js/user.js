
function callListUsers()
{
    window.location.href = "/user/get";
}

function makeUserAdmin($userId){
    // Read value from input
    // Send to Symfony controller via fetch
    fetch('/user/admin/'+$userId, {
        method: 'PATCH',
            })
        .then(response => response.json())
        .then(data => {
            callListUsers();
        })
        .catch(error => console.error('Error:', error));
}

function deleteUser($taskId){
    // Read value from input
    // Send to Symfony controller via fetch
    fetch('/job/task/'+$taskId, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            callListTasks();
        })
        .catch(error => console.error('Error:', error));
}

