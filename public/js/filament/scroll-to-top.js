document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('scrollTopBtn');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 200) {
            btn.classList.remove('opacity-0', 'translate-y-4', 'pointer-events-none');
            btn.classList.add('opacity-100', 'translate-y-0');
        } else {
            btn.classList.add('opacity-0', 'translate-y-4', 'pointer-events-none');
            btn.classList.remove('opacity-100', 'translate-y-0');
        }
    });
});
