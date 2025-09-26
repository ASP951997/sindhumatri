@extends($theme.'layouts.app')
@section('title',trans('Login'))


@section('content')
    <!-- login section -->
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="row g-3 g-md-4">
                            <div class="col-12">
                                <input class="form-control" type="text" name="username" value="{{old('username')}}" placeholder="@lang('Email Or Username')">
                                @error('username')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                                @error('email')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-12">
                                 <div class="input-group">
									<input type="password" name="password" id="password" class="form-control" placeholder="@lang('Password')" required>
									<div class="input-group-append">
										<span class="input-group-text">
											<i class="fas fa-eye toggle-password" data-toggle="#password" ></i>
										</span>
									</div>
								</div>
                                @error('password')
                                    <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            @if(basicControl()->reCaptcha_status_login)
                                <div class="col-12">
                                    {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                        <span class="text-danger">@lang($message)</span>
                                    @enderror
                                </div>
                            @endif

                            <div class="col-12">
                                <div class="links">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} value="" id="flexCheckDefault"/>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            @lang('Remember me')
                                        </label>
                                    </div>
                                    <a href="{{ route('password.request') }}">@lang('Forgot password?')</a>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn-flower">@lang('sign in')</button>
                        <div class="bottom">@lang("Don't have an account?") <br />
                            <a href="{{ route('register') }}">@lang('Create account')</a>
                        </div>
                    </form>
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