<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Gallery;
use App\Models\Ignore;
use App\Models\MaritalStatusDetails;
use App\Models\ProfileView;
use App\Models\PurchasedPlanItem;
use App\Models\Religion;
use App\Models\Shortlist;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileViewController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }


    // member view page
    public function memberProfileShow(Request $request, $member_id)
    {
        $user_id = Auth::id();


        $countProfileView = ProfileView::where([
            'user_id' => $user_id,
            'member_id' => $member_id
        ])->count();



        $profileViewExist = PurchasedPlanItem::select('contact_view_info')->where('user_id', $user_id)->first();


        if ($member_id == $user_id) {
            $data['userProfile'] = User::with(['getReligion', 'getCaste', 'getSubCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'getPermanentCountry', 'getPermanentState', 'getPermanentCity', 'maritalStatus', 'educationInfo', 'careerInfo', 'getBirthCountry', 'getResidencyCountry', 'getGrowupCountry', 'getFamilyValue', 'partnerResidenceCountry', 'partnerMaritalStatus', 'partnerReligion', 'partnerCaste', 'partnerSubCaste', 'partnerPreferredCountry', 'partnerPreferredState', 'partnerPreferredtCity', 'shortlist', 'purchasedPlanItems', 'bodyType', 'bodyArt', 'userHairColor','userComplexion', 'userEthnicity', 'personalValue', 'communityValue', 'politicalView', 'religiousService'])->findOrFail($member_id);

            $data['galleryList'] = Gallery::where('user_id', $member_id)->latest()->get();

            $data['title'] = $data['userProfile']->username . "'s" . " " . "Profile";

            return view($this->theme . 'user.member.member-profile', $data);
        } elseif (isset($profileViewExist) && $profileViewExist->contact_view_info > 0 && $countProfileView == 0) {

            $profileViewList = new ProfileView();
            $profileViewList->member_id = $member_id;
            $profileViewList->user_id = $user_id;
            $profileViewList->save();

            $data['userProfile'] = User::with(['getReligion', 'getCaste', 'getSubCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'getPermanentCountry', 'getPermanentState', 'getPermanentCity', 'maritalStatus', 'educationInfo', 'careerInfo', 'getBirthCountry', 'getResidencyCountry', 'getGrowupCountry', 'getFamilyValue', 'partnerResidenceCountry', 'partnerMaritalStatus', 'partnerReligion', 'partnerCaste', 'partnerSubCaste', 'partnerPreferredCountry', 'partnerPreferredState', 'partnerPreferredtCity', 'shortlist', 'purchasedPlanItems', 'bodyType', 'bodyArt', 'userHairColor','userComplexion', 'userEthnicity', 'personalValue', 'communityValue', 'politicalView', 'religiousService'])->findOrFail($member_id);

            $data['galleryList'] = Gallery::where('user_id', $member_id)->latest()->get();

            $data['title'] = $data['userProfile']->username . "'s" . " " . "Profile";

             PurchasedPlanItem::where('user_id', $user_id)->decrement('contact_view_info');

            return view($this->theme . 'user.member.member-profile', $data);
        } elseif (isset($profileViewExist) && $profileViewExist->contact_view_info >= 0 && $countProfileView != 0) {
            $data['userProfile'] = User::with(['getReligion', 'getCaste', 'getSubCaste', 'getPresentCountry', 'getPresentState', 'getPresentCity', 'getPermanentCountry', 'getPermanentState', 'getPermanentCity', 'maritalStatus', 'educationInfo', 'careerInfo', 'getBirthCountry', 'getResidencyCountry', 'getGrowupCountry', 'getFamilyValue', 'partnerResidenceCountry', 'partnerMaritalStatus', 'partnerReligion', 'partnerCaste', 'partnerSubCaste', 'partnerPreferredCountry', 'partnerPreferredState', 'partnerPreferredtCity', 'shortlist', 'purchasedPlanItems', 'bodyType', 'bodyArt', 'userHairColor','userComplexion', 'userEthnicity', 'personalValue', 'communityValue', 'politicalView', 'religiousService'])->findOrFail($member_id);

            $data['galleryList'] = Gallery::where('user_id', $member_id)->latest()->get();
            $data['title'] = $data['userProfile']->username . "'s" . " " . "Profile";
            return view($this->theme . 'user.member.member-profile', $data);
        } else {
            return redirect()->route('plan')->with('error', 'Please update your package');
        }

    }



    // profile matched
    public function matchedProfile()
    {
        $matchedProfileExist = PurchasedPlanItem::select('show_auto_profile_match')->where('user_id', Auth::id())->first();

        if (isset($matchedProfileExist) && $matchedProfileExist->show_auto_profile_match > 0) {
            $user = Auth::user();
			//print_r($user);

            $ignoreList = collect([]);

            Ignore::toBase()->where('user_id', $user->id)->select('member_id')->get()->map(function ($item) use ($ignoreList) {
                $ignoreList->push($item->member_id);
            });

            // First try: Strict matching with all criteria
            $matchedProfiles = User::with(['profileInfo', 'careerInfo', 'purchasedPlanItems', 'getReligion', 'getCaste', 'getPresentCountry', 'maritalStatus'])
                ->whereHas('profileInfo', function ($query) {
                    return $query->where('status', 1);
                })
                ->whereNotIn('id', $ignoreList)
                ->where('id', '!=', $user->id);

            // Always show opposite gender profiles based on logged-in user's gender
            // Male user sees female profiles, Female user sees male profiles
            if (isset($user->gender)) {
                $oppositeGender = (strtolower($user->gender) === 'male') ? 'female' : 'male';
                $matchedProfiles->where('gender', $oppositeGender);
            }

            // Apply physical preferences with more flexibility
            if (isset($user->partner_min_height)) {
                // Be more lenient with height - subtract 2 inches from minimum to allow more matches
                $minHeight = $user->partner_min_height;
                // If min height is very restrictive (< 5ft), make it slightly more flexible
                if (strpos($minHeight, '4ft') === 0) {
                    // Convert 4ft 5in to 4ft 3in for more matches
                    $minHeight = '4ft 3in';
                }
                $matchedProfiles->where('height', '>=', $minHeight);
            }
            if (isset($user->partner_max_height)) {
                $matchedProfiles->where('height', '<=', $user->partner_max_height);
            }

            // Apply age range restriction: show profiles within 5 years of logged-in user's age
            if (isset($user->age) && is_numeric($user->age)) {
                $minAge = $user->age;
                $maxAge = $user->age + 5;
                $matchedProfiles->whereBetween('age', [$minAge, $maxAge]);
            }

            // Count optional criteria that are set
            $optionalCriteriaCount = 0;
            $appliedCriteria = [];

            if (isset($user->partner_religion) && !empty($user->partner_religion)) {
                $matchedProfiles->where('religion', $user->partner_religion);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'religion';
            }

            if (isset($user->partner_caste) && !empty($user->partner_caste)) {
                $matchedProfiles->where('caste', $user->partner_caste);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'caste';
            }

            if (isset($user->partner_education) && !empty($user->partner_education)) {
                $matchedProfiles->where('education_level', $user->partner_education);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'education';
            }

            if (isset($user->partner_preferred_country) && !empty($user->partner_preferred_country)) {
                $matchedProfiles->where('permanent_country', $user->partner_preferred_country);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'country';
            }

            if (isset($user->partner_preferred_state) && !empty($user->partner_preferred_state)) {
                $matchedProfiles->where('permanent_state', $user->partner_preferred_state);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'state';
            }

            if (isset($user->partner_preferred_city) && !empty($user->partner_preferred_city)) {
                $matchedProfiles->where('permanent_city', $user->partner_preferred_city);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'city';
            }

            if (isset($user->partner_marital_status) && !empty($user->partner_marital_status)) {
                $matchedProfiles->where('marital_status', $user->partner_marital_status);
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'marital_status';
            }

            if (isset($user->partner_profession) && !empty($user->partner_profession)) {
                $matchedProfiles->whereHas('careerInfo', function ($q) use ($user) {
                    $q->where('designation', 'LIKE', "%" . $user->partner_profession . "%");
                });
                $optionalCriteriaCount++;
                $appliedCriteria[] = 'profession';
            }

            $matchedProfiles = $matchedProfiles->get();

            // If no matches found, show opposite gender profiles (ignore all other preferences)
            if ($matchedProfiles->isEmpty()) {
                $fallbackQuery = User::with(['profileInfo', 'careerInfo', 'purchasedPlanItems', 'getReligion', 'getCaste', 'getPresentCountry', 'maritalStatus'])
                    ->whereHas('profileInfo', function ($query) {
                        return $query->where('status', 1);
                    })
                    ->whereNotIn('id', $ignoreList)
                    ->where('id', '!=', $user->id);

                // Only filter by opposite gender and age range - ignore all other preferences
                if (isset($user->gender)) {
                    $oppositeGender = (strtolower($user->gender) === 'male') ? 'female' : 'male';
                    $fallbackQuery->where('gender', $oppositeGender);
                }

                // Apply age range restriction even in fallback: show profiles within 5 years of logged-in user's age
                if (isset($user->age) && is_numeric($user->age)) {
                    $minAge = $user->age;
                    $maxAge = $user->age + 5;
                    $fallbackQuery->whereBetween('age', [$minAge, $maxAge]);
                }

                $matchedProfiles = $fallbackQuery->limit(12)->get();
            }

            $partnerGenders = json_decode($user->partner_gender);
            $allUser = $matchedProfiles;
			/*print_r($matchedProfiles);
            foreach ($matchedProfiles as $profile) {
                $profilePartnerGenders = json_decode($profile->partner_gender);
				//echo 'profilePartnerGenders='.$profilePartnerGenders;
				if($profilePartnerGenders && $partnerGenders){
					if ($user->gender == $profile->gender && in_array($user->gender, $partnerGenders) && in_array($profile->gender, $profilePartnerGenders)) {
}
					} elseif($user->gender != $profile->gender && in_array($profile->gender, $partnerGenders)){
						$allUser[] = $profile;
					}
				}
            } */

            $allUser = paginate($allUser, $perPage = 4, $page = null, $options = ["path" => route('user.matched.profile')]);
            return view($this->theme . 'user.matched_profile.matched_profile', compact('allUser'));
        } else {
            return redirect()->route('plan')->with('error', 'Please update your package');
        }

    }


}
