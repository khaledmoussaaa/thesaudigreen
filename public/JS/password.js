// Appear password inputs
document.addEventListener('DOMContentLoaded', function() {
    togglePasswordVisibility();
});

function togglePasswordVisibility() {
    const passwordSection = document.getElementById('passwordSection');
    const confirmPasswordSection = document.getElementById('confirmPasswordSection');
    const isChecked = document.getElementById('showPassword').checked;

    console.log(isChecked);
    
    if (isChecked) {
        passwordSection.style.display = 'block';
        confirmPasswordSection.style.display = 'block';
    } else {
        passwordSection.style.display = 'none';
        confirmPasswordSection.style.display = 'none';
    }
}