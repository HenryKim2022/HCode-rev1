@extends('layouts.landings.vl_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
    <div class="authentication-bg row justify-content-center items" style="background-image: url('{{ asset('template/assets/images/auth-bg.png') }}?v={{ time() }}');
    background-size: cover;
    background-position: center;">
        <div class="col-12">
            <div class="d-flex flex-column align-items-center justify-content-center h-100">
                <div class="mb-0 col-3">
                    <img src="{{ asset('template/assets/images/svg/under_maintenance.png') }}?v={{ time() }}"
                        alt="" class="img-fluid d-block">
                </div>
                <div class="text-center">
                    <h2 class="mb-0 text-muted">Sorry we are under maintenance</h2>
                    <p class="text-dark-emphasis fs-15 mb-0">Our website currently undergoing maintenance.</p>
                    <p class="text-dark-emphasis fs-15 mb-0">We should be a back shotly. thankyou for patience.</p>
                </div>
            </div>


            {{-- <div class="d-flex flex-column h-100">
                <div class="row justify-content-center">
                    <div class="col-lg-4">
                        <div class="text-center">

                            <h1 class="text-error mb-4">500</h1>
                            <div class="lazy-load d-flex justify-content-center mb-5">
                                <img src="{{ asset('template/assets/images/svg/500.svg') }}?v={{ time() }}" alt="" class="img-fluid">
                            </div>
                            <h2 class="text-uppercase text-primary mt-3">Internal Server Error</h2>
                            <p class="text-muted mt-3"> Why not try refreshing your page? or you can contact <a href="javascript: void(0);" class="text-primary"><b>Support</b></a></p>

                            <a class="btn btn-soft-primary mt-3" href="index.html"><i class="ri-home-4-line me-1"></i>
                                Back to Home</a>
                        </div> <!-- end /.text-center-->
                    </div> <!-- end col-->
                </div> --}}



        </div>
    </div> <!-- end col -->
    </div>
@endsection





@section('footer_page_js')
@endsection
