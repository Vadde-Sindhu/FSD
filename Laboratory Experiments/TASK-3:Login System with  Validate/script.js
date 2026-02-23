function validateForm() {
    let user = document.getElementById("username").value;
    let pass = document.getElementById("password").value;
    let error = document.getElementById("error");

    if (user === "" || pass === "") {
        error.innerHTML = "⚠️ All fields are required";
        return false;
    }

    return true;
}
