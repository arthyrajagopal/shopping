@extends('layouts.app')

@section('title', 'Compare Products')

@section('content')
<h2>Compare Products</h2>
@if($products->count())
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-3">
                <div class="card">
                    <img src="{{ asset($product->image) }}" class="card-img-top">
                    <div class="card-body">
                        <h5>{{ $product->name }}</h5>
                        <p>Price: ${{ $product->final_price }}</p>
                        <p>Rating: {{ number_format($product->rating, 1) }} / 5</p>
                        <form action="{{ route('compare.remove', $product->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>No products to compare. <a href="{{ route('shop') }}">Add some products</a>.</p>
@endif
@endsection