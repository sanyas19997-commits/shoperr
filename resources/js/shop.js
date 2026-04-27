import './bootstrap';
import { createApp } from 'vue';
import MiniCart from './components/MiniCart.vue';
import HeaderSearch from './components/HeaderSearch.vue';

// AJAX add-to-cart for forms with class .add-to-cart-form
document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('form.add-to-cart-form').forEach((form) => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const btn = form.querySelector('button[type=submit]');
            const original = btn?.textContent;
            if (btn) { btn.disabled = true; btn.textContent = 'Добавляем...'; }
            try {
                const res = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                });
                if (!res.ok) throw new Error('Ошибка');
                const data = await res.json();
                updateCartCounter(data.count, data.subtotal);
                if (btn) { btn.textContent = '✓ Добавлено'; setTimeout(() => { btn.textContent = original; btn.disabled = false; }, 1200); }
            } catch (err) {
                if (btn) { btn.textContent = original; btn.disabled = false; }
                form.submit();
            }
        });
    });

    // Init WOW.js animations
    if (typeof window.WOW !== 'undefined') {
        try { new window.WOW({ live: false }).init(); } catch(e) {}
    }

    // Init swipers for hero banner and category slider once DOM ready
    if (typeof window.Swiper !== 'undefined') {
        try {
            new window.Swiper('.swiper-banner', {
                loop: true,
                speed: 800,
                autoplay: { delay: 5000 },
                pagination: { el: '.swiper-pagination-banner', clickable: true },
                slidesPerView: 1,
            });
        } catch(e) {}
        try {
            new window.Swiper('.swiper-9-items', {
                loop: false,
                spaceBetween: 20,
                breakpoints: {
                    0: { slidesPerView: 2 },
                    576: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    992: { slidesPerView: 6 },
                    1200: { slidesPerView: 8 },
                },
            });
        } catch(e) {}
    }

    // Mobile menu toggle
    document.querySelectorAll('.burger-icon').forEach(b => {
        b.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.toggle('mobile-menu-active');
        });
    });
    document.querySelectorAll('.close-mobile').forEach(b => {
        b.addEventListener('click', (e) => {
            e.preventDefault();
            document.body.classList.remove('mobile-menu-active');
        });
    });

    // Mount Vue components if elements exist
    const miniCart = document.getElementById('mini-cart-app');
    if (miniCart) createApp(MiniCart).mount(miniCart);
    const headerSearch = document.getElementById('header-search-app');
    if (headerSearch) createApp(HeaderSearch).mount(headerSearch);
});

function updateCartCounter(count, subtotal) {
    const counter = document.getElementById('cart-counter');
    if (counter) {
        counter.textContent = count;
        counter.style.display = count > 0 ? 'inline-block' : 'none';
    }
    const sub = document.getElementById('cart-subtotal');
    if (sub) sub.textContent = formatPrice(subtotal) + ' ₽';
}

function formatPrice(n) {
    return new Intl.NumberFormat('ru-RU').format(Math.round(n));
}

window.updateCartCounter = updateCartCounter;
