
<!--------------Astronomic Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="astronomicInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseAstronomicInformation"
            aria-expanded="false"
            aria-controls="collapseAstronomicInformation"
        >
            <i class="fas fa-telescope"></i>
            @lang('Astronomic Information')
        </button>
    </h5>

    <div
        id="collapseAstronomicInformation"
        class="accordion-collapse collapse @if($errors->has('astronomicInformation')|| session()->get('name') == 'astronomicInformation') show @endif"
        aria-labelledby="astronomicInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.astronomicInformation')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="sun_sign">@lang('Zodic sign')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="sun_sign"
							id="sun_sign"
                            value="{{old('sun_sign') ?? $user->sun_sign }}"
                            placeholder="@lang('Zodic sign')"
                        />
                        @if($errors->has('sun_sign'))
                            <div class="error text-danger">@lang($errors->first('sun_sign')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="moon_sign">@lang('moon sign')</label>
                        <input
                            type="text"
                            class="form-control"
                            name="moon_sign"
                            value="{{old('moon_sign') ?? $user->moon_sign }}"
                            placeholder="@lang('moon sign')"
                        />
                        @if($errors->has('moon_sign'))
                            <div class="error text-danger">@lang($errors->first('moon_sign')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="time_of_birth">@lang('Time of Birth')</label>
                        <input type="time" class="form-control" name="time_of_birth"
                               value="{{old('time_of_birth') ?? $user->time_of_birth }}"/>
                        @error('time_of_birth')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="city_of_birth">@lang('City of Birth')</label>
                        <input type="text" class="form-control" name="city_of_birth"
                               value="{{old('city_of_birth') ?? $user->city_of_birth }}"/>
                        @error('city_of_birth')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script>
        "use strict";
        function calculateZodiac() {
            const birthdate = new Date(document.getElementById('date_of_birth').value);
			//alert(birthdate);
            const day = birthdate.getDate();
            const month = birthdate.getMonth() + 1; // JavaScript months are 0-11

            let zodiacSign = "";

            if ((month == 1 && day >= 20) || (month == 2 && day <= 18)) {
                zodiacSign = "Aquarius";
            } else if ((month == 2 && day >= 19) || (month == 3 && day <= 20)) {
                zodiacSign = "Pisces";
            } else if ((month == 3 && day >= 21) || (month == 4 && day <= 19)) {
                zodiacSign = "Aries";
            } else if ((month == 4 && day >= 20) || (month == 5 && day <= 20)) {
                zodiacSign = "Taurus";
            } else if ((month == 5 && day >= 21) || (month == 6 && day <= 20)) {
                zodiacSign = "Gemini";
            } else if ((month == 6 && day >= 21) || (month == 7 && day <= 22)) {
                zodiacSign = "Cancer";
            } else if ((month == 7 && day >= 23) || (month == 8 && day <= 22)) {
                zodiacSign = "Leo";
            } else if ((month == 8 && day >= 23) || (month == 9 && day <= 22)) {
                zodiacSign = "Virgo";
            } else if ((month == 9 && day >= 23) || (month == 10 && day <= 22)) {
                zodiacSign = "Libra";
            } else if ((month == 10 && day >= 23) || (month == 11 && day <= 21)) {
                zodiacSign = "Scorpio";
            } else if ((month == 11 && day >= 22) || (month == 12 && day <= 21)) {
                zodiacSign = "Sagittarius";
            } else if ((month == 12 && day >= 22) || (month == 1 && day <= 19)) {
                zodiacSign = "Capricorn";
            }

            document.getElementById('sun_sign').value = "" + zodiacSign;
        }
		$(document).ready(function () {
		calculateZodiac();
		});
    </script>
@endpush