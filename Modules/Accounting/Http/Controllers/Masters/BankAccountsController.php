<?php

namespace Modules\Accounting\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\Bank;
use Modules\Accounting\Entities\BankAccount;
use Modules\Accounting\Entities\BankAccountType;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Currency;

class BankAccountsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required'],
            'account_title' => ['required'],
            'account_type' => ['required'],
            'bank' => ['required'],
            'bank_code' => ['required'],
            'branch' => ['required'],
            'branch_code' => ['required'],
            'account_name' => ['required'],
            'account_number' => ['required'],
            'default_currency' => ['required'],
        ]);
        try {
            $BankAccount = new BankAccount();
            $BankAccount->company = $request->company;
            $BankAccount->account_title = $request->account_title;
            $BankAccount->account_type = $request->account_type;
            $BankAccount->bank = $request->bank;
            $BankAccount->bank_code = $request->bank_code;
            $BankAccount->branch = $request->branch;
            $BankAccount->branch_code = $request->branch_code;
            $BankAccount->account_name = $request->account_name;
            $BankAccount->account_number = $request->account_number;
            $BankAccount->default_currency = $request->default_currency;
            $BankAccount->swift_code = $request->swift_code;
            $BankAccount->enabled = $request->has('enabled');
            $BankAccount->created_by = Auth::user()->id;
            $save = $BankAccount->save();



            if ($save) {
                return $this->responseBody(true, "save", "Bank Account Saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required'],
            'account_title' => ['required'],
            'account_type' => ['required'],
            'bank' => ['required'],
            'bank_code' => ['required'],
            'branch' => ['required'],
            'branch_code' => ['required'],
            'account_name' => ['required'],
            'account_number' => ['required'],
            'default_currency' => ['required'],
        ]);
        try {
            $BankAccount = BankAccount::find($request->id);
            $BankAccount->company = $request->company;
            $BankAccount->account_title = $request->account_title;
            $BankAccount->account_type = $request->account_type;
            $BankAccount->bank = $request->bank;
            $BankAccount->bank_code = $request->bank_code;
            $BankAccount->branch = $request->branch;
            $BankAccount->branch_code = $request->branch_code;
            $BankAccount->account_name = $request->account_name;
            $BankAccount->account_number = $request->account_number;
            $BankAccount->default_currency = $request->default_currency;
            $BankAccount->swift_code = $request->swift_code;
            $BankAccount->enabled = $request->has('enabled');
            $BankAccount->modified_by = Auth::user()->id;
            $save = $BankAccount->save();

            if ($save) {
                return $this->responseBody(true, "save", "Bank Account Saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBankAccounts()
    {
        try {
            $BankAccount = BankAccount::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadBankAccounts", "found", $BankAccount);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBankAccounts", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $BankAccount = BankAccount::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Bank Account Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBankAccount($id)
    {
        try {
            $BankAccount = BankAccount::where('id', $id)->first();
            return $this->responseBody(true, "loadBankAccount", "found", $BankAccount);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBankAccount", "error", $exception->getMessage());
        }
    }
    public function loadDropDownData()
    {
        try {
            $Company = Company::where('enabled', true)->get();
            $BankAccountType = BankAccountType::where('enabled', true)->get();
            $Bank = Bank::where('enabled', true)->get();
            $Currency =  Currency::where('enabled', true)->get();

            return $this->responseBody(true, "loadDropDownData", '', [
                'Company' => $Company,
                'BankAccountType' => $BankAccountType,
                'Bank' => $Bank,
                'Currency' => $Currency,

            ]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDropDownData", '', $ex->getMessage());
        }
    }
}
