<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoint;
use App\Models\LoyaltyPointTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoyaltyPointController extends Controller
{
    // For Customer: Show loyalty points dashboard
    public function index()
    {
        $loyaltyPoint = LoyaltyPoint::firstOrCreate(
            ['user_id' => Auth::id()],
            ['points_earned' => 0, 'points_redeemed' => 0, 'points_balance' => 0]
        );

        $transactions = LoyaltyPointTransaction::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('loyalty.index', compact('loyaltyPoint', 'transactions'));
    }

    // For Admin: Manually adjust customer loyalty points
    public function adjust(Request $request, User $user)
    {
        $request->validate([
            'points' => 'required|integer',
            'type' => 'required|in:earn,redeem',
        ]);

        $loyaltyPoint = LoyaltyPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['points_earned' => 0, 'points_redeemed' => 0, 'points_balance' => 0]
        );

        if ($request->type === 'earn') {
            $loyaltyPoint->update([
                'points_earned' => $loyaltyPoint->points_earned + $request->points,
                'points_balance' => $loyaltyPoint->points_balance + $request->points,
            ]);
        } else {
            $redeemable = min($request->points, $loyaltyPoint->points_balance);
            $loyaltyPoint->update([
                'points_redeemed' => $loyaltyPoint->points_redeemed + $redeemable,
                'points_balance' => $loyaltyPoint->points_balance - $redeemable,
            ]);
        }

        LoyaltyPointTransaction::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'points' => $request->points,
        ]);

        return redirect()->back()->with('success', 'Loyalty points adjusted successfully.');
    }
}