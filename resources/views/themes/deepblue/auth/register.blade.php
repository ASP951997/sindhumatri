@extends($theme.'layouts.app')
@section('title',trans('Register'))

@section('content')
    <section class="login-section">
        <div class="container">
            <div class="row">
                <div class="col">
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="row g-3 g-md-4">

                            <div class="col-md-6 form-group">
                                <input class="form-control" pattern="[A-Za-z]+" type="text" name="firstname" title="Only letters are allowed" value="{{old('firstname')}}" placeholder="@lang('First Name')" required>
                                @error('firstname')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" pattern="[A-Za-z]+" type="text" name="lastname" title="Only letters are allowed" value="{{old('lastname')}}"  placeholder="@lang('Last Name')" required>
                                @error('lastname')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="username" value="{{old('username')}}"  placeholder="@lang('Username')" required>
                                @error('username')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group">
                                <input class="form-control" type="text" name="email" value="{{old('email')}}"  placeholder="@lang('Email Address')" required>
                                @error('email')
                                <span class="text-danger mt-1">@lang($message)</span>
                                @enderror
                            </div>

                            <div class="col-md-12 form-group">
                                    @php
                                        $country_code = (string) @getIpInfo()['code'] ?: null;
                                        $myCollection = collect(config('country'))->map(function($row) {
                                            return collect($row);
                                        });
                                        $countries = $myCollection->sortBy('code');
                                    @endphp

                                    <div class="input-group">
                                        <div class="input-group-prepend w-50">
                                            <select name="phone_code" class="form-control country_code dialCode-change" required>
                                                @foreach(config('country') as $value)
                                                    <option value="{{$value['phone_code']}}"
                                                            data-name="{{$value['name']}}"
                                                            data-code="{{$value['code']}}"
                                                        {{$country_code == $value['code'] ? 'selected' : ''}}
                                                    > {{$value['name']}} ({{$value['phone_code']}})

                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="tel" name="phone" class="form-control dialcode-set"
                                            value="{{old('phone')}}"
                                            placeholder="@lang('Your Phone Number')" onkeyup="this.value = this.value.replace(/[^0-9-]/g, '');" pattern="[0-9]{10}" maxlength="10" title="Please enter a 10-digit phone number" required>
                                    </div>


                                    @error('phone')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror

                                    <input type="hidden" name="country_code" value="{{old('country_code')}}" class="text-dark" >
                            </div>


                            <!-- Password Field -->
<div class="form-group">
    <label for="password">Password</label>
    <div class="input-group">
        <input type="password" name="password" id="password" class="form-control" required>
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fas fa-eye-slash toggle-password" data-toggle="#password"></i>
            </span>
        </div>
    </div>
</div>

<!-- Confirm Password Field -->
<div class="form-group">
    <label for="password_confirmation">Confirm Password</label>
    <div class="input-group">
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fas fa-eye-slash toggle-password" data-toggle="#password_confirmation"></i>
            </span>
        </div>
    </div>
</div>


                            @if(basicControl()->reCaptcha_status_registration)
                                <div class="col-md-12 form-group">
                                    {!! NoCaptcha::renderJs(session()->get('trans')) !!}
                                    {!! NoCaptcha::display() !!}
                                    @error('g-recaptcha-response')
                                        <span class="text-danger mt-1">@lang($message)</span>
                                    @enderror
                                </div>
                            @endif


                            <div class="col-12">
                                <div class="links">
                                    <div class="form-check">
                                       <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault"/>
                                       <label class="form-check-label" for="flexCheckDefault">
                                          @lang('By signing up you agree to our ')
                                          <a href="">@lang('T&C.')</a>
                                       </label>
                                    </div>
                                 </div>
                            </div>

                        </div>

                        <button class="btn-flower">@lang('sign up')</button>

                        <div class="bottom">@lang('Already have an account?')<br />
                            <a href="{{ route('login') }}">@lang('Sign In')</a>
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
        $(document).ready(function () {
            setDialCode();
            $(document).on('change', '.dialCode-change', function () {
                setDialCode();
            });
            function setDialCode() {
                let currency = $('.dialCode-change').val();
                //$('.dialcode-set').val(currency);
            }
        });
		
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
