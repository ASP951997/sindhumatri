
<!--------------Family Information----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="familyInformation">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseFamilyInformation"
            aria-expanded="false"
            aria-controls="collapseFamilyInformation"
        >
            <i class="fas fa-house-day"></i>
            @lang('Family Information')
        </button>
    </h5>

    <div
        id="collapseFamilyInformation"
        class="accordion-collapse collapse @if($errors->has('familyInformation') || session()->get('name') == 'familyInformation') show @endif"
        aria-labelledby="familyInformation"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.familyInformation')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                    <div class="col-md-6 form-group">
                        <label for="father">@lang('father')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="father"
                            aria-label="father"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Businessman/Entrepreneur" {{old('father', $user->father == 'Businessman/Entrepreneur') ? 'selected' : ''}}>@lang('Businessman/Entrepreneur')</option>
                            <option value="Private Employee" {{old('father', $user->father == 'Private Employee"') ? 'selected' : ''}}>@lang('Private Employee"')</option>
                            <option value="Govt./ PSU Employee" {{old('father', $user->father == 'Govt./ PSU Employee') ? 'selected' : ''}}>@lang('Govt./ PSU Employee')</option>
                            <option value="Armed Forces Employee" {{old('father', $user->father == 'Armed Forces Employee') ? 'selected' : ''}}>@lang('Armed Forces Employee')</option>
                            <option value="Civil Servant" {{old('father', $user->father == 'Civil Servant') ? 'selected' : ''}}>@lang('Civil Servant')</option>
                            <option value="Retired" {{old('father', $user->father == 'Retired') ? 'selected' : ''}}>@lang('Retired')</option>
                            <option value="Not Employed" {{old('father', $user->father == 'Not Employed') ? 'selected' : ''}}>@lang('Not Employed')</option>
                            <option value="Passed Away" {{old('father', $user->father == 'Passed Away') ? 'selected' : ''}}>@lang('Passed Away')</option>
                        </select>
                        @error('father')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="mother">@lang('mother')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="mother"
                            aria-label="mother"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Homemaker" {{old('mother', $user->mother == 'Homemaker') ? 'selected' : ''}}>@lang('Homemaker')</option>
                            <option value="Businesswoman/Entrepreneur" {{old('mother', $user->mother == 'Businesswoman/Entrepreneur') ? 'selected' : ''}}>@lang('Businesswoman/Entrepreneur')</option>
                            <option value="Private Employee" {{old('mother', $user->mother == 'Private Employee') ? 'selected' : ''}}>@lang('Private Employee')</option>
                            <option value="Govt./ PSU Employee" {{old('mother', $user->mother == 'Govt./ PSU Employee') ? 'selected' : ''}}>@lang('Govt./ PSU Employee')</option>
                            <option value="Armed Forces Employee" {{old('mother', $user->mother == 'Armed Forces Employee') ? 'selected' : ''}}>@lang('Armed Forces Employee')</option>
                            <option value="Civil Servant" {{old('mother', $user->mother == 'Civil Servant') ? 'selected' : ''}}>@lang('Civil Servant')</option>
                            <option value="Teacher" {{old('mother', $user->mother == 'Teacher') ? 'selected' : ''}}>@lang('Teacher')</option>
                            <option value="Retired" {{old('mother', $user->mother == 'Retired') ? 'selected' : ''}}>@lang('Retired')</option>
                            <option value="Passed Away" {{old('mother', $user->mother == 'Passed Away') ? 'selected' : ''}}>@lang('Passed Away')</option>
                        </select>
                        @error('mother')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="brother_no">@lang('No. of brothers')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="brother_no"
                            id="brother_no"
                            aria-label="brother_no"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1" {{old('brother_no', $user->brother_no == '1') ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('brother_no', $user->brother_no == '2') ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('brother_no', $user->brother_no == '3') ? 'selected' : ''}}>3</option>
                            <option value="4" {{old('brother_no', $user->brother_no == '4') ? 'selected' : ''}}>4</option>
                            <option value="5" {{old('brother_no', $user->brother_no == '5') ? 'selected' : ''}}>5</option>
                            <option value="6" {{old('brother_no', $user->brother_no == '6') ? 'selected' : ''}}>6</option>
                            <option value="7" {{old('brother_no', $user->brother_no == '7') ? 'selected' : ''}}>7</option>
                            <option value="8" {{old('brother_no', $user->brother_no == '8') ? 'selected' : ''}}>8</option>
                            <option value="None" {{old('brother_no', $user->brother_no == 'None') ? 'selected' : ''}}>@lang('None')</option>
                        </select>
                        @error('brother_no')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sister_no">@lang('No. of sisters')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sister_no"
                            id="sister_no"
                            aria-label="sister_no"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1" {{old('sister_no', $user->sister_no == '1') ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('sister_no', $user->sister_no == '2') ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('sister_no', $user->sister_no == '3') ? 'selected' : ''}}>3</option>
                            <option value="4" {{old('sister_no', $user->sister_no == '4') ? 'selected' : ''}}>4</option>
                            <option value="5" {{old('sister_no', $user->sister_no == '5') ? 'selected' : ''}}>5</option>
                            <option value="6" {{old('sister_no', $user->sister_no == '6') ? 'selected' : ''}}>6</option>
                            <option value="7" {{old('sister_no', $user->sister_no == '7') ? 'selected' : ''}}>7</option>
                            <option value="8" {{old('sister_no', $user->sister_no == '8') ? 'selected' : ''}}>8</option>
                            <option value="None" {{old('sister_no', $user->sister_no == 'None') ? 'selected' : ''}}>@lang('None')</option>
                        </select>
                        @error('sister_no')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group" id="brother_married">
                        <label for="brother_married">@lang('Married brothers')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="brother_married"
                            
                            aria-label="brother_married"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1" {{old('brother_married', $user->brother_married == '1') ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('brother_married', $user->brother_married == '2') ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('brother_married', $user->brother_married == '3') ? 'selected' : ''}}>3</option>
                            <option value="4" {{old('brother_married', $user->brother_married == '4') ? 'selected' : ''}}>4</option>
                            <option value="5" {{old('brother_married', $user->brother_married == '5') ? 'selected' : ''}}>5</option>
                            <option value="6" {{old('brother_married', $user->brother_married == '6') ? 'selected' : ''}}>6</option>
                            <option value="7" {{old('brother_married', $user->brother_married == '7') ? 'selected' : ''}}>7</option>
                            <option value="8" {{old('brother_married', $user->brother_married == '8') ? 'selected' : ''}}>8</option>
                            <option value="None" {{old('brother_married', $user->brother_married == 'None') ? 'selected' : ''}}>@lang('None')</option>
                        </select>
                        @error('brother_married')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group" id="sister_married">
                        <label for="sister_married">@lang('Married sisters')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sister_married"
                            
                            aria-label="sister_married"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1" {{old('sister_married', $user->sister_married == '1') ? 'selected' : ''}}>1</option>
                            <option value="2" {{old('sister_married', $user->sister_married == '2') ? 'selected' : ''}}>2</option>
                            <option value="3" {{old('sister_married', $user->sister_married == '3') ? 'selected' : ''}}>3</option>
                            <option value="4" {{old('sister_married', $user->sister_married == '4') ? 'selected' : ''}}>4</option>
                            <option value="5" {{old('sister_married', $user->sister_married == '5') ? 'selected' : ''}}>5</option>
                            <option value="6" {{old('sister_married', $user->sister_married == '6') ? 'selected' : ''}}>6</option>
                            <option value="7" {{old('sister_married', $user->sister_married == '7') ? 'selected' : ''}}>7</option>
                            <option value="8" {{old('sister_married', $user->sister_married == '8') ? 'selected' : ''}}>8</option>
                            <option value="None" {{old('sister_married', $user->sister_married == 'None') ? 'selected' : ''}}>@lang('None')</option>
                        </select>
                        @error('sister_married')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="sibling_position">@lang('No. Of Position In Siblings')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="sibling_position"
                            aria-label="sibling_position"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="1st" {{old('sibling_position', $user->sibling_position == '1st') ? 'selected' : ''}}>@lang('1st')</option>
                            <option value="2nd" {{old('sibling_position', $user->sibling_position == '2nd') ? 'selected' : ''}}>@lang('2nd')</option>
                            <option value="3rd" {{old('sibling_position', $user->sibling_position == '3rd') ? 'selected' : ''}}>@lang('3rd')</option>
                            <option value="4th" {{old('sibling_position', $user->sibling_position == '4th') ? 'selected' : ''}}>@lang('4th')</option>
                            <option value="5th" {{old('sibling_position', $user->sibling_position == '5th') ? 'selected' : ''}}>@lang('5th')</option>
                            <option value="6th" {{old('sibling_position', $user->sibling_position == '6th') ? 'selected' : ''}}>@lang('6th')</option>
                            <option value="7th" {{old('sibling_position', $user->sibling_position == '7th') ? 'selected' : ''}}>@lang('7th')</option>
                            <option value="8th" {{old('sibling_position', $user->sibling_position == '8th') ? 'selected' : ''}}>@lang('8th')</option>
                        </select>
                        @error('sibling_position')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>
					
					
					<div class="col-md-6 form-group">
                        <label for="family_income">@lang('Family Income')</label> <span class="text-danger">*</span>
                        <select
                            class="form-select"
                            name="family_income"
                            aria-label="family_income"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            <option value="Below 1 lakh" {{old('family_income', $user->family_income == 'Below 1 lakh') ? 'selected' : ''}}>@lang('Below 1 lakh')</option>
                            <option value="1-2 lakhs" {{old('family_income', $user->family_income == '1-2 lakhs') ? 'selected' : ''}}>@lang('1-2 lakhs')</option>
                            <option value="3-5 lakhs" {{old('family_income', $user->family_income == '3-5 lakhs') ? 'selected' : ''}}>@lang('3-5 lakhs')</option>
                            <option value="5-7 lakhs" {{old('family_income', $user->family_income == '5-7 lakhs') ? 'selected' : ''}}>@lang('5-7 lakhs')</option>
                            <option value="7-10 lakhs" {{old('family_income', $user->family_income == '7-10 lakhs') ? 'selected' : ''}}>@lang('7-10 lakhs')</option>
                            <option value="10-15 lakhs" {{old('family_income', $user->family_income == '10-15 lakhs') ? 'selected' : ''}}>@lang('10-15 lakhs')</option>
                            <option value="15-20 lakhs" {{old('family_income', $user->family_income == '15-20 lakhs') ? 'selected' : ''}}>@lang('15-20 lakhs')</option>
                            <option value="20-30 lakhs" {{old('family_income', $user->family_income == '20-30 lakhs') ? 'selected' : ''}}>@lang('20-30 lakhs')</option>
							<option value="30-50 lakhs" {{old('family_income', $user->family_income == '30-50 lakhs') ? 'selected' : ''}}>@lang('30-50 lakhs')</option>
							<option value="50-70 lakhs" {{old('family_income', $user->family_income == '50-70 lakhs') ? 'selected' : ''}}>@lang('50-70 lakhs')</option>
							<option value="70 lakhs - 1 Cr" {{old('family_income', $user->family_income == '70 lakhs - 1 Cr') ? 'selected' : ''}}>@lang('70 lakhs - 1 Cr')</option>
							<option value="Above 1 Cr" {{old('family_income', $user->family_income == 'Above 1 Cr') ? 'selected' : ''}}>@lang('Above 1 Cr')</option>
							
							
                        </select>
                        @error('family_income')
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
    $(document).ready(function () {
       
        function validateDateOfBirth() {
            
        }

       

        // Check when dropdown value changes
        $(document).on('change', '#brother_no', function () {
            var idx = this.selectedIndex;
            //alert(idx);
            if(idx == 9){
                $('#brother_married').hide();
            } else {
                $('#brother_married').show();
            }
            
           
        });

         // Validate date of birth on change
        $(document).on('change', '#sister_no', function () {
            var idx = this.selectedIndex;
            //alert(idx);
            if(idx == 9){
                $('#sister_married').hide();
            } else {
                $('#sister_married').show();
            }
        });
    });
</script>

@endpush