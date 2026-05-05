document.addEventListener("DOMContentLoaded", function () {

    const buttons = document.querySelectorAll(".tab-btn");
    const tabs = document.querySelectorAll(".tab-content");

    function showTab(targetId) {

        tabs.forEach(tab => {
            tab.classList.add("opacity-0", "translate-y-4");

            setTimeout(() => {
                tab.classList.add("hidden");
            }, 300);
        });

        const target = document.getElementById(targetId);

        setTimeout(() => {
            target.classList.remove("hidden");

            requestAnimationFrame(() => {
                target.classList.remove("opacity-0", "translate-y-4");
                target.classList.add("opacity-100", "translate-y-0");
            });

        }, 300);
    }

    buttons.forEach(button => {
        button.addEventListener("click", function () {

            const target = this.dataset.tab;

            buttons.forEach(btn => {
                btn.classList.remove("text-blue-600", "border-b-2", "border-blue-600");
                btn.classList.add("text-gray-700");
            });

            this.classList.add("text-blue-600", "border-b-2", "border-blue-600");

            showTab(target);
        });
    });

});

// Auto-load ALL tab on page refresh
window.addEventListener("load", function () {
    const defaultTab = "all";
    const defaultButton = document.querySelector('[data-tab="all"]');

    if (defaultButton) {
        defaultButton.classList.add("text-blue-600", "border-b-2", "border-blue-600");
        defaultButton.classList.remove("text-gray-700");
    }

    const allTab = document.getElementById(defaultTab);

    allTab.classList.remove("hidden");
    allTab.classList.remove("opacity-0", "translate-y-4");
    allTab.classList.add("opacity-100", "translate-y-0");
});
