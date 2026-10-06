const dashboardForm = document.getElementById("dashboard-form");
const editButton = document.getElementById("editButton");
const saveButton = document.getElementById("saveButton");
const welcomeName = document.getElementById("welcomeName");

const dashFullName = document.querySelector('[name="fullname"]');
const dashNumber = document.querySelector('[name="number"]');
const dashEmail = document.querySelector('[name="email"]');
const dashUrl = document.querySelector('[name="url"]');
const dashPassword = document.querySelector('[name="password"]');
const dashConfirm = document.querySelector('[name="confirm-password"]');
const passwordFields = document.getElementById("passwordFields");

const dashInputs = [dashFullName, dashNumber, dashEmail, dashUrl, dashPassword, dashConfirm];

const dashNameRegex = /^[A-Za-z]+(?:[.' -]+[A-Za-z.]+)+$/;
const dashNumberRegex = /^\+?\d{10,15}$/;
const dashEmailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
const dashPasswordRegex = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/;

let savedData = {};
let isEditing = false;

function validateDashFullName() {
    return dashNameRegex.test(dashFullName.value.trim());
}

function validateDashNumber() {
    return dashNumberRegex.test(dashNumber.value.trim());
}

function validateDashEmail() {
    return dashEmailRegex.test(dashEmail.value.trim());
}

function validateDashUrl() {
    try {
        const parsed = new URL(dashUrl.value.trim());
        return parsed.protocol === "http:" || parsed.protocol === "https:";
    } catch (error) {
        return false;
    }
}

function validateDashPassword() {
    return dashPassword.value === "" || dashPasswordRegex.test(dashPassword.value);
}

function validateDashConfirm() {
    return dashConfirm.value === dashPassword.value;
}



function setEditing(editing) {
    isEditing = editing;

    dashInputs.forEach(input => {
        input.disabled = !editing;
    });

    passwordFields.style.display = editing ? "flex" : "none";
    saveButton.disabled = !editing;
    editButton.textContent = editing ? "Cancel" : "Edit";

    if (editing) {
        dashFullName.focus();
    }
}

function hasChanges() {
    return dashFullName.value.trim() !== String(savedData.fullname ?? "")
        || dashNumber.value.trim() !== String(savedData.number ?? "")
        || dashEmail.value.trim() !== String(savedData.email ?? "")
        || dashUrl.value.trim() !== String(savedData.url ?? "")
        || dashPassword.value !== ""
        || dashConfirm.value !== "";
}

function resetToDefault() {
    fillForm(savedData);
    setEditing(false);
}

editButton.addEventListener("click", () => {
    if (!isEditing) {
        setEditing(true);
    } else if (hasChanges()) {
        showConfirm("UNSAVED CHANGES", ["Back to default?"]);
    } else {
        resetToDefault();
    }
});

modalYes.addEventListener("click", resetToDefault);  

dashboardForm.addEventListener("submit", e => {
    e.preventDefault();

    if (!isEditing) {
        return;
    }

    const errors = [];

    if (!validateDashFullName()) {
        errors.push("Invalid full name (first and last name).");
    }

    if (!validateDashNumber()) {
        errors.push("Invalid number (10-15 digits, optional + at the start).");
    }

    if (!validateDashEmail()) {
        errors.push("Invalid email address.");
    }

    if (!validateDashUrl()) {
        errors.push("Invalid URL (must start with http:// or https://).");
    }

    if (!validateDashPassword()) {
        errors.push("Password must be 8+ characters with a letter, number, and symbol.");
    }

    if (!validateDashConfirm()) {
        errors.push("Passwords do not match.");
    }

    if (errors.length === 0) {
        saveUser();
    } else {
        showModal("ERROR", errors);
    }
});

async function loadUser() {
    try {
        const response = await fetch("./auth/dashboard.php");

        const result = await response.json();

        if (result.success) {
            savedData = result.user;
            fillForm(savedData);
        } else {
            showModal("ERROR", [result.message]);
        }

    } catch (error) {
        showModal("ERROR", ["Unable to connect to server."]);
    }
}

async function saveUser() {
    const data = {
        fullName: dashFullName.value.trim(),
        number: dashNumber.value.trim(),
        email: dashEmail.value.trim(),
        url: dashUrl.value.trim(),
        password: dashPassword.value
    };

    try {
        const response = await fetch("./auth/dashboard.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();

        if (result.success) {
            savedData = {
                fullname: data.fullName,
                number: data.number,
                email: data.email,
                url: data.url
            };

            fillForm(savedData);
            setEditing(false);
            showModal("SUCCESS", [result.message]);
        } else {
            showModal("ERROR", [result.message]);
        }

    } catch (error) {
        showModal("ERROR", ["Unable to connect to server."]);
    }
}

function fillForm(user) {
    dashFullName.value = user.fullname;
    dashNumber.value = user.number;
    dashEmail.value = user.email;
    dashUrl.value = user.url;
    dashPassword.value = "";
    dashConfirm.value = "";
    welcomeName.textContent = user.fullname;
}

loadUser();