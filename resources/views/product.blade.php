@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
    <div class="col-md-5">
        <img src="{{ asset($product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
    </div>
    <div class="col-md-7">
        <h1>{{ $product->name }}</h1>
        <div class="mb-2">
            @for($i=1; $i<=5; $i++)
                @if($i <= round($product->rating))
                    <i class="fas fa-star text-warning"></i>
                @else
                    <i class="far fa-star text-warning"></i>
                @endif
            @endfor
            <span>({{ $product->reviews_count }} reviews)</span>
        </div>

        <div class="mb-3">
            @if($product->sale_price)
                <span class="price-old fs-4">${{ $product->price }}</span>
                <span class="price-new fs-3 fw-bold text-danger">${{ $product->sale_price }}</span>
                <span class="badge bg-danger ms-2">-{{ $product->discount_percent }}%</span>
            @else
                <span class="fs-3 fw-bold">${{ $product->price }}</span>
            @endif
        </div>

        <p>{{ $product->description }}</p>

        <div class="bg-light p-3 rounded mb-3">
            <p class="fw-bold">Hurry Up! Offer Ends In:</p>
            <div id="countdown" class="fs-4 fw-bold text-danger mb-2"></div>
            <div class="progress mb-2">
                @php $soldPercent = ($product->sold_count / max($product->stock_quantity,1)) * 100; @endphp
                <div class="progress-bar bg-danger" style="width: {{ $soldPercent }}%"></div>
            </div>
            <p>Sold It: {{ number_format($soldPercent) }}% Sold - Only {{ $product->stock_quantity - $product->sold_count }} Item(s) left in stock!</p>
        </div>

        <!-- Cart Form -->
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="color" class="form-label">Color:</label>
                    <select name="color" id="color" class="form-select" required>
                        <option value="">Select Color</option>
                        @foreach($product->colors as $color)
                            <option value="{{ $color->name }}">{{ $color->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="size" class="form-label">Size:</label>
                    <select name="size" id="size" class="form-select" required>
                        <option value="">Select Size</option>
                        @foreach($product->sizes as $size)
                            <option value="{{ $size->name }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity:</label>
                <div class="input-group w-25">
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock_quantity - $product->sold_count }}" class="form-control">
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-dark">ADD TO CART</button>
                <button type="button" class="btn btn-danger" onclick="buyNow()">BUY IT NOW</button>
            </div>
        </form>

        <!-- Wishlist, Compare, Share (outside cart form) -->
        <div class="mt-3 d-flex gap-2">
            @if(in_array($product->id, $wishlistIds))
                <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-heart"></i> Remove from Wishlist
                    </button>
                </form>
            @else
                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary">
                        <i class="far fa-heart"></i> Add to Wishlist
                    </button>
                </form>
            @endif

            <button type="button" class="btn btn-outline-secondary" onclick="addToCompare({{ $product->id }})">Compare</button>
            <button type="button" class="btn btn-outline-secondary" onclick="shareProduct()">Share Products</button>
        </div>
    </div>
</div>

<h3 class="mt-5">Related Products</h3>
<div class="row">
    @foreach($related as $rel)
        <div class="col-md-3 col-sm-6">
            <div class="card product-card h-100">
                <img src="{{ asset($rel->image) }}" class="card-img-top" alt="{{ $rel->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $rel->name }}</h5>
                    <a href="{{ route('product.show', $rel->slug) }}" class="btn btn-sm btn-dark">View</a>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
<script>
    @if($product->offer_end_date)
        const endDate = new Date("{{ $product->offer_end_date }}").getTime();
        const countdown = setInterval(function() {
            const now = new Date().getTime();
            const distance = endDate - now;
            if (distance < 0) {
                clearInterval(countdown);
                document.getElementById("countdown").innerHTML = "EXPIRED";
                return;
            }
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            document.getElementById("countdown").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s";
        }, 1000);
    @else
        document.getElementById("countdown").innerHTML = "No active offer";
    @endif

    function buyNow() {
        alert("Proceed to checkout (simulated)");
    }

    function addToCompare(productId) {
        let url = "{{ route('compare.add', ':id') }}";
        url = url.replace(':id', productId);
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(() => alert('Added to compare'))
          .catch(() => alert('Error adding to compare'));
    }

    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                url: window.location.href
            });
        } else {
            alert('Share not supported, you can copy the link: ' + window.location.href);
        }
    }
</script>
@endpush
@endsection