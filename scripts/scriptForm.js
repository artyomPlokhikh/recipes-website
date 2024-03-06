document.addEventListener('DOMContentLoaded', function () {

    var password = document.getElementById("password")
    var confirmPassword = document.getElementById("confirmPassword")
    var regForm = document.getElementById("regForm")

    var locked = document.getElementById("locked")
    var unlocked = document.getElementById("unlocked")
    var lockedConfirm = document.getElementById("lockedConfirm")
    var unlockedConfirm = document.getElementById("unlockedConfirm")


    function togglePasswordVisibility(inputElement, lockedIcon, unlockedIcon) {
        if (inputElement.getAttribute("type") === "password") {
            lockedIcon.style.display = "none";
            unlockedIcon.style.display = "block";
            inputElement.setAttribute("type", "text");
        } else {
            unlockedIcon.style.display = "none";
            lockedIcon.style.display = "block";
            inputElement.setAttribute("type", "password");
        }
    }


    locked.addEventListener("click", function() {
        togglePasswordVisibility(password, locked, unlocked);
    });

    unlocked.addEventListener("click", function() {
        togglePasswordVisibility(password, locked, unlocked);
    });

    lockedConfirm.addEventListener("click", function() {
        togglePasswordVisibility(confirmPassword, lockedConfirm, unlockedConfirm);
    });

    unlockedConfirm.addEventListener("click", function() {
        togglePasswordVisibility(confirmPassword, lockedConfirm, unlockedConfirm);
    });


    regForm.addEventListener("submit", function () {
        if (password.value !== confirmPassword.value) {
        alert("Passwords do not match. Please try again.");
        event.preventDefault();
        }
    })

})