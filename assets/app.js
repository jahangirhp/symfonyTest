/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

console.log('This log comes from assets/app.js - welcome to AssetMapper! 🎉');

document.getElementById("sendBtn").addEventListener("click", function() {
    // Read value from input
    const inputText = document.getElementById("iBAN").value;

    // Send to Symfony controller via fetch
    fetch('/bank/validation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ IBAN: inputText })
    })
        .then(response => response.json())
        .then(data => {
            // Show response in a div
            document.getElementById("response").innerText =  data["msg"];
        })
        .catch(error => console.error('Error:', error));
});


