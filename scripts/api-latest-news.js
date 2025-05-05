const url = 'https://api.worldnewsapi.com/top-news?source-country=ph';
// https://api.worldnewsapi.com/top-news?source-country=ph
const apiKey = 'myapikey';

fetch(url, {
    method: 'GET',
    headers: {
        'x-api-key': apiKey
    }
})
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => console.log(data))
    .catch(error => console.error('There was a problem with the fetch operation:', error));
