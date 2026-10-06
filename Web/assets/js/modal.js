const modal = document.getElementById("modal");
const modalBox = document.getElementById("modalBox");
const modalTitle = document.getElementById("modalTitle");
const modalMessage = document.getElementById("modalMessage");
const modalButton = document.getElementById("modalButton");
const modalConfirm = document.getElementById("modalConfirm");
const modalYes = document.getElementById("modalYes");
const modalNo = document.getElementById("modalNo");

function showModal(title, messages) {
    modalBox.className = title === "SUCCESS" ? "modal-box success" : "modal-box error";
    modalTitle.textContent = title;
    modalMessage.innerHTML = messages.join("<br>");
    modalButton.style.display = "";
    modalConfirm.style.display = "none";
    modal.style.display = "flex";
}

function showConfirm(title, messages) {
    showModal(title, messages);
    modalBox.className = "modal-box confirm";
    modalButton.style.display = "none";
    modalConfirm.style.display = "flex";
}

function hideModal() {
    modal.style.display = "none";
}
