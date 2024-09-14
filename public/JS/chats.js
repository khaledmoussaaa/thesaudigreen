document.addEventListener("livewire:init", () => {
    Livewire.on("scrollBottom", () => {
        getScroll(); // Call your scroll function here
    });
});

document.addEventListener("livewire:init", () => {
    Livewire.on("messageMatched", () => {
        messageMatch();
    });
});
// ==============================================================//
// When refreshed get scrollBottom
window.addEventListener("DOMContentLoaded", () => {
    getScroll();
});

// Get scroll bottom in innerChats
function getScroll() {
    // Get the chat window element
    setTimeout(() => {
        let chatWindow = document.querySelector(".conversation-container");
        chatWindow.scrollTop = chatWindow.scrollHeight;
    }, 300);
}
// ==============================================================//
// View search when clicked
function searchView() {
    const search = document.querySelectorAll(".searchingChats");
    search.forEach((element) => {
        element.classList.toggle("visibile");
    });
}
// ==============================================================//
// Files Custome
function attatchment() {
    var attatchments = document.querySelector(".fileChoose");
    var fileSelect = document.querySelectorAll(".fileSelect");
    attatchments.classList.toggle("showFiles");
    fileSelect.forEach((file) => {
        file.addEventListener("click", () => {
            attatchments.classList.remove("showFiles");
        });
    });
}
// ==============================================================//
//Model Photo
function openPhotoModal(photoUrl) {
    var modal = document.getElementById("photoModal");
    var modalImg = document.getElementById("modalPhoto");
    modal.style.display = "block";
    modalImg.src = photoUrl;
}

//Close Photo
function closePhotoModal() {
    var modal = document.getElementById("photoModal");
    modal.style.display = "none";
}
// ==============================================================//
function chatsMobileView() {
    var chatHome = document.querySelector(".chatHome");
    chatHome.classList.add("open");
}
