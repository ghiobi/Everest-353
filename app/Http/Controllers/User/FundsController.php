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
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function addFunds(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'amount' => 'required|numeric'
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

        // Confirm that the message has been sent successfully
        $display_amount = number_format($amount, 2, '.', ',');
        $display_balance = number_format($user->balance, 2, '.', ',');
        return back()->with('success', 'An amount of $'.$display_amount.' has been added to your account. Your balance is now $'.$display_balance.'.');
    }

    /**
     * Withdraw funds
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function withdrawFunds(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'amount' => 'required|numeric',
            'recipient_id' => 'required|integer'
        ]);

        // Get all parameters from the request
        $user = Auth::user();
        $amount = $request->amount;
        $recipient = User::find($request->recipient_id);

        // Additional checks
        if($recipient == null) {
            return back()->withInput()->withErrors(['recipient' => 'The recipient of the transaction does not exist.']);
        } elseif($amount <= 0) {
            return back()->withInput()->withErrors(['amount' => 'The amount must be a positive number']);
        } elseif ((100 * $amount) - floor(100 * $amount) != 0) {
            return back()->withInput()->withErrors(['amount' => 'The number can only have two decimal digits']);
        } elseif ($user->balance < $amount) {
            return back()->withInput()->withErrors(['amount' => 'You have insufficient funds to perform that transaction.']);
        }

        // Get the admin user in order to add funds to its account
        $admin = User::find(1);
        $companyIncomePercentage = Setting::find('company_income_percentage')->value;

        // Withdraw money from the user, give 95% to receiver, 5% to the system administrator
        $user->balance -= $amount;
        $recipient->balance += (1 - $companyIncomePercentage) * $amount;
        $admin->balance += $companyIncomePercentage * $amount;

        // Save
        $user->save();
        $recipient->save();
        $admin->save();

        // Confirm that the message has been sent successfully
        $display_amount = number_format($amount, 2, '.', ',');
        $display_balance = number_format($user->balance, 2, '.', ',');
        return back()->with('success', 'An amount of $'.$display_amount.' has been withdrawn from your account. Your balance is now $'.$display_balance.'.');
    }
}
