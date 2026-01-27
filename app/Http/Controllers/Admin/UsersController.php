<?php

namespace App\Http\Controllers\Admin;

use App\Models\KYC;
use App\Models\User;
use App\Models\Story;
use App\Models\Report;
use App\Models\Language;
use App\Http\Traits\Notify;
use App\Http\Traits\Upload;
use App\Models\ProfileInfo;
use Illuminate\Http\Request;
use App\Rules\FileTypeValidate;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Facades\App\Services\BasicService;
use Stevebauman\Purify\Facades\Purify;
use Illuminate\Support\Facades\Validator;
use App\Services\WhatsAppService;
use App\Models\WhatsAppMessage;


class UsersController extends Controller
{
    use Upload, Notify;

    public function index()
    {
        $users = User::with('profileInfo')->orderBy('id', 'DESC')->paginate(config('basic.paginate'));
        return view('admin.users.list', compact('users'));
    }

    public function search(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date_time;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);
        $users = User::when(isset($search['search']), function ($query) use ($search) {
            $searchTerm = $search['search'];
            return $query->where(function($q) use ($searchTerm) {
                $q->where('email', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('username', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('firstname', 'LIKE', "%{$searchTerm}%")
                  ->orWhere('lastname', 'LIKE', "%{$searchTerm}%")
                  ->orWhereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$searchTerm}%"]);
            });
        })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->paginate(config('basic.paginate'));
        return view('admin.users.list', compact('users', 'search'));
    }


    public function profileApprove($id)
    {
        $Approve = ProfileInfo::where('user_id', $id)->update(['status' => 1]);
        $user = User::findOrFail($id);

        $this->sendMailSms($user, 'USER_PROFILE_APPROVED', [

        ]);

        $msg = [

        ];
        $action = [
            "link" => route('user.profile'),
            "icon" => "fas fa-money-bill-alt text-white"
        ];

        $this->userPushNotification($user, 'USER_PROFILE_APPROVED', $msg, $action);

        return back()->with('success', 'Profile Approved Successfully.');
    }


    public function profilePending($id)
    {
        $pending = ProfileInfo::where('user_id', $id)->update(['status' => 0]);
        $user = User::findOrFail($id);

        $this->sendMailSms($user, 'USER_PROFILE_MAKE_PENDING', [

        ]);

        $msg = [

        ];
        $action = [
            "link" => route('user.profile'),
            "icon" => "fas fa-money-bill-alt text-white"
        ];

        $this->userPushNotification($user, 'USER_PROFILE_MAKE_PENDING', $msg, $action);

        return back()->with('success', 'Profile Marked As Pending Successfully.');
    }


    public function activeMultiple(Request $request)
    {
        if ($request->strIds == null) {
            session()->flash('error', 'You do not select User.');
            return response()->json(['error' => 1]);
        } else {
            User::whereIn('id', $request->strIds)->update([
                'status' => 1,
            ]);
            session()->flash('success', 'User Status Has Been Active');
            return response()->json(['success' => 1]);
        }
    }

    public function inactiveMultiple(Request $request)
    {

        if ($request->strIds == null) {
            session()->flash('error', 'You do not select User.');
            return response()->json(['error' => 1]);
        } else {
            User::whereIn('id', $request->strIds)->update([
                'status' => 0,
            ]);

            session()->flash('success', 'User Status Has Been Deactive');
            return response()->json(['success' => 1]);

        }
    }


    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        $languages = Language::all();
        return view('admin.users.edit-user', compact('user', 'languages'));
    }


    public function userUpdate(Request $request, $id)
    {
        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });
        $userData = Purify::clean($request->except('_token', '_method'));
        $user = User::findOrFail($id);
        $rules = [
            'firstname' => ['sometimes', 'required', 'regex:/^[A-Z][a-z]*$/'],
            'lastname' => ['sometimes', 'required', 'regex:/^[A-Z][a-z]*$/'],
            'username' => 'sometimes|required|unique:users,username,' . $user->id,
            'email' => 'sometimes|required|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|required|digits:10',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpeg', 'jpg', 'png'])],
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'firstname.required' => 'First Name is required',
            'firstname.regex' => 'First Name must start with a capital letter and contain only alphabets (no numbers, spaces, or special characters)',
            'lastname.required' => 'Last Name is required',
            'lastname.regex' => 'Last Name must start with a capital letter and contain only alphabets (no numbers, spaces, or special characters)',
            'phone.digits' => 'Phone number must be exactly 10 digits',
        ];

        $Validator = Validator::make($userData, $rules, $message);

        if ($Validator->fails()) {
            return back()->withErrors($Validator)->withInput();
        }

        if ($request->hasFile('image')) {
            try {
                $old = $user->image ?: null;
                $user->image = $this->uploadImage($request->image, config('location.user.path'), config('location.user.size'), $old);
            } catch (\Exception $exp) {
                return back()->with('error', 'Image could not be uploaded.');
            }
        }
        $user->firstname = ucfirst(strtolower(trim(preg_replace('/[^a-zA-Z]/', '', $userData['firstname']))));
        $user->lastname = ucfirst(strtolower(trim(preg_replace('/[^a-zA-Z]/', '', $userData['lastname']))));
        $user->username = $userData['username'];
        $user->email = $userData['email'];
        $user->phone = $userData['phone'];
        $user->language_id = $userData['language_id'];
        $user->address = $userData['address'];
        $user->status = ($userData['status'] == 'on') ? 0 : 1;
        $user->email_verification = ($userData['email_verification'] == 'on') ? 0 : 1;
        $user->sms_verification = ($userData['sms_verification'] == 'on') ? 0 : 1;
        $user->two_fa_verify = ($userData['two_fa_verify'] == 'on') ? 1 : 0;
        $user->save();

        return back()->with('success', 'Updated Successfully.');
    }


    public function passwordUpdate(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:5|same:password_confirmation',
        ]);
        $user = User::findOrFail($id);
        $user->password = bcrypt($request->password);
        $user->save();

        // Send email notification with error handling
        try {
            $this->sendMailSms($user, 'PASSWORD_CHANGED', [
                'password' => $request->password
            ]);
        } catch (\Exception $e) {
            // Log the error but don't break the password update
            \Log::error('Password change email failed: ' . $e->getMessage());
            // Continue with success message
        }

        return back()->with('success', 'Password Updated Successfully.');
    }


    public function userBalanceUpdate(Request $request, $id)
    {
        $userData = Purify::clean($request->all());
        if ($userData['balance'] == null) {
            return back()->with('error', 'Balance Value Empty!');
        } else {
            $control = (object)config('basic');
            $user = User::findOrFail($id);

            $trx = strRandom();

            if ($userData['add_status'] == "1") {
                $user->balance += $userData['balance'];
                $user->save();

                BasicService::makeTransaction($user, getAmount($userData['balance']), 0, '+', $trx, 'Add Balance');

                $msg = [
                    'amount' => getAmount($userData['balance']),
                    'currency' => $control->currency,
                    'main_balance' => $user->balance,
                    'transaction' => $trx
                ];
                $action = [
                    "link" => '#',
                    "icon" => "fa fa-money-bill-alt text-white"
                ];

                $this->userPushNotification($user, 'ADD_BALANCE', $msg, $action);


                $this->sendMailSms($user, 'ADD_BALANCE', [
                    'amount' => getAmount($userData['balance']),
                    'currency' => $control->currency,
                    'main_balance' => $user->balance,
                    'transaction' => $trx
                ]);
                return back()->with('success', 'Balance Add Successfully.');

            } else {

                if ($userData['balance'] > $user->balance) {
                    return back()->with('error', 'Insufficient Balance to deducted.');
                }
                $user->balance -= $userData['balance'];
                $user->save();


                BasicService::makeTransaction($user, getAmount($userData['balance']), 0, '-', $trx, $remarks = 'DEDUCTED BALANCE');

                $msg = [
                    'amount' => getAmount($userData['balance']),
                    'currency' => $control->currency,
                    'main_balance' => $user->balance,
                    'transaction' => $trx
                ];
                $action = [
                    "link" => '#',
                    "icon" => "fa fa-money-bill-alt text-white"
                ];

                $this->userPushNotification($user, 'DEDUCTED_BALANCE', $msg, $action);

                $this->sendMailSms($user, 'DEDUCTED_BALANCE', [
                    'amount' => getAmount($userData['balance']),
                    'currency' => $control->currency,
                    'main_balance' => $user->balance,
                    'transaction' => $trx,
                ]);
                return back()->with('success', 'Balance deducted Successfully.');
            }
        }
    }

    /**
     * Simulate WhatsApp message sending for testing purposes
     */
    private function simulateWhatsAppMessage($phone, $message, $userName = null)
    {
        try {
            // Get simulation configuration
            $successRate = config('whatsapp.simulation_mode.success_rate', 100);
            $delaySeconds = config('whatsapp.simulation_mode.delay_seconds', 1);
            $logSimulated = config('whatsapp.simulation_mode.log_simulated', true);
            
            // Simulate API delay
            if ($delaySeconds > 0) {
                sleep($delaySeconds);
            }
            
            // Simulate success/failure based on success rate
            $isSuccess = (rand(1, 100) <= $successRate);
            
            // Format phone number for logging
            $formattedPhone = $this->formatPhoneNumber($phone);
            
            // Log the simulation
            if ($logSimulated) {
                \Log::info('WhatsApp Message Simulation', [
                    'phone' => $formattedPhone,
                    'user_name' => $userName,
                    'message' => $message,
                    'success' => $isSuccess,
                    'simulation_mode' => true,
                    'uid' => config('whatsapp.uid'),
                    'device_name' => config('whatsapp.device_name'),
                    'timestamp' => now()->toDateTimeString()
                ]);
            }
            
            if ($isSuccess) {
                // Simulate successful API response
                $simulatedResponse = [
                    'status' => 'success',
                    'message_id' => 'sim_' . uniqid(),
                    'phone' => $formattedPhone,
                    'message' => 'Message sent successfully (SIMULATED)',
                    'timestamp' => now()->toISOString()
                ];
                
                \Log::info('WhatsApp Message Simulation Success', $simulatedResponse);
                return true;
            } else {
                // Simulate failed API response
                $simulatedError = [
                    'status' => 'error',
                    'error_code' => 'SIMULATION_FAILURE',
                    'error_message' => 'Simulated API failure for testing',
                    'phone' => $formattedPhone,
                    'timestamp' => now()->toISOString()
                ];
                
                \Log::warning('WhatsApp Message Simulation Failure', $simulatedError);
                return false;
            }
            
        } catch (\Exception $e) {
            \Log::error('WhatsApp simulation exception: ' . $e->getMessage());
            return false;
        }
    }

    public function emailToUsers()
    {
        return view('admin.users.mail-form');
    }

    public function whatsappToSelectedUsers()
    {
        $users = User::where('status', 1)
            ->select('id', 'firstname', 'lastname', 'email', 'phone')
            ->orderBy('firstname')
            ->get();
        
        return view('admin.users.whatsapp-form', compact('users'));
    }

    public function whatsappMessageHistory()
    {
        $messages = WhatsAppMessage::with('user')
            ->orderBy('created_at', 'DESC')
            ->paginate(config('basic.paginate', 20));
        
        return view('admin.users.whatsapp-history', compact('messages'));
    }


    public function sendEmailToUsers(Request $request)
    {
        $req = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'subject' => 'sometimes|required',
            'message' => 'sometimes|required'
        ];
        $validator = Validator::make($req, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $allUsers = User::where('status', 1)->get();
        foreach ($allUsers as $user) {
            $this->mail($user, null, [], $req['subject'], $req['message']);
        }

        return back()->with('success', 'Mail Send Successfully');
    }

    public function sendWhatsAppToSelectedUsers(Request $request)
    {
        // Log incoming request for debugging
        \Log::info('WhatsApp Send Request', [
            'has_message' => $request->has('message'),
            'message_length' => $request->has('message') ? strlen($request->input('message')) : 0,
            'has_selected_users' => $request->has('selected_users'),
            'selected_users_count' => $request->has('selected_users') ? (is_array($request->input('selected_users')) ? count($request->input('selected_users')) : 'not_array') : 0,
            'selected_users' => $request->input('selected_users'),
            'has_attachment' => $request->hasFile('attachment'),
            'all_input' => $request->except(['_token', 'attachment'])
        ]);
        
        // Validate first before cleaning
        $rules = [
            'message' => 'required',
            'selected_users' => 'required|array|min:1',
            'attachment' => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240' // 10MB max
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            \Log::warning('WhatsApp Send Validation Failed', [
                'errors' => $validator->errors()->toArray(),
                'request_data' => $request->except(['_token', 'attachment'])
            ]);
            
            if ($request->ajax()) {
                // Build a detailed error message
                $errorMessages = [];
                foreach ($validator->errors()->all() as $error) {
                    $errorMessages[] = $error;
                }
                $errorMessage = implode(' ', $errorMessages);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed: ' . $errorMessage,
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        // Clean the message but keep selected_users as is
        $message = Purify::clean($request->input('message'));
        $selectedUserIds = $request->input('selected_users');

        // Handle file upload if present (store the actual file path for direct upload)
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Store in public storage
            $storagePath = $file->storeAs('whatsapp/attachments', $fileName, 'public');
            // Get the full file system path for direct upload to WhatsApp API
            $attachmentPath = storage_path('app/public/' . $storagePath);
            
            // Defensive check: ensure file was stored and is readable by PHP process
            if (!file_exists($attachmentPath) || !is_readable($attachmentPath)) {
                \Log::error('WhatsApp attachment not stored or not readable after upload', [
                    'attachmentPath' => $attachmentPath,
                    'storagePath' => $storagePath,
                    'exists' => file_exists($attachmentPath),
                    'readable' => is_readable($attachmentPath)
                ]);

                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Attachment upload failed (file not available on server).'
                    ], 500);
                }

                return back()->with('error', 'Attachment upload failed (file not available on server).');
            }
        }

        // Get selected users
        $selectedUsers = User::whereIn('id', $selectedUserIds)
            ->where('status', 1)
            ->get();

        if ($selectedUsers->isEmpty()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid users selected to send WhatsApp messages.'
                ], 400);
            }
            return back()->with('error', 'No valid users selected to send WhatsApp messages.');
        }

        // Use the new WhatsApp service
        $whatsappService = new WhatsAppService();

        $successCount = 0;
        $failedCount = 0;
        $noPhoneCount = 0;

        // Get API credentials for logging
        $basicControl = \App\Models\Configure::first();
        $apiId = $basicControl->whatsapp_api_id ?? null;
        $deviceName = $basicControl->whatsapp_device_name ?? null;

        foreach ($selectedUsers as $user) {
            if ($user->phone) {
                // Use the new WhatsApp service with direct file upload support
                $result = $whatsappService->sendMessage(
                    $user->phone, 
                    $message, 
                    $user->firstname, 
                    $attachmentPath
                );
                
                // Save message to database
                $whatsappMessage = WhatsAppMessage::create([
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'recipient_name' => $user->firstname . ' ' . $user->lastname,
                    'message' => $message,
                    'status' => !empty($result['success']) ? 'sent' : 'failed',
                    'api_response' => isset($result['response']) ? (is_string($result['response']) ? substr($result['response'], 0, 500) : json_encode($result['response'])) : null,
                    'http_code' => $result['http_code'] ?? null,
                    'error_message' => $result['error'] ?? ($result['message'] ?? null),
                    'attachment_path' => $attachmentPath ? basename($attachmentPath) : null,
                    'api_id' => $apiId,
                    'device_name' => $deviceName,
                ]);
                
                // Collect detailed per-user result for debugging
                $details[] = [
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'success' => $result['success'] ?? false,
                    'message' => $result['message'] ?? null,
                    'http_code' => $result['http_code'] ?? null,
                    'response' => isset($result['response']) ? (is_string($result['response']) ? substr($result['response'], 0, 1000) : json_encode($result['response'])) : null,
                    'error' => $result['error'] ?? null
                ];

                if (!empty($result['success'])) {
                    $successCount++;
                } else {
                    $failedCount++;
                }
            } else {
                $noPhoneCount++;
            }
        }

        $totalUsers = $selectedUsers->count();
        $messageText = "WhatsApp messages processed. Success: {$successCount}/{$totalUsers}.";
        if ($attachmentPath) {
            $messageText .= " (with file attachment)";
        }
        if ($failedCount > 0) {
            $messageText .= " Failed to send to {$failedCount} users (API errors).";
        }
        if ($noPhoneCount > 0) {
            $messageText .= " {$noPhoneCount} users skipped (no phone number).";
        }

        // Decide overall result (fail if none delivered)
        $overallSuccess = $successCount > 0;

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->wantsJson()) {
            $payload = [
                'success' => $overallSuccess,
                'message' => $messageText,
                'stats' => [
                    'success' => $successCount,
                    'failed' => $failedCount,
                    'no_phone' => $noPhoneCount,
                    'total' => $totalUsers
                ],
                'details' => $details ?? []
            ];

            $statusCode = $overallSuccess ? 200 : 500;
            return response()->json($payload, $statusCode);
        }

        // Log details for non-AJAX requests for troubleshooting
        if (isset($details) && count($details) > 0) {
            \Log::info('WhatsApp batch send details', ['details' => $details]);
        }

        if ($overallSuccess) {
            return back()->with('success', $messageText);
        }

        return back()->with('error', $messageText);
    }


    public function sendEmail($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.single-mail-form', compact('user'));
    }


    public function sendMailUser(Request $request, $id)
    {
        $req = Purify::clean($request->except('_token', '_method'));
        $rules = [
            'subject' => 'sometimes|required',
            'message' => 'sometimes|required'
        ];
        $validator = Validator::make($req, $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $user = User::findOrFail($id);
        $this->mail($user, null, [], $req['subject'], $req['message']);

        return back()->with('success', 'Mail Send Successfully');
    }


    public function transaction($id)
    {
        $user = User::findOrFail($id);
        $userid = $user->id;
        $transaction = $user->transaction()->paginate(config('basic.paginate'));
        return view('admin.users.transactions', compact('user', 'userid', 'transaction'));
    }


    public function funds($id)
    {
        $user = User::findOrFail($id);
        $userid = $user->id;
        $funds = $user->funds()->paginate(config('basic.paginate'));
        return view('admin.users.fund-log', compact('user', 'userid', 'funds'));
    }


    public function commissionLog($id)
    {
        $user = User::findOrFail($id);
        $userid = $user->id;
        $transactions = $user->referralBonusLog()->latest()->with('user', 'bonusBy:id,firstname,lastname')->paginate(config('basic.paginate'));
        return view('admin.users.commissionLog', compact('user', 'userid', 'transactions'));
    }


    public function referralMember($id)
    {
        $user = User::findOrFail($id);
        $referrals = getLevelUser($user->id);
        return view('admin.users.referral', compact('user', 'referrals'));
    }


    public function loginAsUser(Request $request, $id)
    {
        Auth::guard('web')->loginUsingId($id);
        return redirect()->route('user.home');
    }


    public function kycPendingList()
    {
        $title = "Pending KYC";
        $logs = KYC::orderBy('id', 'DESC')->where('status', 0)->with(['user', 'admin'])->paginate(config('basic.paginate'));
        return view('admin.users.kycList', compact('logs', 'title'));
    }


    public function kycList()
    {
        $title = "KYC Log";
        $logs = KYC::orderBy('id', 'DESC')->where('status', '!=', 0)->paginate(config('basic.paginate'));
        return view('admin.users.kycList', compact('logs', 'title'));
    }


    public function userKycHistory(User $user)
    {
        $title = $user->username . " : KYC Log";
        $logs = KYC::orderBy('id', 'DESC')->where('user_id', $user->id)->paginate(config('basic.paginate'));
        return view('admin.users.kycList', compact('logs', 'title'));
    }


    public function kycAction(Request $request, $id)
    {

        $this->validate($request, [
            'id' => 'required',
            'status' => ['required', Rule::in(['1', '2'])],
        ]);
        $data = KYC::where('id', $request->id)->whereIn('status', [0])->with('user')->firstOrFail();
        $basic = (object)config('basic');

        if ($request->status == '1') {
            $data->status = 1;
            $data->admin_id = auth()->guard('admin')->id();
            $data->update();
            $user = $data->user;
            if ($data->kyc_type == 'address-verification') {
                $user->address_verify = 2;
            } else {
                $user->identity_verify = 2;
            }
            $user->save();

            $this->sendMailSms($user, 'KYC_APPROVED', [
                'kyc_type' => kebab2Title($data->kyc_type)
            ]);


            $msg = [
                'kyc_type' => kebab2Title($data->kyc_type)
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-file-alt text-white"
            ];
            $this->userPushNotification($user, 'KYC_APPROVED', $msg, $action);

            session()->flash('success', 'Approve Successfully');
            return back();

        } elseif ($request->status == '2') {
            $data->status = 2;
            $data->admin_id = auth()->guard('admin')->id();
            $data->update();

            $user = $data->user;
            if ($data->kyc_type == 'address-verification') {
                $user->address_verify = 3;
            } else {
                $user->identity_verify = 3;
            }
            $user->save();


            $this->sendMailSms($user, 'KYC_REJECTED', [
                'kyc_type' => kebab2Title($data->kyc_type)
            ]);
            $msg = [
                'kyc_type' => kebab2Title($data->kyc_type)
            ];
            $action = [
                "link" => '#',
                "icon" => "fas fa-file-alt text-white"
            ];
            $this->userPushNotification($user, 'KYC_REJECTED', $msg, $action);

            session()->flash('success', 'Reject Successfully');
            return back();
        }
    }


    // reported profiles
    public function reportList()
    {
        $report = Report::with('userReportedTo', 'userReportedBy')->latest()->paginate(config('basic.paginate'));
        return view('admin.report.report', compact('report'));
    }

    public function reportDelete($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report has been deleted successfully');
    }

    public function reportListSearch(Request $request)
    {
        $search = $request->all();
        $dateSearch = $request->date;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $report = Report::with('userReportedTo', 'userReportedBy')->orderBy('id', 'DESC')
            ->when(isset($search['user_name']), function ($query) use ($search) {
                return $query->whereHas('userReportedTo', function ($q) use ($search) {
                    $q->where('firstname', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('lastname', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['user_name']}%");
                     })
                    ->orWhereHas('userReportedBy', function ($qq) use ($search) {
                        $qq->where('firstname', 'LIKE', "%{$search['user_name']}%")
                            ->orWhere('lastname', 'LIKE', "%{$search['user_name']}%")
                            ->orWhere('username', 'LIKE', "%{$search['user_name']}%");
                    });
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));

        $report = $report->appends($search);

        return view('admin.report.report', compact('report'));
    }


    // Story
    public function storytList()
    {
        $storyList = Story::with('user:id,firstname,lastname,username,email,image')->latest()->get();
        return view('admin.story.story', compact('storyList'));
    }

    public function storyApprove($id)
    {
        $story = Story::findOrFail($id)->update(['status'=>1]);
        return redirect()->back()->with('success', 'Story Approved Successfully');
    }

    public function storyPending($id)
    {
        $story = Story::findOrFail($id)->update(['status'=>0]);
        return redirect()->back()->with('success', 'Story marked as pending successfully');
    }

    public function storyShow($id)
    {
        $story = Story::findOrFail($id);
        return view('admin.story.show_story', compact('story'));
    }

    public function storyDelete($id){

        $story = Story::findOrFail($id);

        $storyImageDelete = config('location.story.path').$story->image;
        if(File::exists($storyImageDelete)){
            File::delete($storyImageDelete);
        }

        $storyThumbImageDelete = config('location.story.path').'thumb_'.$story->image;
        if (File::exists($storyThumbImageDelete)) {
            File::delete($storyThumbImageDelete);
        }

        $old_galleries = $story->gallery;
        $location = config('location.story.path');

        if (!empty($old_galleries)) {
            foreach($old_galleries as $file){
                @unlink($location . $file);
                @unlink($location.'thumb_'.$file);
            }
        }

        $story->delete();

        return redirect()->back()->with('success', 'Story Deleted Successfully');
    }


    public function storySearch(Request $request)
    {
        $search = $request->all();

        $dateSearch = $request->datetrx;
        $date = preg_match("/^[0-9]{2,4}\-[0-9]{1,2}\-[0-9]{1,2}$/", $dateSearch);

        $storyList = Story::with('user:id,firstname,lastname,username,email,image')->orderBy('id', 'DESC')
            ->when(isset($search['user_name']), function ($query) use ($search) {
                return $query->whereHas('user', function ($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('username', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('firstname', 'LIKE', "%{$search['user_name']}%")
                        ->orWhere('lastname', 'LIKE', "%{$search['user_name']}%");
                });
            })
            ->when(isset($search['name']), function ($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search['name']}%");
            })
            ->when(isset($search['status']), function ($query) use ($search) {
                return $query->where('status', $search['status']);
            })
            ->when($date == 1, function ($query) use ($dateSearch) {
                return $query->whereDate("created_at", $dateSearch);
            })
            ->paginate(config('basic.paginate'));

        $storyList =  $storyList->appends($search);

        return view('admin.story.story', compact('storyList'));
    }




}
