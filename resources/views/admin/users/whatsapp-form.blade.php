@extends('admin.layouts.app')
@section('title')
    @lang('WhatsApp')
@endsection
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <form method="post" action="{{route('admin.whatsapp-send.store')}}" enctype="multipart/form-data">
            @csrf
            <div class="col-sm-12">
                <div class="card-body">
                    <h3 class="mb-4">@lang("Send WhatsApp Message To Selected Users")</h3>
                    
                    <div class="alert alert-info">
                        <i class="fab fa-whatsapp"></i>
                        <strong>@lang('WhatsApp Messaging:')</strong> @lang('Send personalized WhatsApp messages to selected users. You can attach files (PDF, images) up to 10MB.')
                        <a href="{{ route('admin.whatsapp.settings') }}" class="alert-link float-right">
                            <i class="fas fa-cog"></i> @lang('Settings')
                        </a>
                    </div>

                    <div class="form-group">
                        <label>@lang('Select Users') <span class="text-danger">*</span></label>
                        <div class="user-selection-container">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="select-all-users">
                                        <i class="fas fa-check-square"></i> @lang('Select All')
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" id="deselect-all-users">
                                        <i class="fas fa-square"></i> @lang('Deselect All')
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control form-control-sm" id="user-search" placeholder="@lang('Search users...')">
                                </div>
                            </div>
                            <div class="user-list-container" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                @forelse($users as $user)
                                    <div class="form-check user-item" data-user-id="{{ $user->id }}" data-user-name="{{ $user->firstname }} {{ $user->lastname }}" data-user-phone="{{ $user->phone }}">
                                        <input class="form-check-input user-checkbox" type="checkbox" name="selected_users[]" value="{{ $user->id }}" id="user_{{ $user->id }}">
                                        <label class="form-check-label" for="user_{{ $user->id }}">
                                            <strong>{{ $user->firstname }} {{ $user->lastname }}</strong>
                                            <small class="text-muted">({{ $user->email }})</small>
                                            @if($user->phone)
                                                <span class="badge badge-success badge-sm">@lang('Has Phone')</span>
                                            @else
                                                <span class="badge badge-warning badge-sm">@lang('No Phone')</span>
                                            @endif
                                        </label>
                                    </div>
                                @empty
                                    <div class="text-center text-muted">
                                        @lang('No users found.')
                                    </div>
                                @endforelse
                            </div>
                            <small class="form-text text-muted">
                                @lang('Selected users:') <span id="selected-count">0</span>
                            </small>
                        </div>
                        @error('selected_users')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>@lang('Message') <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="message" id="whatsapp-message" rows="10" placeholder="@lang('Enter your WhatsApp message here...')">{{old('message')}}</textarea>
                        <small class="form-text text-muted">
                            @lang('You can use [[name]] placeholder to personalize the message with user\'s first name.')
                        </small>
                        @error('message')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>@lang('Attach File (Optional)')</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="attachment" id="attachment" accept=".pdf,.png,.jpg,.jpeg">
                            <label class="custom-file-label" for="attachment" id="attachment-label">@lang('Choose file...')</label>
                        </div>
                        <small class="form-text text-muted">
                            <i class="fas fa-paperclip"></i> @lang('Attach PDF, PNG, JPG, or JPEG files (Max: 10MB)') - @lang('Event invitations, brochures, images, etc.')
                        </small>
                        @error('attachment')
                        <span class="text-danger d-block mt-2">{{ $message }}</span>
                        @enderror
                        <div id="file-preview" class="mt-2" style="display: none;">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="fas fa-file fa-2x mr-3"></i>
                                <div>
                                    <strong>@lang('Selected file:')</strong><br>
                                    <span id="file-name"></span>
                                    <span id="file-size" class="badge badge-secondary ml-2"></span>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger ml-auto" id="remove-file">
                                    <i class="fas fa-times"></i> @lang('Remove')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>@lang('Message Preview')</label>
                        <div class="alert alert-light border">
                            <div id="message-preview">
                                <strong>@lang('Hello [[name]],')</strong><br>
                                @lang('This is a preview of your message. The [[name]] placeholder will be replaced with each user\'s first name.')
                            </div>
                        </div>
                    </div>

                    <div class="submit-btn-wrapper mt-md-3 text-center text-md-left">
                        <button type="button" class="btn waves-effect waves-light btn-rounded btn-success btn-block" id="send-btn" disabled>
                            <i class="fab fa-whatsapp"></i> <span>@lang('Send WhatsApp Message')</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push('style')
<style>
/* Custom Confirmation Modal */
.custom-confirm-modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s;
}

.custom-confirm-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 30px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    animation: slideDown 0.3s;
}

.custom-confirm-header {
    text-align: center;
    margin-bottom: 20px;
}

.custom-confirm-header i {
    font-size: 50px;
    color: #25D366;
}

.custom-confirm-body {
    text-align: center;
    margin-bottom: 25px;
}

.custom-confirm-body h4 {
    font-size: 20px;
    margin-bottom: 15px;
    color: #333;
}

.custom-confirm-body p {
    font-size: 16px;
    color: #666;
    margin: 10px 0;
}

.user-count-badge {
    display: inline-block;
    background: #25D366;
    color: white;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 24px;
    font-weight: bold;
    margin: 15px 0;
}

.custom-confirm-buttons {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.custom-confirm-buttons button {
    padding: 12px 30px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-confirm-yes {
    background: #25D366;
    color: white;
}

.btn-confirm-yes:hover {
    background: #128C7E;
}

.btn-confirm-no {
    background: #dc3545;
    color: white;
}

.btn-confirm-no:hover {
    background: #c82333;
}

/* Loading Screen */
.loading-screen {
    display: none;
    position: fixed;
    z-index: 10000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    animation: fadeIn 0.3s;
}

.loading-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    text-align: center;
}

.whatsapp-logo-container {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    position: relative;
}

.whatsapp-logo {
    width: 120px;
    height: 120px;
    background: #25D366;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 70px;
    color: white;
    animation: moveLeftRight 2s ease-in-out infinite;
    box-shadow: 0 15px 40px rgba(37, 211, 102, 0.5);
}

.loading-text {
    color: #333;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 15px;
    margin-top: 20px;
    text-shadow: 0 2px 4px rgba(255, 255, 255, 0.8);
    background: white;
    padding: 10px 20px;
    border-radius: 5px;
    display: inline-block;
}

.loading-subtext {
    color: #333;
    font-size: 16px;
    background: white;
    padding: 8px 15px;
    border-radius: 5px;
    display: inline-block;
}

.loading-dots {
    display: inline-block;
}

.loading-dots span {
    animation: blink 1.4s infinite;
    animation-fill-mode: both;
}

.loading-dots span:nth-child(2) {
    animation-delay: 0.2s;
}

.loading-dots span:nth-child(3) {
    animation-delay: 0.4s;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes moveLeftRight {
    0%, 100% {
        transform: translateX(-20px);
    }
    50% {
        transform: translateX(20px);
    }
}

@keyframes blink {
    0%, 80%, 100% {
        opacity: 0;
    }
    40% {
        opacity: 1;
    }
}

/* Cancel Message */
.cancel-message {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #dc3545;
    color: white;
    padding: 20px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
    z-index: 10001;
    animation: slideInRight 0.5s;
}

@keyframes slideInRight {
    from {
        transform: translateX(400px);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>
@endpush

@push('js')
<script type="text/javascript">
    "use strict";
    
    $(document).ready(function() {
        // Update selected count
        function updateSelectedCount() {
            var selectedCount = $('.user-checkbox:checked').length;
            $('#selected-count').text(selectedCount);
            
            // Enable/disable send button (removed checkbox requirement)
            if (selectedCount > 0 && $('#whatsapp-message').val().trim() !== '') {
                $('#send-btn').prop('disabled', false);
            } else {
                $('#send-btn').prop('disabled', true);
            }
        }

        // Select all users
        $('#select-all-users').click(function() {
            $('.user-checkbox').prop('checked', true);
            updateSelectedCount();
        });

        // Deselect all users
        $('#deselect-all-users').click(function() {
            $('.user-checkbox').prop('checked', false);
            updateSelectedCount();
        });

        // User search functionality
        $('#user-search').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('.user-item').each(function() {
                var userName = $(this).data('user-name').toLowerCase();
                var userEmail = $(this).find('label').text().toLowerCase();
                
                if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Update count when checkbox changes
        $(document).on('change', '.user-checkbox', function() {
            updateSelectedCount();
        });

        // Update message preview in real-time
        $('#whatsapp-message').on('input', function() {
            var message = $(this).val();
            if (message.trim() === '') {
                $('#message-preview').html('<strong>Hello [[name]],</strong><br>This is a preview of your message. The [[name]] placeholder will be replaced with each user\'s first name.');
            } else {
                $('#message-preview').html(message.replace(/\[\[name\]\]/g, '<strong>John</strong>'));
            }
            updateSelectedCount();
        });

        // File upload handling
        $('#attachment').on('change', function() {
            var file = this.files[0];
            if (file) {
                // Update label
                $('#attachment-label').text(file.name);
                
                // Show preview
                $('#file-name').text(file.name);
                var fileSize = (file.size / 1024).toFixed(2) + ' KB';
                if (file.size > 1024 * 1024) {
                    fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
                }
                $('#file-size').text(fileSize);
                $('#file-preview').slideDown();
                
                // Validate file size
                if (file.size > 10240 * 1024) {
                    Notiflix.Report.failure(
                        '@lang("File Too Large")',
                        '@lang("File size exceeds 10MB limit. Please choose a smaller file.")',
                        '@lang("OK")'
                    );
                    $('#attachment').val('');
                    $('#attachment-label').text('@lang("Choose file...")');
                    $('#file-preview').slideUp();
                }
            }
        });
        
        // Remove file button
        $('#remove-file').on('click', function() {
            $('#attachment').val('');
            $('#attachment-label').text('@lang("Choose file...")');
            $('#file-preview').slideUp();
        });

        // Send button click - Show custom confirmation
        $('#send-btn').on('click', function(e) {
            e.preventDefault();
            
            var selectedCount = $('.user-checkbox:checked').length;
            
            if (selectedCount === 0) {
                Notiflix.Report.warning(
                    '@lang("No Users Selected")',
                    '@lang("Please select at least one user to send the message.")',
                    '@lang("OK")'
                );
                return;
            }
            
            // Show custom confirmation modal
            showCustomConfirm(selectedCount);
        });

        // Custom confirmation modal
        function showCustomConfirm(selectedCount) {
            var hasAttachment = $('#attachment').val() !== '';
            var fileName = hasAttachment ? $('#file-name').text() : '';
            
            var attachmentInfo = hasAttachment ? 
                '<p><i class="fas fa-paperclip"></i> @lang("With attachment:") <strong>' + fileName + '</strong></p>' : 
                '<p>@lang("Text message only")</p>';
            
            var modalHtml = `
                <div id="customConfirmModal" class="custom-confirm-modal">
                    <div class="custom-confirm-content">
                        <div class="custom-confirm-header">
                            <i class="fab fa-whatsapp"></i>
                        </div>
                        <div class="custom-confirm-body">
                            <h4>@lang("Send WhatsApp Message?")</h4>
                            <p>@lang("Are you sure you want to send this WhatsApp message to:")</p>
                            <div class="user-count-badge">
                                ${selectedCount} ${selectedCount === 1 ? '@lang("User")' : '@lang("Users")'}
                            </div>
                            ${attachmentInfo}
                            <p style="color: #999; font-size: 14px; margin-top: 15px;">@lang("This action cannot be undone.")</p>
                        </div>
                        <div class="custom-confirm-buttons">
                            <button type="button" class="btn-confirm-yes" id="confirmYes">
                                <i class="fas fa-check"></i> @lang("Yes, Send Now")
                            </button>
                            <button type="button" class="btn-confirm-no" id="confirmNo">
                                <i class="fas fa-times"></i> @lang("No, Cancel")
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            $('body').append(modalHtml);
            $('#customConfirmModal').fadeIn(300);
            
            // Handle Yes button
            $('#confirmYes').on('click', function() {
                $('#customConfirmModal').fadeOut(300, function() {
                    $(this).remove();
                    sendWhatsAppMessages();
                });
            });
            
            // Handle No button
            $('#confirmNo').on('click', function() {
                $('#customConfirmModal').fadeOut(300, function() {
                    $(this).remove();
                    showCancelMessage();
                });
            });
        }

        // Show cancel message
        function showCancelMessage() {
            var cancelHtml = `
                <div id="cancelMessage" class="cancel-message">
                    <i class="fas fa-times-circle"></i> 
                    <strong>@lang("Operation Cancelled by Admin")</strong>
                    <p style="margin: 5px 0 0 0; font-size: 14px;">@lang("WhatsApp message was not sent.")</p>
                </div>
            `;
            
            $('body').append(cancelHtml);
            
            // Auto remove after 4 seconds
            setTimeout(function() {
                $('#cancelMessage').fadeOut(500, function() {
                    $(this).remove();
                });
            }, 4000);
        }

        // Function to submit form and show custom loading screen
        function sendWhatsAppMessages() {
            // Show custom loading screen
            var loadingHtml = `
                <div id="loadingScreen" class="loading-screen">
                    <div class="loading-content">
                        <div class="whatsapp-logo-container">
                            <div class="whatsapp-logo">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                        </div>
                        <div class="loading-text">@lang("Sending WhatsApp Messages")</div>
                    </div>
                </div>
            `;
            
            $('body').append(loadingHtml);
            $('#loadingScreen').fadeIn(300);
            
            // Disable button and show loading state
            $('#send-btn').html('<i class="fas fa-spinner fa-spin"></i> @lang("Sending...")').prop('disabled', true);
            
            // Submit form via AJAX
            var formData = new FormData($('form')[0]);
            
            $.ajax({
                url: $('form').attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Remove loading screen
                    $('#loadingScreen').fadeOut(300, function() {
                        $(this).remove();
                    });
                    
                    // Show success message
                    Notiflix.Report.success(
                        '✅ @lang("Success!")',
                        '@lang("WhatsApp messages have been sent successfully!")',
                        '@lang("OK")',
                        function() {
                            // Reload page to reset form
                            window.location.reload();
                        }
                    );
                },
                error: function(xhr, status, error) {
                    // Remove loading screen
                    $('#loadingScreen').fadeOut(300, function() {
                        $(this).remove();
                    });
                    
                    // Reset button
                    $('#send-btn').html('<i class="fab fa-whatsapp"></i> <span>@lang("Send WhatsApp Message")</span>').prop('disabled', false);
                    
                    // Show error message
                    var errorMessage = '@lang("Failed to send WhatsApp messages. Please try again.")';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Notiflix.Report.failure(
                        '❌ @lang("Error")',
                        errorMessage,
                        '@lang("OK")'
                    );
                }
            });
        }

        // Prevent default form submission
        $('form').on('submit', function(e) {
            e.preventDefault();
            return false;
        });

        // Initial count update
        updateSelectedCount();
    });
</script>
@endpush
