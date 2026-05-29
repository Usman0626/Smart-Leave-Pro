document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // GLOBAL MODAL SYSTEM
    // =========================
    const modal = document.createElement("div");
    modal.id = "globalModal";
    modal.innerHTML = `
        <div class="modal-overlay"></div>
        <div class="modal-box">
            <div class="modal-content"></div>
        </div>
    `;
    document.body.appendChild(modal);

    window.openModal = function (html) {
        document.querySelector(".modal-content").innerHTML = html;
        modal.style.display = "flex";
    };

    window.closeModal = function () {
        modal.style.display = "none";
    };

    modal.querySelector(".modal-overlay").onclick = closeModal;


    // =========================
    // AJAX HELPER
    // =========================
    window.ajaxPost = function (url, data, callback) {

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams(data)
        })
        .then(res => res.json())
        .then(data => callback(data))
        .catch(err => console.log(err));

    };


    // =========================
    // APPROVE / REJECT ACTIONS
    // =========================
   document.querySelectorAll(".action-btn").forEach(btn => {

    btn.addEventListener("click", function () {

        let id = this.dataset.id;
        let action = this.dataset.action;

        if (!id || !action) {
            alert("Invalid action");
            return;
        }



        fetch("../manager/leave_action.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: `id=${id}&action=${action}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === "success") {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            console.log(err);
            alert("Request failed");
        });

    });

});


    window.processAction = function (id, action) {

        ajaxPost("../manager/leave_action.php", {
            id: id,
            action: action
        }, function (res) {

            if (res.status === "success") {
                closeModal();
                location.reload();
            } else {
                alert(res.message);
            }

        });

    };


    // =========================
    // PAGE FADE IN
    // =========================
    document.body.style.opacity = "0";
    document.body.style.transition = "0.4s ease";

    setTimeout(() => {
        document.body.style.opacity = "1";
    }, 50);

});