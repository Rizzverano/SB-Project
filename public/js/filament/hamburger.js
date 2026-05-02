document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('hamburger');
            const menu = document.getElementById('mobile-menu');

            if (!btn || !menu) return;

            btn.addEventListener('click', function() {
                if (menu.classList.contains('max-h-0')) {
                    menu.classList.remove('max-h-0');
                    menu.classList.add('max-h-[600px]');
                } else {
                    menu.classList.add('max-h-0');
                    menu.classList.remove('max-h-[600px]');
                }
            });
        });
