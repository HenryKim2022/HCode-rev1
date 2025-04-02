@extends('layouts.landings.vl_main')

@section('header_page_cssjs')
@endsection


@section('page-content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="header-title">Default Accordions</h4>
                    <p class="text-muted mb-0">Click the accordions below to expand/collapse the accordion content.</p>
                </div>
                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    System Settings
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Current Status:
                                        {{ app()->isDownForMaintenance() ? 'Maintenance Mode (Offline)' : 'Online' }}</p>
                                    <form action="{{ route('su.sys.toggle-maintenance') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            {{ app()->isDownForMaintenance() ? 'Bring Application Online' : 'Put Application in Maintenance Mode' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button fw-medium collapsed" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                                    aria-controls="collapseTwo">
                                    Maintenance Mode
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <p>Current Value: {{ config('app.debug') ? 'true' : 'false' }}</p>
                                    <form action="{{ route('su.sys.update-app-debug') }}" method="POST">
                                        @csrf
                                        <div class="form-check">
                                            <input type="radio" id="debug_true" name="app_debug" value="true"
                                                class="form-check-input" {{ config('app.debug') ? 'checked' : '' }}>
                                            <label for="debug_true" class="form-check-label">Enable Debugging</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" id="debug_false" name="app_debug" value="false"
                                                class="form-check-input" {{ !config('app.debug') ? 'checked' : '' }}>
                                            <label for="debug_false" class="form-check-label">Disable Debugging</label>
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3">Update APP_DEBUG</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->

    </div>
    <!-- end row-->

@endsection





@section('footer_page_js')
@endsection
