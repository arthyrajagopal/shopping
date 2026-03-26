@extends('layouts.app')

@section('title', 'Shop')

@section('content')
<div class="row">
    <!-- Sidebar Filters -->
    <div class="col-md-3">
        <div class="sidebar">
            <form action="{{ route('shop') }}" method="GET" id="filterForm">
                <!-- Categories -->
                <div class="filter-group">
                    <h5>Categories</h5>
                    @foreach($categories as $cat)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="category" value="{{ $cat->slug }}" id="cat{{ $cat->id }}" {{ request('category') == $cat->slug ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $cat->id }}">{{ $cat->name }} ({{ $cat->products_count }})</label>
                        </div>
                    @endforeach
                    <a href="#" class="text-muted">+ Show More</a>
                </div>

                <!-- Sizes -->
                <div class="filter-group">
                    <h5>Size</h5>
                    @foreach($sizes as $size)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="size[]" value="{{ $size->id }}" id="size{{ $size->id }}" {{ in_array($size->id, (array)request('size', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="size{{ $size->id }}">{{ $size->name }}</label>
                        </div>
                    @endforeach
                </div>

                <!-- Price Range -->
                <div class="filter-group">
                    <h5>Price Range</h5>
                    <div class="row">
                        <div class="col-6">
                            <input type="number" name="min_price" class="form-control" placeholder="Min" value="{{ request('min_price', 0) }}">
                        </div>
                        <div class="col-6">
                            <input type="number" name="max_price" class="form-control" placeholder="Max" value="{{ request('max_price', 600) }}">
                        </div>
                    </div>
                </div>

                <!-- On Sale -->
                <div class="filter-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="sale" value="1" id="saleFilter" {{ request('sale') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="saleFilter">On Sale</label>
                    </div>
                </div>

                <!-- Colors -->
                <div class="filter-group">
                    <h5>Colors</h5>
                    @foreach($colors as $color)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="color[]" value="{{ $color->id }}" id="color{{ $color->id }}" {{ in_array($color->id, (array)request('color', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="color{{ $color->id }}">
                                <span class="color-swatch" style="background: {{ $color->code }};"></span> {{ $color->name }}
                            </label>
                        </div>
                    @endforeach
                    <a href="#" class="text-muted">+ Show More</a>
                </div>

                <!-- Brands -->
                <div class="filter-group">
                    <h5>Filter By Brands</h5>
                    @foreach($brands as $brand)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="brand" value="{{ $brand->id }}" id="brand{{ $brand->id }}" {{ request('brand') == $brand->id ? 'checked' : '' }}>
                            <label class="form-check-label" for="brand{{ $brand->id }}">{{ $brand->name }}</label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-dark w-100 mt-3">FILTER</button>
                <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100 mt-2">Reset</a>
            </form>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="col-md-9">
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-4 col-sm-6">
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
                                <span>({{ $product->reviews_count }})</span>
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
        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection