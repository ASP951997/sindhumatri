<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Http\Controllers\User\HomeController;
use Illuminate\Http\Request;

echo "Testing controller method directly...\n";

try {
    // Create a mock request with the data from the error
    $requestData = [
        'partner_education' => "Bachelor's Degree",
        'partner_general_requirement' => 'Avaliable',
        'partner_min_height' => '4ft 6in',
        'partner_sub_caste' => '',
        'partner_language' => 'English',
        'partner_smoking_acceptancy' => 'No',
        'partner_drinking_acceptancy' => 'No',
        'partner_dieting_acceptancy' => 'Eggitarian',
        'partner_body_type' => '1',
        'partner_manglik' => 'No',
        'partner_preferred_state' => '',
        'partner_preferred_city' => '',
        'partner_family_value' => '9',
        'partner_complexion' => '4'
    ];

    $request = new Request();
    $request->merge($requestData);

    // Create controller instance
    $controller = new HomeController();

    // Mock the user property
    $user = User::find(461);
    $controller->user = $user;

    // Call the method
    $response = $controller->partnerExpectation($request);

    echo "Controller method executed successfully!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}









