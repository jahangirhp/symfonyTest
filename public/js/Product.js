

function callListTasks()
{
    window.location.href = "/product/admin";
}

function deleteProduct($prodId){
    // Read value from input
    // Send to Symfony controller via fetch
    fetch('/product/admin/'+$prodId, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            callListTasks();
        })
        .catch(error => console.error('Error:', error));
}

