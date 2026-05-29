document.addEventListener("DOMContentLoaded", function () {

    // =========================
    // PAGE FADE-IN SYSTEM
    // =========================
    document.body.style.opacity = "0";
    document.body.style.transition = "0.4s ease";

    setTimeout(() => {
        document.body.style.opacity = "1";
    }, 50);


    // =========================
    // SMOOTH PAGE NAVIGATION
    // =========================
    const links = document.querySelectorAll("a");

    links.forEach(link => {
        const href = link.getAttribute("href");

        // only internal links
        if (href && href.indexOf(".php") !== -1) {
            link.addEventListener("click", function (e) {
                e.preventDefault();

                document.body.style.opacity = "0";

                setTimeout(() => {
                    window.location.href = href;
                }, 300);
            });
        }
    });


    // =========================
    // SIDEBAR ACTIVE STATE FIX
    // =========================
    const currentPage = window.location.pathname.split("/").pop();

    document.querySelectorAll(".nav-item").forEach(item => {
        if (item.getAttribute("href") === currentPage) {
            item.classList.add("active");
        }
    });


    // =========================
    // LOADING SKELETON SYSTEM
    // =========================
    const cards = document.querySelectorAll(".glass-card");

    cards.forEach(card => {

        const skeleton = document.createElement("div");
        skeleton.classList.add("skeleton-loader");

        card.appendChild(skeleton);

        setTimeout(() => {
            skeleton.remove();
        }, 500);
    });

});