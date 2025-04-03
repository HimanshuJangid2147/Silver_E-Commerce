@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-md-12">
            <h2>Search Results for "{{ $query }}"</h2>
            <p>Found {{ $results->count() }} results</p>

            @if($results->count() > 0)
                <div class="row">
                    @foreach($results as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @php
                                    $images = json_decode($product->product_image ?? '[]', true);
                                    $display_image = !empty($images) && is_array($images) ? $images[0] : 'images/no-image.jpg';
                                @endphp
                                <img src="{{ admnin_url . $display_image }}" class="card-img-top" alt="{{ $product->product_name }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->product_name }}</h5>
                                    <p class="card-text">
                                        @if($product->discount > 0)
                                            <span class="text-decoration-line-through">₹{{ number_format($product->product_ammount, 2) }}</span>
                                            <span class="text-danger ms-2">₹{{ number_format($product->product_ammount - ($product->product_ammount * $product->discount / 100), 2) }}</span>
                                        @else
                                            <span>₹{{ number_format($product->product_ammount, 2) }}</span>
                                        @endif
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('product', ['product_name' => $product->slug, 'product_id' => $product->product_id]) }}" class="btn btn-primary">View Details</a>
                                        <form action="{{ route('cart.add', $product->product_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info">
                    No products found matching your search criteria. Try different keywords or browse our categories.
                </div>
                <div class="mt-4">
                    <a href="{{ route('shop') }}" class="btn btn-primary">Browse All Products</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<style>
    /* Add this to your CSS files */

.search-results-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    background-color: white;
    border: 1px solid #ddd;
    border-radius: 0 0 4px 4px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    max-height: 400px;
    overflow-y: auto;
}

.quick-search-results {
    list-style: none;
    padding: 0;
    margin: 0;
}

.quick-search-results li {
    border-bottom: 1px solid #eee;
}

.quick-search-results li:last-child {
    border-bottom: none;
}

.quick-search-results li a {
    display: flex;
    padding: 10px;
    text-decoration: none;
    color: #333;
    transition: background-color 0.2s;
}

.quick-search-results li a:hover {
    background-color: #f9f9f9;
}

.quick-search-results .product-image {
    width: 50px;
    height: 50px;
    margin-right: 10px;
}

.quick-search-results .product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.quick-search-results .product-info {
    flex: 1;
}

.quick-search-results .product-info h4 {
    margin: 0 0 5px;
    font-size: 14px;
}

.quick-search-results .product-info .price {
    margin: 0;
    font-weight: bold;
    color: #e74c3c;
}

.quick-search-results .view-all {
    text-align: center;
    background-color: #f5f5f5;
}

.quick-search-results .view-all a {
    justify-content: center;
    font-weight: bold;
    color: #3498db;
}

.no-results {
    padding: 15px;
    text-align: center;
    color: #777;
}
</style>


@include('layouts.footer')
