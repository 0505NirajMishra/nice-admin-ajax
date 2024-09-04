@extends('layouts.app')
@section('content')

<div class="pagetitle">
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product Details</h5>

                    <form id="addProductForm">

                        @csrf

                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="product_name"
                                    value="{{ old('product_name') }}">
                                <span class="text-danger" id="product_name_error"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputText" class="col-sm-2 col-form-label">Product Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="product_price"
                                    value="{{ old('product_price') }}">
                                <span class="text-danger" id="product_price_error"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                                <span class="text-danger" id="images_error"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="inputPassword" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" style="height: 100px"
                                    name="product_description">{{ old('product_description') }}</textarea>
                                <span class="text-danger" id="product_description_error"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit Form</button>
                            </div>
                        </div>

                    </form><!-- End General Form Elements -->

                </div>
            </div>

        </div>
    </div>
</section>

<script>
    $(document).ready(function() {

        fetchProducts();

        function fetchProducts() {
            $.ajax({
                url: "{{ route('products.index') }}",
                method: "GET",
                success: function(data) {
                    $('#productsList').html(data);
                }
            });
        }

        $('#addProductForm').submit(function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('products.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                },
                error: function(response) {
                    let errors = response.responseJSON.errors;
                    $('#product_name_error').text(errors.product_name ? errors.product_name[0] : '');
                    $('#product_price_error').text(errors.product_price ? errors.product_price[0] : '');
                    $('#images_error').text(errors.images ? errors.images[0] : '');
                    $('#product_description_error').text(errors.product_description ? errors.product_description[0] : '');
                }
            });
        });


    });

</script>


@endsection
