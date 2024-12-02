const passwordCheckDom = document.querySelector('#password'),
    oko = document.querySelector('#oko');

passwordCheckDom.addEventListener('input', () => {
    if (passwordCheckDom.value.trim() !== '') {
        oko.classList.remove('hide');
    } else {
        oko.classList.add('hide');
    }
});

function togglePasswordVisibility(passwordInputId, confirmPasswordInputId = null) {
    const passwordInput = document.getElementById(passwordInputId),
        confirmPasswordInput = confirmPasswordInputId ? document.getElementById(confirmPasswordInputId) : null;

    // Т toggling password visibility
    const passwordType = passwordInput.type === "password" ? "text" : "password";
    passwordInput.type = passwordType;

    if (confirmPasswordInput) {
        confirmPasswordInput.type = passwordType;
    }

    if (passwordType === "text") {
        passwordInput.setAttribute("readonly", true);
        if (confirmPasswordInput) {
            confirmPasswordInput.setAttribute("readonly", true);
        }
        oko.classList.add("activatedOko");  // Додаємо клас
    } else {
        passwordInput.removeAttribute("readonly");
        if (confirmPasswordInput) {
            confirmPasswordInput.removeAttribute("readonly");
        }
        oko.classList.remove("activatedOko");  // Видаляємо клас
    }
}
