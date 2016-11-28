<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Setting;

class FundsController extends Controller
{
    /**
     * Adds funds
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addFunds(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'amount' => 'required|numeric|min:0'
        ]);

        // Get all parameters from the request
        $user = Auth::user();
        $amount = $request->amount;

        // Additional checks for amount
        if($amount <= 0) {
            return back()->withInput()->withErrors(['amount' => 'The amount must be a positive number']);
        } elseif ((100 * $amount) - floor(100 * $amount) != 0) {
            return back()->withInput()->withErrors(['amount' => 'The number can only have two decimal digits']);
        }

        // Add funds
        $user->balance += $amount;

        // Save
        $user->save();

        // Confirm that the amount has been added successfully
        $display_amount = number_format($amount, 2, '.', ',');
        return back()->with('success', 'An amount of $'.$display_amount.' has been added to your account.');
    }

    /**
     * Withdraw funds
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function withdrawFunds(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'amount' => 'required|numeric'
        ]);

        // Get all parameters from the request
        $user = Auth::user();
        $amount = $request->amount;
        $minimumBalance = Setting::find('user_balance_withdraw')->value;

        // Additional checks for amount
        if($amount <= 0) {
            return back()->withInput()->withErrors(['amount' => 'The amount must be a positive number']);
        } elseif ((100 * $amount) - floor(100 * $amount) != 0) {
            return back()->withInput()->withErrors(['amount' => 'The number can only have two decimal digits']);
        } elseif ($user->balance < $amount) {
            return back()->withInput()->withErrors(['amount' => 'You have insufficient funds to withdraw such amount.']);
        } elseif ($user->balance < $minimumBalance) {
            return back()->withInput()->withErrors(['amount' => 'Your account balance must at least hold $'. $minimumBalance . " in order to perform a withdrawal."]);
        }

        // Withdraw funds
        $user->balance -= $amount;

        // Save
        $user->save();

        // Confirm that the funds have been withdrawn
        $display_amount = number_format($amount, 2, '.', ',');
        $display_balance = number_format($user->balance, 2, '.', ',');
        return back()->with('success', 'An amount of $'.$display_amount.' has been withdrawn from your account. Your balance is now $'.$display_balance.'.');
    }
}
