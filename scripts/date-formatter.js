const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

function formatDateTime(datetimeString) {
    // Convert the space to a 'T' to create an ISO-compatible datetime string
    const isoString = datetimeString.replace(" ", "T");
    const date = new Date(isoString);

    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    // Get hours, minutes, seconds for the time portion
    let hours = date.getHours();
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    const ampm = hours >= 12 ? "PM" : "AM";

    // Convert to 12-hour format
    hours = hours % 12;
    hours = hours === 0 ? 12 : hours;

    // Format minutes and seconds to always have two digits
    const paddedMinutes = minutes < 10 ? "0" + minutes : minutes;
    const paddedSeconds = seconds < 10 ? "0" + seconds : seconds;

    const formattedDate = `${month} ${day}, ${year}`;
    const formattedTime = `${hours}:${paddedMinutes}:${paddedSeconds} ${ampm}`;

    return `${formattedDate} - ${formattedTime}`;
}

function formatDateOnly(datetimeString) {
    const isoString = datetimeString.replace(" ", "T");
    const date = new Date(isoString);

    const month = months[date.getMonth()];
    const day = date.getDate();
    const year = date.getFullYear();

    const formattedDate = `${month} ${day}, ${year}`;
    return `${formattedDate}`;
}

function formatTimeOnly(datetimeString) {
    const isoString = datetimeString.replace(" ", "T");
    const date = new Date(isoString);

    let hours = date.getHours();
    const minutes = date.getMinutes();
    const seconds = date.getSeconds();
    const ampm = hours >= 12 ? "PM" : "AM";

    hours = hours % 12;
    hours = hours === 0 ? 12 : hours;

    // Format minutes and seconds to always have two digits
    const paddedMinutes = minutes < 10 ? "0" + minutes : minutes;
    const paddedSeconds = seconds < 10 ? "0" + seconds : seconds;

    const formattedTime = `${hours}:${paddedMinutes}:${paddedSeconds} ${ampm}`;

    return `${formattedTime}`;
}