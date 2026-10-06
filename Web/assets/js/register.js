
const form = document.getElementById("registerForm");

const fullName = document.querySelector('[name="fullname"]');
const number = document.querySelector('[name="number"]');
const email = document.querySelector('[name="email"]');
const url = document.querySelector('[name="url"]');
const password = document.querySelector('[name="password"]');
const confirmPassword = document.querySelector('[name="confirm-password"]');

const nameRegex = /^[A-Za-z]+(?:[.' -]+[A-Za-z.]+)+$/;
const numberRegex = /^\+?\d{10,15}$/;
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/;

function validateFullName() {
    return nameRegex.test(fullName.value.trim());
}

function validateNumber() {
    return numberRegex.test(number.value.trim());
}

function validateEmail() {
    return emailRegex.test(email.value.trim());
}

function validateUrl() {
    try {
        const parsed = new URL(url.value.trim());
        return parsed.protocol === "http:" || parsed.protocol === "https:";
    } catch (error) {
        return false;
    }
}

function validatePassword() {
    return passwordRegex.test(password.value);
}

function validateConfirmPassword() {
    return confirmPassword.value === password.value;
}

form.addEventListener("submit", e => {
    e.preventDefault();

    const errors = [];

    if (!validateFullName()) {
        errors.push("Invalid full name (first and last name).");
    }

    if (!validateNumber()) {
        errors.push("Invalid number (10-15 digits, optional + at the start).");
    }

    if (!validateEmail()) {
        errors.push("Invalid email address.");
    }

    if (!validateUrl()) {
        errors.push("Invalid URL (must start with http:// or https://).");
    }

    if (!validatePassword()) {
        errors.push(
            "Password must be 8+ characters with a letter, number, and symbol."
        );
    }

    if (!validateConfirmPassword()) {
        errors.push("Passwords do not match.");
    }

    if (errors.length === 0) {
    register();
    } else {
    showModal("ERROR", errors);
    }
});

async function register() {
    const data = {
        fullName: fullName.value.trim(),
        number: number.value.trim(),
        email: email.value.trim(),
        url: url.value.trim(),
        password: password.value
    };

    try {
        const response = await fetch("./auth/register.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            showModal("SUCCESS", [result.message]);
            setTimeout(() => {
                window.location.href = "./index.php";
            }, 1500);
        } else {
            showModal("ERROR", [result.message]);
        }

    } catch (error) {
        showModal("ERROR", ["Unable to connect to server."]);
    }
}