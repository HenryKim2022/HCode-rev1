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

                            <h1 class="text-error mb-4">500</h1>
                            <h2 class="text-uppercase text-danger mt-3">Internal Server Error</h2>
                            <p class="text-muted mt-3"> Why not try refreshing your page? or you can contact <a href="javascript: void(0);" class="text-primary"><b>Support</b></a></p>

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
