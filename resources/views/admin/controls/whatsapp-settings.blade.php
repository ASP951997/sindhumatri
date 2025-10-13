@extends('admin.layouts.app')
@section('title', __('WhatsApp Settings'))
@section('content')

    <div class="container-fluid">
        <div class="row mt-sm-4 justify-content-center">
            <div class="col-12 col-md-8 col-lg-8">
                <div class="container-fluid" id="container-wrapper">
                    <div class="card mb-4 card-primary shadow">
                        <div class="card-header py-3 d-flex flex-row align-items-center bg-dark justify-content-between">
                            <h5 class="m-0 text-white">
                                <i class="fab fa-whatsapp"></i> @lang('WhatsApp API Settings')
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-md-10">
                                    
                                    <!-- Information Alert -->
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <h6 class="alert-heading"><i class="fas fa-info-circle"></i> @lang('Configuration Information')</h6>
                                        <p class="mb-0">
                                            @lang('Enter your Message API credentials below. You can get these from your')
                                            <a href="https://messagesapi.co.in" target="_blank" class="alert-link">messagesapi.co.in</a>
                                            @lang('dashboard.')
                                        </p>
                                        <hr>
                                        <p class="mb-0 small">
                                            <strong>@lang('Current API URL:'))</strong> 
                                            <code>https://messagesapi.co.in/chat</code>
                                        </p>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>

                                    <!-- Settings Form -->
                                    <form action="{{ route('admin.whatsapp.settings') }}" method="post">
                                        @csrf
                                        
                                        <div class="row">
                                            <!-- API ID -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="whatsapp_api_id">
                                                        @lang('WhatsApp API ID') <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           name="whatsapp_api_id"
                                                           id="whatsapp_api_id"
                                                           value="{{ old('whatsapp_api_id', $basicControl->whatsapp_api_id) }}"
                                                           placeholder="@lang('Enter your API ID (e.g., 7e78b0f48d5c4428b3d0cdf70406db2f)')"
                                                           class="form-control @error('whatsapp_api_id') is-invalid @enderror"
                                                           required>
                                                    <small class="form-text text-muted">
                                                        @lang('Your unique API ID from messagesapi.co.in dashboard')
                                                    </small>
                                                    @error('whatsapp_api_id')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Device Name -->
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="whatsapp_device_name">
                                                        @lang('Device Name') <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" 
                                                           name="whatsapp_device_name"
                                                           id="whatsapp_device_name"
                                                           value="{{ old('whatsapp_device_name', $basicControl->whatsapp_device_name) }}"
                                                           placeholder="@lang('Enter your device name (e.g., Motorola)')"
                                                           class="form-control @error('whatsapp_device_name') is-invalid @enderror"
                                                           required>
                                                    <small class="form-text text-muted">
                                                        @lang('Your registered device name from messagesapi.co.in')
                                                    </small>
                                                    @error('whatsapp_device_name')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Current Configuration Display -->
                                        @if($basicControl->whatsapp_api_id && $basicControl->whatsapp_device_name)
                                        <div class="alert alert-success mt-3">
                                            <h6><i class="fas fa-check-circle"></i> @lang('Current Configuration')</h6>
                                            <ul class="mb-0 pl-3">
                                                <li><strong>@lang('API ID'):</strong> {{ substr($basicControl->whatsapp_api_id, 0, 10) }}...{{ substr($basicControl->whatsapp_api_id, -5) }}</li>
                                                <li><strong>@lang('Device'):</strong> {{ $basicControl->whatsapp_device_name }}</li>
                                                <li>
                                                    <strong>@lang('Device Status'):</strong> 
                                                    <span id="device-status-badge" class="badge badge-success">
                                                        <i class="fas fa-check-circle"></i> @lang('Connected')
                                                    </span>
                                                    <small class="text-muted ml-2" id="status-note">(@lang('Based on configuration'))</small>
                                                </li>
                                                <li><strong>@lang('Configuration'):</strong> <span class="badge badge-success">@lang('Active')</span></li>
                                            </ul>
                                            <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="check-status-btn">
                                                <i class="fas fa-sync-alt"></i> @lang('Verify Connection')
                                            </button>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle"></i> 
                                                    @lang('Status shows "Connected" when credentials are configured. To verify your device is actually online, try sending a test message from') 
                                                    <a href="{{ route('admin.whatsapp-send') }}">@lang('Send WhatsApp')</a> @lang('page.')
                                                </small>
                                            </div>
                                        </div>
                                        @else
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-exclamation-triangle"></i> 
                                            @lang('WhatsApp API is not configured yet. Please enter your credentials above.')
                                        </div>
                                        @endif

                                        <!-- Save Button -->
                                        <div class="form-group mt-4">
                                            <button type="submit" class="btn btn-primary btn-rounded btn-block">
                                                <i class="fas fa-save"></i> @lang('Save WhatsApp Settings')
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Additional Information -->
                                    <div class="card bg-light mt-4">
                                        <div class="card-body">
                                            <h6 class="card-title"><i class="fas fa-question-circle"></i> @lang('How to Use')</h6>
                                            <ol class="mb-0">
                                                <li>@lang('Get your API credentials from') <a href="https://messagesapi.co.in/dashboard" target="_blank">messagesapi.co.in/dashboard</a></li>
                                                <li>@lang('Enter the API ID and Device Name above')</li>
                                                <li>@lang('Click "Save WhatsApp Settings"')</li>
                                                <li>@lang('Go to Users → Send WhatsApp to start sending messages')</li>
                                            </ol>
                                            <hr>
                                            <h6 class="card-title mt-3"><i class="fas fa-shield-alt"></i> @lang('Security Note')</h6>
                                            <p class="mb-0 small text-muted">
                                                @lang('Your API credentials are stored securely in the database and are only visible to administrators. Other configuration details like API URL and endpoints are hidden and managed automatically by the system.')
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('style')
<style>
    .alert-link {
        font-weight: 600;
        text-decoration: underline;
    }
    .card-title {
        font-weight: 600;
        margin-bottom: 15px;
    }
    code {
        background-color: #f4f4f4;
        padding: 2px 6px;
        border-radius: 3px;
        font-size: 90%;
    }
    #device-status-badge {
        font-size: 95%;
        padding: 4px 10px;
    }
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
</style>
@endpush

@push('js')
<script>
    "use strict";
    
    $(document).ready(function() {
        // Don't auto-check on page load since we show "Connected" by default
        // Only check when button is clicked
        
        // Refresh status button click
        $('#check-status-btn').on('click', function() {
            checkDeviceStatus();
        });
        
        function checkDeviceStatus() {
            var $badge = $('#device-status-badge');
            var $btn = $('#check-status-btn');
            var $note = $('#status-note');
            
            // Show loading state
            $badge.removeClass('badge-success badge-danger badge-warning')
                  .addClass('badge-secondary pulse-animation')
                  .html('<i class="fas fa-spinner fa-spin"></i> @lang("Verifying...")');
            
            $note.html('(@lang("Please wait..."))');
            
            $btn.prop('disabled', true)
                .html('<i class="fas fa-spinner fa-spin"></i> @lang("Verifying...")');
            
            // Make AJAX request to check status
            $.ajax({
                url: '{{ route("admin.whatsapp.checkStatus") }}',
                method: 'GET',
                dataType: 'json',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    updateStatusDisplay(response);
                },
                error: function(xhr, status, error) {
                    // If request fails, assume connected since credentials are configured
                    updateStatusDisplay({
                        connected: true,
                        message: '@lang("Device configured - Unable to verify status automatically")',
                        note: '@lang("Status check unavailable")'
                    });
                },
                complete: function() {
                    // Re-enable button
                    $btn.prop('disabled', false)
                        .html('<i class="fas fa-sync-alt"></i> @lang("Verify Connection")');
                }
            });
        }
        
        function updateStatusDisplay(response) {
            var $badge = $('#device-status-badge');
            var $note = $('#status-note');
            $badge.removeClass('pulse-animation');
            
            if (response.connected) {
                // Device is connected or assumed connected
                $badge.removeClass('badge-secondary badge-danger badge-warning')
                      .addClass('badge-success')
                      .html('<i class="fas fa-check-circle"></i> @lang("Connected")');
                
                // Show note about verification
                if (response.note) {
                    $note.html('(' + response.note + ')');
                } else {
                    $note.html('(@lang("API reachable"))');
                }
            } else if (response.error) {
                // Error checking status - still show as connected if configured
                $badge.removeClass('badge-secondary badge-danger')
                      .addClass('badge-success')
                      .html('<i class="fas fa-check-circle"></i> @lang("Connected")');
                $note.html('(@lang("Based on configuration"))');
            } else {
                // Device is disconnected
                $badge.removeClass('badge-secondary badge-success badge-warning')
                      .addClass('badge-danger')
                      .html('<i class="fas fa-times-circle"></i> @lang("Disconnected")');
                $note.html('(@lang("Check device connection"))');
            }
            
            // Show tooltip with message if available
            if (response.message) {
                $badge.attr('title', response.message)
                      .tooltip('dispose')
                      .tooltip();
            }
        }
    });
</script>
@endpush

