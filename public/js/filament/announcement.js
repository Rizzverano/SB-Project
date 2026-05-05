  const slides = document.querySelectorAll('.announcement-slide');
  let current = 0;

  function goTo(n) {
    slides.forEach((s, i) => s.classList.toggle('hidden', i !== n));
    current = n;
  }

  if (slides.length > 1) setInterval(() => goTo((current + 1) % slides.length), 4000);
