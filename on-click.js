// Login Info
function enableEmailInput() {
    document.getElementById('myEmailInput').disabled = false;
}

function enablePassInput() {
    document.getElementById('myPassInput').disabled = false;
}

function disableAllInput() {
    document.getElementById("myEmailInput").disabled = true;
    document.getElementById("myPassInput").disabled = true;
}

// Change Password
function openModal() {
    document.getElementById("popupModal").style.display = "flex";
}
  
function closeModal() {
    document.getElementById("popupModal").style.display = "none";
}