@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="text-center my-5">
        <h1>With Us</h1>
        <a href="{{ route('shop') }}" class="btn btn-primary btn-lg">SHOP NOW</a>
    </div>

    <h2 class="mb-4">Trending Products</h2>
    <div class="row">
        @foreach($trendingProducts as $product)
            <div class="col-md-3 col-sm-6">
                <div class="card product-card h-100 position-relative">
                    @if($product->sale_price)
                        <div class="discount-badge">-{{ $product->discount_percent }}%</div>
                    @endif
                    <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">
                            @if($product->sale_price)
                                <span class="price-old">${{ $product->price }}</span>
                                <span class="price-new">${{ $product->sale_price }}</span>
                            @else
                                <span>${{ $product->price }}</span>
                            @endif
                        </p>
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
                        <div class="d-flex justify-content-between mt-2">
                            @if(in_array($product->id, $wishlistIds))
                                <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-heart"></i> Remove
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('wishlist.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-secondary">
                                        <i class="far fa-heart"></i> Wishlist
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-dark">View</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection