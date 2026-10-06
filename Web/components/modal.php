<link rel="stylesheet" href="./assets/css/modal.css?v=<?= time() ?>">

<div id="modal" class="modal">
    <div id="modalBox" class="modal-box">

        <div class="modal-body">

            <div class="modal-icon">
                <svg class="icon-check" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
                <svg class="icon-x" viewBox="0 0 24 24">
                    <path d="M6 6l12 12M18 6L6 18"/>
                </svg>
                <svg class="icon-question" viewBox="0 0 24 24">
                    <path d="M9.5 9a2.5 2.5 0 1 1 3.6 2.2c-.7.4-1.1 1-1.1 1.8M12 17.5h.01"/>
                </svg>
            </div>

            <h2 id="modalTitle"></h2>
            <div id="modalMessage"></div>

        </div>

        <button type="button" id="modalButton" onclick="hideModal()">Continue</button>

        <div id="modalConfirm" class="modal-confirm">
            <button type="button" id="modalYes" onclick="hideModal()">Yes</button>
            <button type="button" id="modalNo" onclick="hideModal()">No</button>
        </div>

    </div>
</div>
