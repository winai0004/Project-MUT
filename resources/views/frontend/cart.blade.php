{{-- <!-- resources/views/frontend/cart.blade.php -->
@extends('layouts_frontend.app')

@section('title', 'Cart')

@section('content')
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <h1>Shopping Cart</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(count($cart) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['color'] }}</td>
                            <td>{{ $item['size'] }}</td>
                            <td>{{ $item['price'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ $item['price'] * $item['quantity'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Your cart is empty.</p>
        @endif
    </div>
</section>
@endsection --}}
@extends('layouts_frontend.app')

@section('title', 'Cart')

@section('content')

<section class="py-5">

    <div class="container px-4 px-lg-5 mt-5">

        <h1>Shopping Cart</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(count($cartItems) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->color }}</td>
                            <td>{{ $item->size }}</td>
                            <td>฿{{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>฿{{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Your cart is empty.</p>
        @endif

    </div>

</section>

@endsection
