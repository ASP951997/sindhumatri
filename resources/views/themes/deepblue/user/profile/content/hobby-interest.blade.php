
<!-------------- Hobbies & Interest ----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="hobbyInterest">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseHobbyInterest"
            aria-expanded="false"
            aria-controls="collapseHobbyInterest"
        >
            <i class="fal fa-gem"></i>
            @lang('Hobbies & Interest')
        </button>
    </h5>
    <div
        id="collapseHobbyInterest"
        class="accordion-collapse collapse @if($errors->has('hobbyInterest') || session()->get('name') == 'hobbyInterest') show @endif"
        aria-labelledby="hobbyInterest"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.hobbyInterest')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="hobbies">@lang('Hobbies')</label> <span class="text-danger">*</span>
                        <!--<input
                            type="text"
                            class="form-control"
                            name="hobbies"
                            value="{{old('hobbies') ?? $user->hobbies }}"
                            data-role="tagsinput"
                        /> -->
                        <select
                            class="form-select"
                            name="hobbies[]"
							multiple
                            data-live-search="true"
                            aria-label="hobbies"
                        >
						
						 @php
                                $array_of_hobbies = json_decode($user->hobbies);
                            @endphp
                             @foreach(config('languages')['hobbies'] as $key => $item)
                                <option value="{{$item}}"
                                        @if(is_array($array_of_hobbies))
                                            @if((in_array($item,$array_of_hobbies)))
                                                selected
                                            @endif
                                        @endif
                                     >
                                    {{$item}}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('hobbies'))
                            <div class="error text-danger">@lang($errors->first('hobbies')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="interests">@lang('Interests')</label> <span class="text-danger">*</span>
                        <!--<input
                            type="text"
                            class="form-control"
                            name="interests"
                            value="{{old('interests') ?? $user->interests }}"
                            data-role="tagsinput"
                        /> -->
                        <select
                            class="form-select"
                            name="interests[]"
                            aria-label="interests"
							multiple
                            data-live-search="true"
                        >
                           @php
                                $array_of_interests = json_decode($user->interests);
                            @endphp
                             @foreach(config('languages')['interests'] as $key => $item)
                                <option value="{{$item}}"
                                        @if(is_array($array_of_interests))
                                            @if((in_array($item,$array_of_interests)))
                                                selected
                                            @endif
                                        @endif
                                     >
                                    {{$item}}
                                </option>
                            @endforeach
                        </select>
                        @if($errors->has('interests'))
                            <div class="error text-danger">@lang($errors->first('interests')) </div>
                        @endif
                    </div>

                    


                    <div class="col-12 text-end">
                        <button type="submit" class="btn-flower2 btn-full mt-2">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

