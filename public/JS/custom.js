// // Loading
// window.addEventListener("load", function () {
//     document.querySelector(".loader").style.display = "none";
// });
// ==============================================================//
// Language dropdwon
function changeLang() {
    var langList = document.querySelector(".dropItem");
    langList.classList.toggle("change");
}
// ==============================================================//
// Menu toggle
function toggle_active() {
    toggleActive = document.querySelectorAll(".toggleActive");
    toggleActive.forEach((element) => {
        element.classList.toggle("toggle");
    });
}
// ==============================================================//
// Sidebar effect
function sidebar_active() {
    sideActive = document.querySelectorAll(".sideActive");
    sideActive.forEach((element) => {
        element.classList.toggle("active");
    });
}

// ==============================================================//
//Play notificaiotns sound
document.addEventListener("livewire:initialized", function () {
    Livewire.on("play", function () {
        let url = "../Sounds/Sound.mp3";
        let notification = new Audio(url);
        notification.play();
    });
});
// ==============================================================//
function notification() {
    var notificaion = document.querySelector(".notificaionContainer");
    notificaion.classList.toggle("openNotification");

    var close = document.getElementById("close");
    close.addEventListener("click", () => {
        notificaion.classList.remove("openNotification");
    });
}

function makeAlert() {
    var count = document.getElementById("count");
    if (count.innerText != 0) {
        count.setAttribute("class", "dot bell-dot");
    }
}
setInterval(makeAlert, 1);
