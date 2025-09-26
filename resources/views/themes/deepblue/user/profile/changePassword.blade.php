@extends($theme.'layouts.user')
@section('title',trans('Change Password'))

@section('content')

    <section class="dashboard-section">
        <div class="container">
            <div class="row gy-5 g-lg-4">
                @include($theme.'user.sidebar')

                <div class="col-lg-9">
                    <div class="dashboard-content">
                        <div class="row">
                            <div class="col-12">
                                <div class="dashboard-title">
                                    <h5>@lang('Change Password')</h5>
                                </div>

                                <form method="post" action="{{ route('user.updatePassword') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row g-3 g-md-4 generate-btn-parent">
                                        <div class="col-md-12 form-group">
                                            <label for="current_password">@lang('Current Password')</label>
											 <div class="input-group">
                                            <input type="password" name="current_password" id="current_password" class="form-control" placeholder="@lang('Enter Current Password')" autocomplete="off"/>
											<div class="input-group-append">
										<span class="input-group-text">
											<i class="fas fa-eye toggle-password" data-toggle="#current_password"></i>
										</span>
									</div>
									</div>
                                            @if($errors->has('current_password'))
                                                <div class="error text-danger">@lang($errors->first('current_password')) </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="password">@lang('New Password')</label>
											 <div class="input-group">
                                            <input type="password" name="password" id="password" class="form-control" placeholder="@lang('Enter New Password')" autocomplete="off"/>
											<div class="input-group-append">
										<span class="input-group-text">
											<i class="fas fa-eye toggle-password" data-toggle="#password"></i>
										</span>
									</div>
									</div>
                                            @if($errors->has('password'))
                                                <div class="error text-danger">@lang($errors->first('password')) </div>
                                            @endif
                                        </div>

                                        <div class="col-md-12 form-group">
                                            <label for="password_confirmation">@lang('Confirm Password')</label>
											 <div class="input-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="@lang('Enter Confirm Password')" autocomplete="off"/>
											<div class="input-group-append">
													<span class="input-group-text">
														<i class="fas fa-eye toggle-password" data-toggle="#password_confirmation"></i>
													</span>
												</div>
												</div>
                                            @if($errors->has('password_confirmation'))
                                                <div class="error text-danger">@lang($errors->first('password_confirmation')) </div>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="col-12 text-end mt-3">
                                        <button type="submit" class="btn-flower2 w-100">@lang('Update Password')</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
@push('script')
    <script>
        "use strict";
		
	document.querySelectorAll('.toggle-password').forEach(item => {
        item.addEventListener('click', function() {
            const input = document.querySelector(this.getAttribute('data-toggle'));
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });

    </script>
@endpush