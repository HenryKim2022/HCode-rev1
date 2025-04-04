@extends('layouts.landings.vl_main')

@section('header_page_cssjs')
@endsection

@section('page-content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card p-0">
                <div class="card-body p-0">
                    <div class="profile-content">
                        <ul class="nav nav-underline nav-justified gap-0">
                            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#system-activities-activities" type="button" role="tab"
                                    aria-controls="home" aria-selected="true"
                                    href="#system-activities">{{ trans('language.vl_menu_system') }}</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#x-activities"
                                    type="button" role="tab" aria-controls="home" aria-selected="true"
                                    href="#x-activities">X</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#y-activities"
                                    type="button" role="tab" aria-controls="home" aria-selected="true"
                                    href="#y-activities">Y</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" data-bs-target="#z-activities"
                                    type="button" role="tab" aria-controls="home" aria-selected="true"
                                    href="#z-activities">Z</a></li>
                        </ul>

                        <div class="tab-content m-0 p-1">
                            <div class="tab-pane active" id="msystem-activities-activities" role="tabpanel"
                                aria-labelledby="home-tab" tabindex="0">
                                <div class="profile-desk">
                                    <ul class="nav nav-underline nav-justified gap-0">
                                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                                data-bs-target="#maintenance-activities" type="button" role="tab"
                                                aria-controls="home" aria-selected="true"
                                                href="#maintenance-activities">{!! app()->isDownForMaintenance()
                                                    ? "<i class='mdi mdi-run-fast text-green-600'></i> Maintenance"
                                                    : "<i class='mdi mdi-bed text-danger'></i> Maintenance" !!}</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#debug-activities" type="button" role="tab"
                                                aria-controls="home" aria-selected="false"
                                                href="#debug-activities">{!! config('app.debug')
                                                    ? "<i class='mdi mdi-lightbulb-on text-green-600'></i> Debug"
                                                    : "<i class='mdi mdi-lightbulb-off text-danger'></i> Debug" !!}</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content m-0 p-1">
                                        <div class="tab-pane active" id="maintenance-activities" role="tabpanel"
                                            aria-labelledby="home-tab" tabindex="0">
                                            <small class="text-capitalize fs-17 text-dark">Exclude From Maintenance</small>
                                            <form id="exclusion-form" action="{{ route('syssettings.exclusionupdate') }}"
                                                method="POST">
                                                @csrf
                                                <table class="table table-condensed mb-0 border-top">
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">Excluded IPs</th>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <input type="text" class="form-control"
                                                                        id="maintenance_excluded_ips"
                                                                        name="maintenance_excluded_ips"
                                                                        value="{{ $excludedIps }}">
                                                                    <small class="form-text text-muted">Semicolon-separated
                                                                        list of IP addresses
                                                                        (e.g., 192.168.1.19; 192.168.1.2)</small>
                                                                </div>

                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <th scope="row">Excluded URIs</th>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <input type="text" class="form-control"
                                                                        id="maintenance_excluded_uris"
                                                                        name="maintenance_excluded_uris"
                                                                        value="{{ $excludedUris }}">
                                                                    <small class="form-text text-muted">Semicolon-separated
                                                                        list of URIs (e.g.,
                                                                        /system/settings; /landing; /admin).</small>
                                                                </div>
                                                            </td>
                                                        </tr> --}}
                                                        <tr>
                                                            <th scope="row">Excluded URIs</th>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <select id="maintenance_excluded_uris"
                                                                        name="maintenance_excluded_uris[]"
                                                                        multiple="multiple" style="width: 100%;">
                                                                        @foreach ($routes as $route)
                                                                            <option value="{{ $route['uri'] }}"
                                                                                @if (in_array($route['uri'], $selectedUris)) selected @endif>
                                                                                {{ $route['uri'] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                    <small class="form-text text-muted">Select one or more
                                                                        URIs to exclude from maintenance mode.</small>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-center align-content-center mt-2">
                                                    <button type="submit" class="btn btn-primary"><i
                                                            class="mdi mdi-content-save"></i> Save
                                                        Settings</button>
                                            </form>

                                            <!-- Toggle Maintenance Mode Form -->
                                            <form id="maintenance-form"
                                                action="{{ route('syssettings.togglemaintenance') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    {!! app()->isDownForMaintenance()
                                                        ? "<i class='mdi mdi-run-fast'></i> Maintenance"
                                                        : "<i class='mdi mdi-bed'></i> Maintenance" !!}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="debug-activities" role="tabpanel"
                                        aria-labelledby="home-tab" tabindex="0">

                                        <small class="text-capitalize fs-17 text-dark">Laravel Debugging</small>
                                        <form id="debug-form" action="{{ route('syssettings.toggledebug') }}"
                                            method="POST">
                                            @csrf
                                            <table class="table table-condensed mb-0 border-top">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row">
                                                            Debugging({{ config('app.debug') ? 'On' : 'Off' }})</th>
                                                        <td>
                                                            <div class="mb-3">
                                                                <div class="form-check">
                                                                    <input type="radio" id="debug_true"
                                                                        name="app_debug" value="true"
                                                                        class="form-check-input"
                                                                        {{ config('app.debug') ? 'checked' : '' }}>
                                                                    <label for="debug_true"
                                                                        class="form-check-label">Enable
                                                                        Debugging</label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="form-check">
                                                                    <input type="radio" id="debug_false"
                                                                        name="app_debug" value="false"
                                                                        class="form-check-input"
                                                                        {{ !config('app.debug') ? 'checked' : '' }}>
                                                                    <label for="debug_false"
                                                                        class="form-check-label">Disable
                                                                        Debugging</label>
                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr>


                                                </tbody>
                                            </table>
                                            <div class="d-flex justify-content-center align-content-center">
                                                <button type="submit" class="btn btn-success mt-2"><i
                                                        class="mdi mdi-content-save"></i> Save Settings</button>
                                        </form>



                                    </div>
                                </div>

                            </div> <!-- end profile-desk -->
                        </div> <!-- about-me -->

                        <!-- Activities -->
                        <div id="x-activities" class="tab-pane">

                        </div>

                        <!-- settings -->
                        <div id="y-activities" class="tab-pane">

                        </div>

                        <!-- profile -->
                        <div id="z-activities" class="tab-pane">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('footer_page_js')
    <script>
        $(document).ready(function() {
            // Retrieve the CSRF token using Laravel's helper
            // const csrfToken = "{{ csrf_token() }}";

            // Handle Maintenance Mode Toggle Form Submission
            $('#maintenance-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while toggling maintenance mode.');
                    }
                });
            });

            // Handle Maintenance Exclusions Update Form Submission
            $('#exclusion-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = '';
                            for (const key in errors) {
                                errorMessage += errors[key].join('\n') + '\n';
                            }
                            alert(errorMessage);
                        } else {
                            alert('An error occurred while updating exclusions.');
                        }
                    }
                });
            });

            // Handle Debugging Toggle Form Submission
            $('#debug-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response.redirect;
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while toggling debugging.');
                    }
                });
            });
        });
    </script>



    <script>
        $(document).ready(function() {
            // Initialize Select2 for Excluded URIs
            $('#maintenance_excluded_uris').select2({
                placeholder: "Select one or more URIs", // Placeholder text
                allowClear: true, // Allow clearing the selection
                closeOnSelect: false, // Keep dropdown open after selecting
            });

            // Disable selected options dynamically
            $('#route-select').on('change', function() {
                const selectedOptions = $(this).val(); // Get currently selected values

                // Loop through all options and disable/enable based on selection
                $('#route-select option').each(function() {
                    const optionValue = $(this).val();
                    if (selectedOptions && selectedOptions.includes(optionValue)) {
                        $(this).prop('disabled', true); // Disable selected options
                    } else {
                        $(this).prop('disabled', false); // Enable unselected options
                    }
                });

                // Refresh Select2 to reflect changes
                $('#route-select').trigger('change.select2');
            });
        });
    </script>
@endsection
