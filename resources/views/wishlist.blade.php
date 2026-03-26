@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<h2>My Wishlist</h2>
@if($products->count())
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card h-100">
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
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-dark btn-sm">View</a>
                            <form action="{{ route('wishlist.remove', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>Your wishlist is empty. <a href="{{ route('shop') }}">Browse products</a>.</p>
@endif
@endsection