

function callConvertCurrency(){
    // Read value from input
    const from = document.getElementById("fromCurrency").value;
    const to = document.getElementById("toCurrency").value;
    const amount = document.getElementById("amount").value;

    // Send to Symfony controller via fetch
    fetch('/currency/convert', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ from: from,to:to,amount:amount })
    })
        .then(response => response.json())
        .then(data => {
            // Show response in a div
            document.getElementById("result").innerText =  data["result"];
        })
        .catch(error => console.error('Error:', error));
}
