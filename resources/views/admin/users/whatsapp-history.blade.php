@extends('admin.layouts.app')
@section('title')
    @lang('WhatsApp Message History')
@endsection
@section('content')

    <div class="card card-primary m-0 m-md-4 my-4 m-md-0 shadow">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">@lang("WhatsApp Message History")</h3>
                <div>
                    <a href="{{ route('admin.whatsapp-send') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> @lang('Send New Message')
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>@lang('Date')</th>
                            <th>@lang('Recipient')</th>
                            <th>@lang('Phone')</th>
                            <th>@lang('Message')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Response')</th>
                            <th>@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($messages as $message)
                            <tr>
                                <td>
                                    <small>{{ $message->formatted_date }}</small>
                                </td>
                                <td>
                                    @if($message->user)
                                        <a href="{{ route('admin.user-edit', $message->user_id) }}">
                                            {{ $message->recipient_name ?? $message->user->firstname . ' ' . $message->user->lastname }}
                                        </a>
                                    @else
                                        {{ $message->recipient_name ?? 'N/A' }}
                                    @endif
                                </td>
                                <td>
                                    <code>{{ $message->phone }}</code>
                                </td>
                                <td>
                                    <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $message->message }}">
                                        {{ Str::limit($message->message, 50) }}
                                    </div>
                                    @if($message->attachment_path)
                                        <br><small class="text-muted">
                                            <i class="fas fa-paperclip"></i> {{ $message->attachment_path }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $message->status_badge_class }}">
                                        {{ ucfirst($message->status) }}
                                    </span>
                                    @if($message->http_code)
                                        <br><small class="text-muted">HTTP {{ $message->http_code }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($message->error_message)
                                        <small class="text-danger">{{ Str::limit($message->error_message, 30) }}</small>
                                    @elseif($message->api_response)
                                        <small class="text-success">@lang('Success')</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#messageModal{{ $message->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>

                            <!-- Message Detail Modal -->
                            <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">@lang('Message Details')</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>@lang('Date:')</strong><br>
                                                    {{ $message->formatted_date }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>@lang('Status:')</strong><br>
                                                    <span class="badge {{ $message->status_badge_class }}">
                                                        {{ ucfirst($message->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>@lang('Recipient:')</strong><br>
                                                    {{ $message->recipient_name ?? 'N/A' }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>@lang('Phone:')</strong><br>
                                                    <code>{{ $message->phone }}</code>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <strong>@lang('Message:')</strong><br>
                                                <div class="alert alert-light border">
                                                    {{ $message->message }}
                                                </div>
                                            </div>
                                            @if($message->attachment_path)
                                                <div class="mb-3">
                                                    <strong>@lang('Attachment:')</strong><br>
                                                    <i class="fas fa-paperclip"></i> {{ $message->attachment_path }}
                                                </div>
                                            @endif
                                            @if($message->api_response)
                                                <div class="mb-3">
                                                    <strong>@lang('API Response:')</strong><br>
                                                    <pre class="bg-light p-2 rounded" style="max-height: 200px; overflow-y: auto;"><code>{{ $message->api_response }}</code></pre>
                                                </div>
                                            @endif
                                            @if($message->error_message)
                                                <div class="mb-3">
                                                    <strong>@lang('Error:')</strong><br>
                                                    <div class="alert alert-danger">
                                                        {{ $message->error_message }}
                                                    </div>
                                                </div>
                                            @endif
                                            @if($message->http_code)
                                                <div class="mb-3">
                                                    <strong>@lang('HTTP Code:')</strong> {{ $message->http_code }}
                                                </div>
                                            @endif
                                            @if($message->api_id)
                                                <div class="mb-3">
                                                    <strong>@lang('API ID:')</strong> {{ $message->api_id }}<br>
                                                    <strong>@lang('Device:')</strong> {{ $message->device_name ?? 'N/A' }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">@lang('Close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="py-4">
                                        <i class="fab fa-whatsapp fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">@lang('No WhatsApp messages sent yet.')</p>
                                        <a href="{{ route('admin.whatsapp-send') }}" class="btn btn-primary">
                                            <i class="fas fa-plus"></i> @lang('Send Your First Message')
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($messages->hasPages())
                <div class="mt-3">
                    {{ $messages->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection























