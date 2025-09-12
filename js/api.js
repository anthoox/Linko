document.onload = function() {
    const apiUrl = 'https://api.example.com/data';
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            console.log('Data fetched from API:', data);
            // Process and display the data as needed
        })
        .catch(error => {
            console.error('Error fetching data from API:', error);
        }); 
};