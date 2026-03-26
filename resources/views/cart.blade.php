@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<h2>Shopping Cart</h2>
@if(count($cart) > 0)
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Color/Size</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cart as $key => $item)
            <tr>
                <td>
                    <img src="{{ asset($item['image']) }}" width="50" alt="{{ $item['name'] }}">
                    {{ $item['name'] }}
                </td>
                <td>{{ $item['color'] }} / {{ $item['size'] }}</td>
                <td>${{ $item['price'] }}</td>
                <td>
                    <form action="{{ route('cart.update', $key) }}" method="POST" class="d-flex">
                        @csrf @method('PUT')
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control w-25">
                        <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                    </form>
                </td>
                <td>${{ $item['price'] * $item['quantity'] }}</td>
                <td>
                    <form action="{{ route('cart.remove', $key) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-end fw-bold">Total:</td>
                <td>${{ $total }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    <a href="{{ route('shop') }}" class="btn btn-secondary">Continue Shopping</a>
@else
    <p>Your cart is empty.</p>
    <a href="{{ route('shop') }}" class="btn btn-primary">Go to Shop</a>
@endif
@endsection