const timeImage = document.getElementById("time-image");

function updateTimeImage() {
    const now = new Date();
    const hours = now.getHours();

    if (hours >= 5 && hours < 12) {
        // Morning or Sunrise
        timeImage.src = "time-icon/sunriseIcon.png";  
    } else if (hours >= 12 && hours < 17) {
        // Midday
        timeImage.src = "time-icon/middayIcon.png"; 
    } else if (hours >= 17 && hours < 19) {
        // Afternoon or Sunset
        timeImage.src = "time-icon/sunsetIcon.png"; 
    } else {
        // Midnight
        timeImage.src = "time-icon/midnightIcon.png"; 
    }
}

updateTimeImage();

setInterval(updateTimeImage, 3600000); 
