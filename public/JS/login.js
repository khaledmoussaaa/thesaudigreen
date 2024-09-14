// ==============================================================//
// Open Login
function openLogin() {
    const home = document.querySelectorAll(".open");
    home.forEach((page) => {
        page.classList.add("active");
    });
    localStorage.setItem("login", "enabled");
}

function backHome() {
    const home = document.querySelectorAll(".open");
    home.forEach((page) => {
        page.classList.remove("active");
    });
    localStorage.setItem("login", "disabled");
}

const isLoginEnabled = localStorage.getItem("login");

if (isLoginEnabled === null || isLoginEnabled === "disabled") {
    backHome();
} else {
    openLogin();
}
// ==============================================================//
// Language dropdwon
function changeLang() {
    var langList = document.querySelector(".dropItem");
    langList.classList.toggle("change");
}
