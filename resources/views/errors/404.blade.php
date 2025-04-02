@extends('layouts.landings.vl_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
    <div class="row justify-content-center items">
        <div class="col-12">
            <div class="d-flex flex-column h-100">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="text-center">
                            <h1 class="text-error mb-4">404</h1>
                            <h2 class="text-uppercase text-danger mt-3">Service Unavailable</h2>
                            <p class="text-muted mt-3">It's looking like you may have taken a wrong turn. Don't worry...
                                it
                                happens to the best of us. Here's a
                                little tip that might help you get back on track.</p>

                            <a class="btn btn-soft-danger mt-3" href="index.html"><i class="ri-home-4-line me-1"></i>
                                Back to Home</a>
                        </div> <!-- end /.text-center-->
                    </div> <!-- end col-->
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection





@section('footer_page_js')
@endsection
