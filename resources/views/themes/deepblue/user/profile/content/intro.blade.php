
<!--------------Introduction----------------->
<div class="accordion-item">
    <h5 class="accordion-header" id="introduction">
        <button
            class="accordion-button"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#collapseIntroduction"
            aria-expanded="true"
            aria-controls="collapseIntroduction"
        >
            <i class="fas fa-user-tag"></i>
            @lang('Introduction')
        </button>
    </h5>

    <div
        id="collapseIntroduction"
        class="accordion-collapse collapse @if($errors->has('intro') || 0 == count($errors)) show @endif"
        aria-labelledby="introduction"
        data-bs-parent="#accordionExample"
    >
        <div class="accordion-body">
            <form method="post" action="{{ route('user.update.introduction') }}">
                @csrf

                

                <div class="row g-3 g-md-4">
                    <div class="col-md-12 form-group">
                        <label for="introduction">@lang('Introduction')</label> <span class="text-danger">*</span>
                        <br>
                        <select id="intro_template" class="form-control" name="intro_template" aria-label="intro_template" data-container="body">  
                            <option value="" disabled selected>@lang('Select template')</option>
                            @foreach($communityValue as $data)
                                <option value="{{$data->template}}" {{($user->community_value == $data->community_template) ? 'selected' : ''}}>@lang($data->name)</option>
                            @endforeach
                            
                        </select>
                        <textarea name="introduction1" value="Template 1" id="introduction1" cols="30" rows="10" class="form-control" placeholder="@lang('Enter Introduction')">{{ old('introduction') ?? $user->introduction }}</textarea>
                        @error('introduction')
                            <span class="text-danger">@lang($message)</span>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button class="btn-flower2 btn-full">@lang('update')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@push('script')
<script>
    $(document).ready(function () {
        // Define the templates
        var templates = {
            1: "Hello! I’m [Your Name], a [Your Profession] based in [Your City]. I have a degree in [Your Degree] from [Your University]. In my free time, I enjoy [list your hobbies, e.g., reading, traveling, cooking]. Friends describe me as [three positive adjectives, e.g., kind-hearted, ambitious, and cheerful]. I’m looking for a partner who shares my values and interests, someone who is kind, understanding, and has a positive outlook on life. Family is very important to me, and I cherish the time spent with loved ones. I hope to build a family based on love, trust, and mutual respect. If you think we might be a good match, I’d love to hear from you. Let’s connect and see where this journey takes us! Best regards, [Your Name]",
            2: "Hi there! I’m [Your Name], a [Your Profession] from [Your City]. With a degree in [Your Degree], I enjoy spending my free time [mention hobbies, e.g., hiking, reading, and cooking]. I’m known for being [positive adjectives, e.g., warm, driven, and humorous]. I’m looking for a partner who is kind, supportive, and shares similar values. If you think we could be a great match, I’d love to connect! Best, [Your Name]",
            3: "Hello! I’m [Your Name], a [Your Profession] living in [Your City]. I have a degree in [Your Degree] and enjoy [list a couple of hobbies, e.g., traveling and cooking]. Friends describe me as [positive adjectives, e.g., caring, ambitious, and fun-loving]. I’m seeking a kind and understanding partner who values family and enjoys exploring new experiences. If you think we could be a good match, let’s connect and get to know each other better! Best, [Your Name]"
        };

        // Check when dropdown value changes
        $('#intro_template').on('change', function () {
            var templateValue = $(this).val();
           // alert(templateValue);
            //var introText = templates[templateValue] || '';
            //alert(introText);   
            // Set the template text in the textarea
            $('#introduction1').val(templateValue);
        });
    });
</script>
@endpush