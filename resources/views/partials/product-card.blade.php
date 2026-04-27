@php
    $main = $product->main_image ?? null;
    $images = optional($product->relationLoaded('images') ? $product->images : null);
    if (!$main && $images) { $main = optional($images->first())->path; }
    $hover = null;
    if ($images && $images->count() > 1) { $hover = optional($images->skip(1)->first())->path; }
    if (!$main) { $main = '/kidify/assets/imgs/page/homepage1/product1.png'; }
    if (!$hover) { $hover = $main; }
    $hasSale = $product->sale_price && $product->sale_price > 0 && $product->sale_price < $product->price;
    $price = $hasSale ? $product->sale_price : $product->price;
    $url = url('/product/' . $product->slug);
@endphp
<div class="cardProduct wow fadeInUp">
    <div class="cardImage">
        @if($product->is_featured)
            <label class="lbl-hot">хит</label>
        @elseif($hasSale)
            <label class="lbl-hot" style="background:#FF782D;">скидка</label>
        @endif
        <a href="{{ $url }}">
            <img class="imageMain" src="{{ asset($main) }}" alt="{{ $product->name }}">
            <img class="imageHover" src="{{ asset($hover) }}" alt="{{ $product->name }}">
        </a>
        <div class="button-select">
            <form method="POST" action="{{ route('cart.add', $product->id) }}" class="add-to-cart-form d-inline">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn-add-to-cart">В корзину</button>
            </form>
        </div>
    </div>
    <div class="cardInfo">
        <a href="{{ $url }}"><h6 class="font-md-bold cardTitle">{{ $product->name }}</h6></a>
        <p class="font-lg cardDesc">
            @if($hasSale)
                <span class="text-decoration-line-through neutral-500 mr-5">{{ number_format($product->price, 0, ',', ' ') }} ₽</span>
            @endif
            {{ number_format($price, 0, ',', ' ') }} ₽
        </p>
    </div>
</div>
