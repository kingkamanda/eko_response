const locationInput = document.getElementById('location-input');
const searchButton = document.getElementById('search-btn');
const locationResults = document.getElementById('location-results');

function displayLocations(locations) {
  locationResults.innerHTML = '';
  locations.forEach(location => {
    const listItem = document.createElement('li');
    listItem.textContent = location;
    listItem.addEventListener('click', () => {
      selectLocation(listItem);
    });
    locationResults.appendChild(listItem);
  });
}

function selectLocation(listItem) {
  const selectedLocations = locationResults.querySelectorAll('.selected');
  selectedLocations.forEach(item => item.classList.remove('selected'));
  listItem.classList.add('selected');
  console.log('Selected Location:', listItem.textContent); // You can use this selected location for further actions
}

searchButton.addEventListener('click', () => {
  const searchTerm = locationInput.value;
  // Replace with your logic to fetch locations based on search term
  // This is a placeholder example, you can use a real location API
  const exampleLocations = ['New York, USA', 'London, UK', 'Paris, France'];
  const filteredLocations = exampleLocations.filter(location => location.toLowerCase().includes(searchTerm.toLowerCase()));
  displayLocations(filteredLocations);
});
