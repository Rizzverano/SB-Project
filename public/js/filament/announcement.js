document.addEventListener('DOMContentLoaded', function () {

    const slides = document.querySelectorAll('.announcement-slide');

    if (slides.length <= 1) return;

    let current = 0;

    setInterval(() => {

        slides[current].classList.add('hidden');

        current = (current + 1) % slides.length;

        slides[current].classList.remove('hidden');

    }, 4000);

});
