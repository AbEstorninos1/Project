const form = document.getElementById("loginForm");

form.addEventListener("submit", e => {
    e.preventDefault();
    login();
});

async function login() {
    const email = document.querySelector('[name="email"]').value.trim();
    const password = document.querySelector('[name="password"]').value;
    const rememberMe = document.querySelector('[name="remember-me"]').checked;

    try {
        const response = await fetch("./auth/login.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                email: email,
                password: password,
                rememberMe: rememberMe
            })
        });

        const result = await response.json();

        if (result.success) {
            window.location.href = "./dashboard.php";
        } else {
            showModal("ERROR", [result.message]);
        }

    } catch (error) {
        showModal("ERROR", ["Unable to connect to server."]);
    }
}