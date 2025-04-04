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
                                                                    <select id="maintenance_excluded_ips"
                                                                        name="maintenance_excluded_ips[]"
                                                                        multiple="multiple" style="width: 100%;">
                                                                        @foreach (explode(';', $excludedIps) as $ip)
                                                                            @if (!empty(trim($ip)))
                                                                                <option value="{{ trim($ip) }}"
                                                                                    selected>{{ trim($ip) }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <small class="form-text text-muted">Select one or more
                                                                        IPs to exclude from maintenance mode.</small>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <th scope="row">Excluded URIs</th>
                                                            <td>
                                                                <div class="mb-3">
                                                                    <select id="maintenance_excluded_uris"
                                                                        name="maintenance_excluded_uris[]"
                                                                        multiple="multiple" style="width: 100%;">
                                                                        @foreach ($routes as $route)
                                                                            <option value="{{ $route }}"
                                                                                @if (in_array($route, $selectedUris)) selected @endif>
                                                                                {{ $route }}
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
            // Initialize Select2 for Excluded IPs
            $('#maintenance_excluded_ips').select2({
                placeholder: "Select one or more IPs", // Placeholder text
                allowClear: false, // Allow clearing the selection
                closeOnSelect: false, // Keep dropdown open after selecting
                tags: true, // Enable adding new options by typing
                createTag: function(params) {
                    const term = params.term.trim();
                    if (!term) {
                        return null; // Prevent empty tags
                    }
                    // Validate the input (e.g., ensure it matches an IP pattern)
                    const ipPattern = /^([0-9]{1,3}\.){3}[0-9]{1,3}$/;
                    if (!ipPattern.test(term)) {
                        return null; // Prevent invalid tags
                    }
                    // Check for duplicates
                    const isDuplicate = $('#maintenance_excluded_ips option').filter(function() {
                        return $(this).text().toLowerCase() === term.toLowerCase();
                    }).length > 0;
                    if (isDuplicate) {
                        return null; // Prevent duplicate tags
                    }
                    // Create the new tag
                    return {
                        id: term, // Use the input as the ID
                        text: term, // Use the input as the display text
                    };
                },
            });

            // Handle new IP addition via AJAX
            $('#maintenance_excluded_ips').on('select2:select', function(e) {
                const selectedOption = e.params.data;
                // Normalize the selected option's ID for comparison
                const normalizedSelectedId = selectedOption.id.trim().toLowerCase();
                // Check if the option is new (not part of the original list)
                const isDuplicate = $('#maintenance_excluded_ips option').filter(function() {
                    return $(this).val().trim().toLowerCase() === normalizedSelectedId;
                }).length > 0;

                if (!isDuplicate) {
                    console.log('New IP added:', selectedOption.id);
                    // Send the new IP to the server
                    $.ajax({
                        url: "{{ route('syssettings.savetyped.ip') }}", // Replace with your API endpoint
                        method: 'POST',
                        data: {
                            newIp: selectedOption.id
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log('New IP saved:', response);
                            // Ensure newOption is properly defined
                            const newOption = new Option(selectedOption.text, selectedOption.id,
                                true, true);
                            // Append the new option to the dropdown
                            $('#maintenance_excluded_ips').append(newOption).trigger('change');
                            // Disable the newly added option
                            $(newOption).prop('disabled', true);
                            // Refresh Select2 to reflect changes
                            $('#maintenance_excluded_ips').trigger('change.select2');
                        },
                        error: function(error) {
                            console.error('Error saving new IP:', error);
                        },
                    });
                } else {
                    console.log('IP already exists');
                }
            });
        });
    </script>




    <script>
        $(document).ready(function() {
            // Initialize Select2 for Excluded URIs
            $('#maintenance_excluded_uris').select2({
                placeholder: "Select one or more URIs", // Placeholder text
                allowClear: false, // Allow clearing the selection
                closeOnSelect: false, // Keep dropdown open after selecting
                tags: true, // Enable adding new options by typing
                createTag: function(params) {
                    const term = params.term.trim();
                    if (!term) {
                        return null; // Prevent empty tags
                    }
                    // Validate the input (e.g., ensure it matches a URI pattern)
                    const uriPattern = /^[a-zA-Z0-9\-_\/]+$/;
                    if (!uriPattern.test(term)) {
                        return null; // Prevent invalid tags
                    }
                    // Check for duplicates
                    const isDuplicate = $('#maintenance_excluded_uris option').filter(function() {
                        return $(this).text().toLowerCase() === term.toLowerCase();
                    }).length > 0;
                    if (isDuplicate) {
                        return null; // Prevent duplicate tags
                    }
                    // Create the new tag
                    return {
                        id: term, // Use the input as the ID
                        text: term, // Use the input as the display text
                    };
                },
            });



            $('#maintenance_excluded_uris').on('select2:select', function(e) {
                const selectedOption = e.params.data;
                // Normalize the selected option's ID for comparison
                const normalizedSelectedId = selectedOption.id.trim().toLowerCase();
                // Check if the option is new (not part of the original list)
                const isDuplicate = $('#maintenance_excluded_uris option').filter(function() {
                    return $(this).val().trim().toLowerCase() === normalizedSelectedId;
                }).length > 0;
                if (!isDuplicate) {
                    console.log('New option added:', selectedOption.id);
                    // Send the new option to the server
                    $.ajax({
                        url: "{{ route('syssettings.savetyped.uri') }}", // Replace with your API endpoint
                        method: 'POST',
                        data: {
                            newUri: selectedOption.id
                        },
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log('New URI saved:', response);
                            // Ensure newOption is properly defined
                            const newOption = new Option(selectedOption.text, selectedOption.id,
                                true, true);
                            // Append the new option to the dropdown
                            $('#maintenance_excluded_uris').append(newOption).trigger('change');
                            // Disable the newly added option
                            $(newOption).prop('disabled', true);
                            // Refresh Select2 to reflect changes
                            $('#maintenance_excluded_uris').trigger('change.select2');
                        },
                        error: function(error) {
                            console.error('Error saving new URI:', error);
                        },
                    });
                } else {
                    console.log('Option already exists');
                }


            });
        });
    </script>
@endsection
