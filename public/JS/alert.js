//Alert Message
(function alert() {
    try {
        const alert = document.querySelector(".alert");
        alert.style.visibility = "visible";
        alert.style.opacity = "1";
        setTimeout(() => {
            alert.style.opacity = "0";
            alert.style.visibility = "hidden";
        }, 3000);
    } catch (error) {
        console.log();
    }
})();
