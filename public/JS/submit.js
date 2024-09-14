(function submitForm() {
    const allForm = document.querySelectorAll(".formSubmit");
    allForm.forEach((card) => {
        card.addEventListener("click", () => {
            card.submit();
        });
    });
})();
