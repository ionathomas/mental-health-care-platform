//verify same confirm password.
const password = document.getElementById("register-password");
const confirmPassword = document.getElementById("register-confirm-password");
const cPassword = document.getElementById("login-password");
const toggleViewPassword = document.getElementById("register-see-password");
const toggleViewvPassword = document.getElementById("register-see-password");
const toggleViewConfirmPassword = document.getElementById("register-see-confirm-password");

[password, confirmPassword].forEach((passwordField) => {
    passwordField.addEventListener("input", (event) => {
        if (password.value !== confirmPassword.value) {
            const error = "Make sure password and confirmed password are the same."
            confirmPassword.setCustomValidity(error);
        }
        else {
            const noError = "";
            confirmPassword.setCustomValidity(noError);
        }
    });
});

//toggle password view
toggleViewPassword.addEventListener("click", (event) => {
    const passwordVisibleType = "text";
    const passwordInvisibleType = "password";
    
    const shouldPasswordBeVisible = password.type == passwordInvisibleType;
    const visibility = shouldPasswordBeVisible ? passwordVisibleType : passwordInvisibleType;

    password.type = visibility;
    // confirmPassword.type = visibility;
});
toggleViewvPassword.addEventListener("click", (event) => {
    const passwordVisibleType = "text";
    const passwordInvisibleType = "password";
    
    const shouldPasswordBeVisible = password.type == passwordInvisibleType;
    const visibility = shouldPasswordBeVisible ? passwordVisibleType : passwordInvisibleType;

    cPassword.type = visibility;
    // confirmPassword.type = visibility;
});
toggleViewConfirmPassword.addEventListener("click", (event) => {
    const passwordVisibleType = "text";
    const passwordInvisibleType = "password";
    
    const shouldPasswordBeVisible = confirmPassword.type == passwordInvisibleType;
    const visibility = shouldPasswordBeVisible ? passwordVisibleType : passwordInvisibleType;

    // password.type = visibility;
    confirmPassword.type = visibility;
});