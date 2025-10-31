# Package Duplicate Purchase Prevention

## Overview
This feature prevents users from purchasing the same package before their current subscription expires.

## Implementation Details

### Location
- **File**: `app/Http/Controllers/User/HomeController.php`
- **Method**: `purchasePlan()`
- **Lines**: 129-138

### How It Works

1. **Validation Check**: When a user attempts to purchase a package, the system checks if they already have an active subscription to that package.

2. **Active Subscription Criteria**:
   - Same `plan_id` as the one being purchased
   - Status = 1 (active)
   - Purchased within the last year (not expired)

3. **User Experience**:
   - If user already has an active subscription, a pop-up notification appears
   - Message: "You Already Purchased this package, try another package"
   - The notification uses Notiflix.Notify.Failure() for a clean pop-up display

### Code Changes

```php
// Check if user already has an active subscription for this plan
$existingActivePlan = Fund::where('user_id', $user->id)
    ->where('plan_id', $request->plan_id)
    ->where('status', 1)
    ->where('created_at', '>=', Carbon::now()->subYear())
    ->first();

if ($existingActivePlan) {
    return back()->with('error', 'You Already Purchased this package, try another package');
}
```

### Package Expiry
- All packages expire **1 year** after purchase
- Calculated as: `created_at + 1 year`

### Error Display
- Uses **Notiflix** notification library
- Displays as a pop-up (not inline message)
- Configured in: `resources/views/themes/deepblue/partials/notification.blade.php`

## Testing

### Test Scenario 1: New Package Purchase
1. User logs in
2. Navigates to Packages page
3. Selects a package (e.g., Silver)
4. Clicks "Purchase Package"
5. ✅ **Result**: Purchase proceeds normally

### Test Scenario 2: Duplicate Package Purchase (Active)
1. User logs in (already has active Silver package)
2. Navigates to Packages page
3. Attempts to purchase Silver package again
4. Clicks "Purchase Package"
5. ✅ **Result**: Pop-up appears with message "You Already Purchased this package, try another package"

### Test Scenario 3: Re-purchase After Expiry
1. User logs in (Silver package expired > 1 year ago)
2. Navigates to Packages page
3. Selects Silver package
4. Clicks "Purchase Package"
5. ✅ **Result**: Purchase proceeds normally (can re-purchase after expiry)

## Files Modified
- `app/Http/Controllers/User/HomeController.php` - Added validation logic

## Benefits
- Prevents duplicate charges
- Better user experience
- Clear error messaging
- Respects package expiry dates

## Date Implemented
October 31, 2025

