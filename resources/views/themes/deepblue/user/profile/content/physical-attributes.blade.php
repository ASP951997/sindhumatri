
<!--------------Physical Attributes----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="physicalAttributes">
        <button
            class="accordion-button collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapsePhysicalAttributes"
            aria-expanded="false"
            aria-controls="collapsePhysicalAttributes"
        >
            <i class="fas fa-child"></i>
            @lang('Physical Attributes')
        </button>
    </h5>
    <div
        id="collapsePhysicalAttributes"
        class="accordion-collapse collapse @if($errors->has('physicalAttributes') || session()->get('name') == 'physicalAttributes') show @endif"
        aria-labelledby="physicalAttributes"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form action="{{ route('user.physicalAttributes')}}" method="post">
                @csrf
                <div class="row g-3 g-md-4">

                <div class="col-md-6 form-group">
                        <label for="height">@lang('Height (Feet and Inches)')</label> <span class="text-danger">*</span>
                        <select class="form-select" name="height" aria-label="height">
                            <option value="" disabled selected>@lang('Select Height')</option>
							@for ($ft = 4; $ft <= 7; $ft++)
								@for ($in = 0; $in < 12; $in++)
									@if ($ft == 4 && $in < 5) @continue @endif
									@if ($ft == 7 && $in > 0) @break @endif
									@php
										$heightInCm = round(($ft * 30.48) + ($in * 2.54));
										$heightString = $ft . 'ft ' . $in . 'in (' . $heightInCm . ' cm)';
									@endphp
									<option value="{{ $ft . 'ft ' . $in . 'in' }}" {{ $user->height == ($ft . 'ft ' . $in . 'in') ? 'selected' : '' }}>
										{{ $heightString }}
									</option>
								@endfor
							@endfor
                        </select>
                        @if($errors->has('height'))
                            <div class="error text-danger">@lang($errors->first('height')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="weight">@lang('Weight (In Kg)')</label> <span class="text-danger">*</span>
                        <input
                            type="number"
                            class="form-control"
                            step=".1"
                            name="weight"
                            value="{{old('weight') ?? $user->weight }}"
                            placeholder="@lang('Enter Weight (In Kg)')"
                        />
                        @if($errors->has('weight'))
                            <div class="error text-danger">@lang($errors->first('weight')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="eyeColor">@lang('Eye Color')</label>
                        <select
                            class="form-select"
                            name="eyeColor"
                            aria-label="eyeColor"
                        >
                            <option value="" selected disabled>@lang('Select Eye Color')</option>
                            <option value="Brown" {{$user->eyeColor == 'Brown' ? 'selected' : ''}}>@lang('Brown')</option>
                            <option value="Hazel" {{$user->eyeColor == 'Hazel' ? 'selected' : ''}}>@lang('Hazel')</option>
                            <option value="Blue" {{$user->eyeColor == 'Blue' ? 'selected' : ''}}>@lang('Blue')</option>
                            <option value="Green" {{$user->eyeColor == 'Green' ? 'selected' : ''}}>@lang('Green')</option>
                            <option value="Gray" {{$user->eyeColor == 'Gray' ? 'selected' : ''}}>@lang('Gray')</option>
                            <option value="Amber" {{$user->eyeColor == 'Amber' ? 'selected' : ''}}>@lang('Amber')</option>
                        </select>
                        @if($errors->has('eyeColor'))
                            <div class="error text-danger">@lang($errors->first('eyeColor')) </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="hairColor">@lang('Hair Color')</label> <span class="text-danger">*</span>
                        <select
                            name="hairColor"
                            class="form-select"
                            aria-label="hair Color"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($hairColor as $data)
                                <option value="{{$data->hair_color_id}}" {{($user->hairColor == $data->hair_color_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('hairColor')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group" >
                        <label for="complexion">@lang('Complexion')</label> <span class="text-danger">*</span>
                        <select
                            name="complexion"
                            class="form-select"
                            aria-label="complexion"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($complexion as $data)
                                <option value="{{$data->complexion_id}}" {{($user->complexion == $data->complexion_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('complexion')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="bloodGroup">@lang('Blood Group')</label>
                        <select
                            class="form-select"
                            name="bloodGroup"
                            aria-label="bloodGroup"
                        >
                            <option value="" selected disabled>@lang('Select One')</option>
                            @foreach(config('bloodgroup') as $key => $item)
                                <option value="{{$key}}" @if($key == old('bloodGroup',$user->bloodGroup )) selected @endif>{{$item}}</option>
                            @endforeach
                        </select>
                        @error('bloodGroup')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>


                    <div class="col-md-6 form-group" >
                        <label for="body_type">@lang('Body Type')</label> <span class="text-danger">*</span>
                        <select
                            name="body_type"
                            class="form-select"
                            aria-label="body_type"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($bodyType as $data)
                                <option value="{{$data->body_types_id}}" {{($user->body_type == $data->body_types_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('body_type')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group" style="display:none;">
                        <label for="body_art">@lang('Body Art')</label> <span class="text-danger">*</span>
                        <select
                            name="body_art"
                            class="form-select"
                            aria-label="body_art"
                        >
                            <option value="" disabled>@lang('Select One')</option>
                            @foreach($bodyArt as $data)
                                <option value="{{$data->body_art_id}}" {{($user->body_art == $data->body_art_id) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                        </select>
                        @error('body_art')
                        <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    
                    <div class="col-md-6 form-group">
                        <label for="disability">@lang('Disability')</label> <span class="text-danger">*</span>
						<select
                            name="disability"
                            class="form-select"
                            aria-label="body_art"
                        >
						<option value="" disabled>@lang('Select One')</option>
						<option value="Nothing" {{( $user->disability == "Nothing") ? 'selected' : ''}} >@lang('Nothing')</option>
						<option value="Visual Impairment" {{( $user->disability == "Visual Impairment") ? 'selected' : ''}} >@lang('Visual Impairment')</option>
						<option value="Deaf-Blindness" {{( $user->disability == "Deaf-Blindness") ? 'selected' : ''}} >@lang('Deaf-Blindness')</option>
						<option value="Hearing Impairment" {{( $user->disability == "Hearing Impairment") ? 'selected' : ''}} >@lang('Hearing Impairment')</option>
						<option value="Speech and Language Disability" {{($user->disability == "Speech and Language Disability") ? 'selected' : ''}} >@lang('Speech and Language Disability')</option>
						<option value="Locomotor Disability" {{( $user->disability == "Locomotor Disability") ? 'selected' : ''}} >@lang('Locomotor Disability')</option>
						<option value="Leprosy-Cured Persons" {{( $user->disability == "Leprosy-Cured Persons") ? 'selected' : ''}} >@lang('Leprosy-Cured Persons')</option>
						<option value="Cerebral Palsy" {{( $user->disability == "Cerebral Palsy") ? 'selected' : ''}} >@lang('Cerebral Palsy')</option>
						<option value="Dwarfism" {{( $user->disability == "Dwarfism") ? 'selected' : ''}} >@lang('Dwarfism')</option>
						<option value="Muscular Dystrophy" {{( $user->disability == "Muscular Dystrophy") ? 'selected' : ''}} >@lang('Muscular Dystrophy')</option>
						<option value="Acid Attack Victims" {{( $user->disability == "Acid Attack Victims") ? 'selected' : ''}} >@lang('Acid Attack Victims')</option>
						<option value="Specific Learning Disabilities" {{( $user->disability == "Specific Learning Disabilities") ? 'selected' : ''}} >@lang('Specific Learning Disabilities')</option>
						<option value="Intellectual Disability" {{( $user->disability == "Intellectual Disability") ? 'selected' : ''}} >@lang('Intellectual Disability')</option>
						<option value="Autism Spectrum Disorder" {{( $user->disability == "Autism Spectrum Disorder") ? 'selected' : ''}} >@lang('Autism Spectrum Disorder')</option>
						<option value="Mental Illness" {{( $user->disability == "Mental Illness") ? 'selected' : ''}} >@lang('Mental Illness')</option>
						<option value="Multiple Sclerosis" {{( $user->disability == "Multiple Sclerosis") ? 'selected' : ''}} >@lang('Multiple Sclerosis')</option>
						<option value="Parkinson’s Disease" {{( $user->disability == "Parkinson’s Disease") ? 'selected' : ''}} >@lang('Parkinson’s Disease')</option>
						<option value="Hemophilia" {{( $user->disability == "Hemophilia") ? 'selected' : ''}} >@lang('Hemophilia')</option>
						<option value="Thalassemia" {{( $user->disability == "Thalassemia") ? 'selected' : ''}} >@lang('Thalassemia')</option>
						<option value="Sickle Cell Disease" {{( $user->disability == "Sickle Cell Disease") ? 'selected' : ''}} >@lang('Sickle Cell Disease')</option>
						<option value="Multiple Disabilities" {{( $user->disability == "Multiple Disabilities") ? 'selected' : ''}} >@lang('Multiple Disabilities')</option>
						<option value="Chronic Kidney Disease" {{( $user->disability == "Chronic Kidney Disease") ? 'selected' : ''}} >@lang('Chronic Kidney Disease')</option>
						
						</select>
                       
                        @if($errors->has('disability'))
                            <div class="error text-danger">@lang($errors->first('disability')) </div>
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

