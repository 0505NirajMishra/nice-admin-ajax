@extends('layouts.app')
@section('content')

<div class="pagetitle">
    <h1>Product Details</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item">Products</li>
        </ol>

        <a class="btn btn-primary" href="{{ route('products.create') }}">Add Product</a>

    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">

        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>
                                    Product Name
                                </th>
                                <th>
                                    Product Description
                                </th>
                                <th>Product Price</th>
                                <th>Product Images</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_description }}</td>
                                <td>{{ $product->product_price }}</td>
                                <td>
                                    @foreach($product->images as $image)
                                    <div class="col-md-3">
                                        <img src="{{ asset($image->image) }}" alt="{{ $product->name }}"
                                            class="img-fluid h-25 w-25" >
                                    </div>
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-danger delete-product" data-id="{{ $product->id }}">Delete</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        $(document).on('click', '.delete-product', function() {
            let id = $(this).data('id');
            if (confirm('Are you sure you want to delete this product?')) {
                $.ajax({
                    url: "/products/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}" // CSRF token for Laravel
                    },
                    success: function(response) {
                        location.reload(); // Reload the page to reflect changes
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseText);
                    }
                });
            }
        });

    });

</script>

@endsection
