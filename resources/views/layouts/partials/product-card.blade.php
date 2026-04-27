@php /** @var \App\Models\Product $product */ @endphp
<div class="card-grid-style-3 h-100">
    <div class="card-grid-inner">
        <div class="tools">
            <a class="btn btn-trend btn-tooltip mb-10" href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="Быстрый просмотр">👁</a>
        </div>
        <div class="image-box">
            @if ($product->on_sale)
                <span class="label bg-brand-2">-{{ $product->discount_percent }}%</span>
            @endif
            <a href="{{ route('product.show', $product->slug) }}">
                @if ($product->main_image)
                    <img src="{{ \Illuminate\Support\Str::startsWith($product->main_image, ['http', '/']) ? $product->main_image : asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" loading="lazy">
                @else
                    <div style="height:180px;background:linear-gradient(135deg,#FFE9D6,#FFC9B0);display:flex;align-items:center;justify-content:center;border-radius:8px;font-size:48px;">🛍️</div>
                @endif
            </a>
        </div>
        <div class="info-right">
            @if ($product->category)
                <span class="font-xs color-gray-500">{{ $product->category->name }}</span>
            @endif
            <a class="font-md-bold color-brand-3" href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
            <div class="price-info mt-10">
                <strong class="font-lg-bold color-brand-3 price-main">{{ number_format($product->current_price, 0, ',', ' ') }} ₽</strong>
                @if ($product->on_sale)
                    <span class="color-gray-500 font-sm font-medium price-line ml-5"><del>{{ number_format($product->price, 0, ',', ' ') }} ₽</del></span>
                @endif
            </div>
            <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-10 add-to-cart-form">
                @csrf
                <button type="submit" class="btn btn-cart">В корзину</button>
            </form>
        </div>
    </div>
</div>
