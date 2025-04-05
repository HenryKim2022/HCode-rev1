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
                                                href="#debug-activities"><i class='mdi mdi-bug'></i> Debug</a>
                                        </li>
                                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                                data-bs-target="#cache-activities" type="button" role="tab"
                                                aria-controls="home" aria-selected="false" href="#cache-activities"><i
                                                    class='mdi mdi-cached text-green-600'></i> Cache
                                            </a>
                                        </li>

                                    </ul>

                                    <div class="tab-content m-0 p-0">
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

                                            </form>

                                            <!-- Toggle Maintenance Mode Form -->
                                            <form id="maintenance-form"
                                                action="{{ route('syssettings.togglemaintenance') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary ms-2">
                                                    {!! app()->isDownForMaintenance()
                                                        ? "<i class='mdi mdi-run-fast'></i> Bring Online"
                                                        : "<i class='mdi mdi-bed'></i> Put in Maintenance" !!}
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="tab-content m-0 p-0">
                                        <div class="tab-pane" id="debug-activities" role="tabpanel"
                                            aria-labelledby="home-tab" tabindex="0">
                                            <section class="debug">

                                                <form id="debug-form" action="{{ route('syssettings.toggledebug') }}"
                                                    method="POST">
                                                    @csrf
                                                    <table class="table table-condensed mb-0 border-top">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">
                                                                    <small class="text-capitalize fs-17 text-dark">{!! config('app.debug')
                                                                        ? "<i class='mdi mdi-lightbulb-on text-success'></i> Laravel Debugging"
                                                                        : "<i class='mdi mdi-lightbulb-off text-danger'></i> Laravel Debugging" !!}</small>
                                                                    ({{ config('app.debug') ? 'On' : 'Off' }})
                                                                </th>
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

                                                            <tr>
                                                                <th scope="row">
                                                                    <small
                                                                        class="text-capitalize fs-17 text-dark mt-1">{!! config('app.logging_enabled')
                                                                        ? "<i class='mdi mdi-lightbulb-on text-success'></i> Laravel Logging"
                                                                        : "<i class='mdi mdi-lightbulb-off text-danger'></i> Laravel Logging" !!}</small>
                                                                    ({{ config('app.logging_enabled') ? 'On' : 'Off' }})
                                                                </th>
                                                                <td>
                                                                    <div class="mb-3">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="logging_true"
                                                                                name="app_logging" value="true"
                                                                                class="form-check-input"
                                                                                {{ config('app.logging_enabled') ? 'checked' : '' }}>
                                                                            <label for="logging_true"
                                                                                class="form-check-label">Enable
                                                                                Logging</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="form-check">
                                                                            <input type="radio" id="logging_false"
                                                                                name="app_logging" value="false"
                                                                                class="form-check-input"
                                                                                {{ !config('app.logging_enabled') ? 'checked' : '' }}>
                                                                            <label for="logging_false"
                                                                                class="form-check-label">Disable
                                                                                Logging</label>
                                                                        </div>
                                                                    </div>

                                                                </td>

                                                            </tr>


                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex justify-content-center align-content-center">

                                                </form>

                                            </section>

                                            <section class="log">
                                                <table class="table table-condensed mb-0 border-top">
                                                    <tbody>
                                                        <tr>
                                                            <th>
                                                                <div
                                                                    scope="row d-flex justify-content-between align-content-center">
                                                                    <div
                                                                        class="d-flex justify-content-between align-content-center">
                                                                        <button id="fetchLogs"
                                                                            class="btn btn-secondary mt-2">Fetch
                                                                            Logs</button>
                                                                        <button id="clearLogs"
                                                                            class="btn btn-secondary mt-2">Clear
                                                                            Logs</button>
                                                                    </div>
                                                                </div>

                                                            </th>
                                                        </tr>


                                                    </tbody>
                                                </table>

                                                <div class="mb-3 logs-container">
                                                    @if (isset($laravelLogs))
                                                        <ul class="list-group list-group-flush">
                                                            @foreach ($laravelLogs as $fileName => $logEntries)
                                                                <li class="list-group-item">
                                                                    <strong>{{ $fileName }}</strong>
                                                                    <pre class="bg-light p-2 mt-2"
                                                                        style="max-height: 300px; overflow-y: auto; white-space: pre-wrap; word-wrap: normal;">
                                                                            @foreach ($logEntries as $entry)
{{ $entry }}
@endforeach
                                                                    </pre>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @else
                                                        <div class="text-center">
                                                            Click *Fetch Logs* to Refresh
                                                        </div>
                                                    @endif
                                                </div>
                                            </section>




                                        </div>
                                    </div>




                                    <div class="tab-content m-0 p-0">
                                        <div class="tab-pane" id="cache-activities" role="tabpanel"
                                            aria-labelledby="home-tab" tabindex="0">
                                            <small class="text-capitalize fs-17 text-dark">Cache Management</small>
                                            <div class="card">
                                                <div class="card-body">
                                                    <p class="text-muted">Manage and clear application cache.</p>
                                                    <div class="d-grid gap-2">
                                                        <button id="clear-app-cache" class="btn btn-primary">Clear
                                                            Application Cache</button>
                                                        <button id="clear-config-cache" class="btn btn-secondary">Clear
                                                            Config Cache</button>
                                                        <button id="clear-route-cache" class="btn btn-info">Clear Route
                                                            Cache</button>
                                                        <button id="clear-view-cache" class="btn btn-warning">Clear View
                                                            Cache</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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


            // Handle saving for Excluded IPs
            $('#maintenance_excluded_ips').on('select2:select select2:unselect', function(e) {
                const selectedOptions = $('#maintenance_excluded_ips').val() || [];
                console.log('Updated IPs:', selectedOptions);

                // Send the updated list of IPs to the server
                $.ajax({
                    url: "{{ route('syssettings.exclusionupdate') }}",
                    method: 'POST',
                    data: {
                        maintenance_excluded_ips: selectedOptions,
                        maintenance_excluded_uris: $('#maintenance_excluded_uris').val() || [],
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // console.log('IPs saved successfully:', response);
                            showToast("System", response.message, "success", true, 6000);
                        } else {
                            // alert('An error occurred while saving IPs.');
                            showToast("System", `[Inner Error]: ${response.message}`, "error",
                                true, 6000);
                        }
                    },
                    error: function(error) {
                        // console.error('Error saving IPs:', error);
                        // alert('An error occurred while saving IPs.');
                        showToast("System", `[Outter Error]: ${response.message}`, "error",
                            true, 6000);
                    },
                });
            });


            // Handle saving for Excluded URIs
            $('#maintenance_excluded_uris').on('select2:select select2:unselect', function(e) {
                const selectedOptions = $('#maintenance_excluded_uris').val() || [];
                console.log('Updated URIs:', selectedOptions);

                // Send the updated list of URIs to the server
                $.ajax({
                    url: "{{ route('syssettings.exclusionupdate') }}",
                    method: 'POST',
                    data: {
                        maintenance_excluded_ips: $('#maintenance_excluded_ips').val() || [],
                        maintenance_excluded_uris: selectedOptions,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            // console.log('URIs saved successfully:', response);
                            showToast("System", response.message, "success", true, 6000);
                        } else {
                            // alert('An error occurred while saving URIs.');
                            showToast("System", `[Inner Error]: ${response.message}`, "error",
                                true, 6000);
                        }
                    },
                    error: function(error) {
                        // console.error('Error saving URIs:', error);
                        // alert('An error occurred while saving URIs.');
                        showToast("System", `[Outter Error]: ${response.message}`, "error",
                            true, 6000);
                    },
                });
            });


            // Handle Debugging Toggle on Radio Button Change
            $('input[name="app_debug"]').on('change', function() {
                const newDebugValue = $(this).val(); // Get the selected value (true/false)
                console.log('Debugging toggled to:', newDebugValue);

                // Send the new debug value to the server
                $.ajax({
                    url: "{{ route('syssettings.toggledebug') }}",
                    method: 'POST',
                    data: {
                        app_debug: newDebugValue,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response
                                .redirect; // Reload the page to reflect changes
                        }
                    },
                    error: function(xhr) {
                        // alert('An error occurred while toggling debugging.');
                        showToast("System",
                            `[Outter Error]: An error occurred while toggling debugging.`,
                            "error",
                            true, 6000);
                    },
                });
            });


            // Handle Maintenance Mode Toggle Form Submission via AJAX
            $('#maintenance-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: $(this).attr('action'), // Use the form's action URL
                    method: 'POST',
                    data: $(this).serialize(), // Serialize the form data
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}" // Include CSRF token
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message); // Show success message
                            window.location.href = response
                                .redirect; // Redirect to the specified URL
                        }
                    },
                    error: function(xhr) {
                        // alert('An error occurred while toggling maintenance mode.');
                        showToast("System",
                            `[Outter Error]: An error occurred while toggling maintenance mode.`,
                            "error",
                            true, 6000);
                    },
                });
            });

            // Handle Logging Toggle on Radio Button Change
            $('input[name="app_logging"]').on('change', function() {
                const newLoggingValue = $(this).val(); // Get the selected value (true/false)
                console.log('Logging toggled to:', newLoggingValue);

                // Send the new debug value to the server
                $.ajax({
                    url: "{{ route('syssettings.togglelogging') }}",
                    method: 'POST',
                    data: {
                        app_logging: newLoggingValue,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            window.location.href = response
                                .redirect; // Reload the page to reflect changes
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while toggling logging.');
                    },
                });
            });


            // Handle button to fetch logs dynamically:
            $('#fetchLogs').on('click', function() {
                event.preventDefault(); // Prevent any default behavior
                $.ajax({
                    url: "{{ route('syssettings.refreshlogs') }}",
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            let logsHtml = '';
                            if (response.logs && Object.keys(response.logs).length > 0) {
                                logsHtml += '<ul class="list-group list-group-flush">';
                                for (const [fileName, logEntries] of Object.entries(response
                                        .logs)) {
                                    logsHtml += `
                                        <li class="list-group-item">
                                            <strong>${fileName}</strong>
                                            <pre class="bg-light p-2 mt-2" style="max-height: 300px; overflow-y: auto; white-space: pre-wrap; word-wrap: normal;">${logEntries.join('\n')}</pre>
                                        </li>
                                    `;
                                }
                                logsHtml += '</ul>';
                            } else {
                                logsHtml = '<div class="text-center">No logs available.</div>';
                            }
                            $('#debug-activities section.log .logs-container').html(logsHtml);

                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while fetching logs.');
                    },
                });
            });



            // Handle Clear Logs button
            $('#clearLogs').on('click', function(event) {
                event.preventDefault();

                if (confirm('Are you sure you want to clear all logs? This action cannot be undone.')) {
                    $.ajax({
                        url: "{{ route('syssettings.clearlogs') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                $('#debug-activities section.log .logs-container ul').html(
                                    '<div class="text-center">No logs available.</div>');
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr) {
                            alert(
                                'An error occurred while clearing logs. Please check the server logs for details.'
                            );
                        },
                    });
                }
            });



            /* CACHE */
            // Handle Clear Application Cache
            $('#clear-app-cache').on('click', function() {
                $.ajax({
                    url: "{{ route('syssettings.clearappcache') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Failed to clear application cache.');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while clearing application cache.');
                    },
                });
            });

            // Handle Clear Config Cache
            $('#clear-config-cache').on('click', function() {
                $.ajax({
                    url: "{{ route('syssettings.clearconfigcache') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Failed to clear config cache.');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while clearing config cache.');
                    },
                });
            });

            // Handle Clear Route Cache
            $('#clear-route-cache').on('click', function() {
                $.ajax({
                    url: "{{ route('syssettings.clearroutecache') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Failed to clear route cache.');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while clearing route cache.');
                    },
                });
            });

            // Handle Clear View Cache
            $('#clear-view-cache').on('click', function() {
                $.ajax({
                    url: "{{ route('syssettings.clearviewcache') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                        } else {
                            alert('Failed to clear view cache.');
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred while clearing view cache.');
                    },
                });
            });


        });
    </script>
@endsection
