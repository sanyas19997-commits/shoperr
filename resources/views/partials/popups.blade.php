<div class="box-popup-newsletter" id="newsletter-popup" style="display:none;">
    <div class="box-newsletter-overlay"></div>
    <div class="box-newsletter-wrapper">
        <div class="box-newsletter-inner">
            <a class="btn-close-popup btn-close-popup-newsletter" href="#" id="close-newsletter">
                <svg class="icon-16 d-inline-flex align-items-center justify-content-center" fill="#111111" stroke="#111111" width="24" height="24" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </a>
            <div class="promotion-content">
                <div class="block-info-banner">
                    <p class="font-3xl-bold neutral-900 title-line mb-10 wow animate__animated animate__zoomIn">Зима</p>
                    <h2 class="heading-banner mb-10 wow animate__animated animate__shakeX"><span class="text-up">распродажа</span><span class="text-under">распродажа</span></h2>
                    <h4 class="heading-4 title-line-2 mb-30 wow animate__animated animate__zoomIn">Всё для вашего малыша</h4>
                    <div class="mt-10"><a class="btn btn-double-border wow animate__animated animate__zoomIn" href="{{ route('catalog.index') }}"><span>Смотреть скидки</span></a></div>
                </div>
                <div class="promotion-label wow animate__animated animate__heartBeat" data-wow-iteration="5">
                    <img src="{{ asset('kidify/assets/imgs/template/promotion.png') }}" alt="{{ $siteSettings['site_name'] ?? 'Billaro Store' }}">
                </div>
                <div class="promotion-banner wow animate__animated animate__pulse">
                    <img src="{{ asset('kidify/assets/imgs/template/promotion-banner.png') }}" alt="{{ $siteSettings['site_name'] ?? 'Billaro Store' }}">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box-popup-search perfect-scrollbar">
    <div class="box-search-overlay"></div>
    <div class="box-search-wrapper">
        <a class="btn-close-popup" href="#">
            <svg class="icon-16 d-inline-flex align-items-center justify-content-center" fill="#111111" stroke="#111111" width="24" height="24" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </a>
        <h5 class="mb-15">Поиск товаров</h5>
        <form action="{{ route('catalog.index') }}" method="GET">
            <div class="form-group">
                <input class="form-control search-icon" type="text" name="q" placeholder="Введите запрос">
            </div>
        </form>
        <div class="box-quick-search">
            <span class="text-17 neutral-medium-dark mr-5">Популярные:</span>
            @foreach($mainCategories->take(5) as $cat)
                <a class="text-17" href="{{ route('catalog.category', $cat->slug) }}">{{ $cat->name }}</a>
            @endforeach
        </div>
        <h5 class="mb-15 mt-30">Категории</h5>
        <ul class="list-filter-checkbox">
            @foreach($mainCategories as $cat)
                <li>
                    <a href="{{ route('catalog.category', $cat->slug) }}">
                        <span class="text-small">{{ $cat->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

@push('scripts')
<script>
(function () {
    var KEY = 'billaro_newsletter_seen';
    var popup = document.getElementById('newsletter-popup');
    if (!popup) return;
    if (localStorage.getItem(KEY) === '1') {
        popup.parentNode.removeChild(popup);
        return;
    }
    setTimeout(function () { popup.style.display = 'block'; }, 1500);
    function dismiss(e) {
        if (e) e.preventDefault();
        try { localStorage.setItem(KEY, '1'); } catch (e) {}
        popup.style.display = 'none';
    }
    var closeBtn = document.getElementById('close-newsletter');
    if (closeBtn) closeBtn.addEventListener('click', dismiss);
    var overlay = popup.querySelector('.box-newsletter-overlay');
    if (overlay) overlay.addEventListener('click', dismiss);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') dismiss(); });
    popup.addEventListener('click', function (e) {
        var t = e.target;
        if (t.closest && t.closest('.btn-close-popup-newsletter')) dismiss(e);
    });
})();
</script>
@endpush
