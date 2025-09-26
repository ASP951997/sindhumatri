<?php

namespace App\Http\Controllers\User;

use App\Models\ProfileInfo;
use Illuminate\Http\Request;
use App\Models\EducationInfo;
use App\Http\Controllers\Controller;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;

class EducationInfoController extends Controller
{
    public function educationInfoCreate(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
		
            'area' => 'required',
            'degree' => 'required'
        ];
        $message = [
            'area.required' => 'Area field is required',
            'degree.required' => 'Degree field is required',
            'institution.required' => 'Institution field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('educationInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = new EducationInfo();
        $data->user_id = auth()->user()->id;
		$data->area = $req['area'];
        $data->degree = $req['degree'];
        $data->institution = $req['institution'];
		//echo $req['start']; exit;
        //if('01 Jan, 1970' == $req['start'])
		//	$req['start'] = "-";
        $data->start =  "-";
		//if('01 Jan, 1970' == $req['end'])
		//	$req['end'] = "-";
        $data->end =  "-";

        $data->save();

        $education_info = ProfileInfo::firstOrNew([
            'user_id' => auth()->user()->id,
        ]);
        $education_info->education_info = 1;
        $education_info->save();

        session()->put('name','educationInfo');

        return back()->with('success', 'Education Info Added Successfully.');
    }


    public function educationInfoUpdate(Request $request, $id)
    {
        $req = Purify::clean($request->except('_token', '_method'));

        $rules = [
            'area' => 'required',
            'degree' => 'required'
        ];
        $message = [
            'area.required' => 'Area field is required',
            'degree.required' => 'Degree field is required',
            'institution.required' => 'Institution field is required',
        ];

        $validator = Validator::make($req, $rules, $message);

        if ($validator->fails()) {
            $newArr =  $validator->getMessageBag();
            $newArr->add('educationInfo', 'error');
            return back()->withErrors($validator)->withInput();
        }

        $data = EducationInfo::findOrFail($id);
        $data->user_id = auth()->user()->id;
		$data->area = $req['area'];
        $data->degree = $req['degree'];
        $data->institution = $req['institution'];
		// && '01 Jan, 1970' === $req['start']
		if(!isset($req['start']) )
			$req['start'] = "-";
        $data->start = $req['start'];
		// && '01 Jan, 1970' === $req['end']
		if(!isset($req['end']))
			$req['end'] = "-";
        $data->end = $req['end'];

        $data->save();

        session()->put('name','educationInfo');

        return back()->with('success', 'Education Info Updated Successfully.');
    }


    public function educationInfoDelete($id)
    {
        $data = EducationInfo::findOrFail($id);
        $data->delete();
        return back()->with('success', 'Education Info has been deleted');
    }

}
