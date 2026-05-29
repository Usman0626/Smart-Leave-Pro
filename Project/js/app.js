document.addEventListener("DOMContentLoaded", function(){

    // =========================
    // 1. CARD ANIMATION SYSTEM
    // =========================
    const cards = document.querySelectorAll(".glass-card");

    cards.forEach((card, index) => {
        card.style.opacity = "0";
        card.style.transform = "translateY(20px)";

        setTimeout(() => {
            card.style.transition = "0.6s ease";
            card.style.opacity = "1";
            card.style.transform = "translateY(0)";
        }, index * 120);
    });


    // =========================
    // 2. STAT COUNTER ANIMATION
    // =========================
    const counters = document.querySelectorAll(".stat-number");

    counters.forEach(el => {
        let end = parseInt(el.innerText);

        if (isNaN(end)) return;

        let start = 0;
        let duration = 800; // total animation time
        let stepTime = Math.max(10, Math.floor(duration / end));

        let interval = setInterval(() => {
            start++;
            el.innerText = start;

            if (start >= end) {
                clearInterval(interval);
                el.innerText = end;
            }
        }, stepTime);
    });

});