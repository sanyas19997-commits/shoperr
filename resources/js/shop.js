import './bootstrap';
import { createApp } from 'vue';
import MiniCart from './components/MiniCart.vue';
import HeaderSearch from './components/HeaderSearch.vue';

// AJAX add-to-cart на формах с классом .add-to-cart-form
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
    const link = document.getElementById('cart-link');
    if (link) {
        const span = link.querySelector('.ml-1');
        if (span) span.textContent = formatPrice(subtotal) + ' ₽';
    }
}

function formatPrice(n) {
    return new Intl.NumberFormat('ru-RU').format(Math.round(n));
}

window.updateCartCounter = updateCartCounter;
