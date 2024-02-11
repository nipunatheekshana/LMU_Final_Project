<?php

namespace Modules\Accounting\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\BankAccountType;

class BankAccountTypesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'account_type_code' => ['required'],
            'account_type_name' => ['required'],

        ]);
        if (BankAccountType::where('account_type_code', $request->account_type_code)->exists()) {
            $this->validationError('account_type_code', 'Account Type Code Exists');
        }
        if (BankAccountType::where('account_type_name', $request->account_type_name)->exists()) {
            $this->validationError('account_type_name', 'Account Type Name Exists');
        }
        try {
            $BankAccountType = new BankAccountType();
            $BankAccountType->account_type_code = $request->account_type_code;
            $BankAccountType->account_type_name = $request->account_type_name;
            $BankAccountType->enabled = $request->has('enabled');
            $BankAccountType->created_by = Auth::user()->id;
            $save = $BankAccountType->save();



            if ($save) {
                return $this->responseBody(true, "save", "Bank Account Type Saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'account_type_code' => ['required'],
            'account_type_name' => ['required'],
        ]);
        $data1 = BankAccountType::where('account_type_code', $request->account_type_code);
        $data2 = BankAccountType::where('account_type_name', $request->account_type_name);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('account_type_code', 'Account Type Code Exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('account_type_name', 'Account Type Name Exists');
            }
        }
        try {
            $BankAccountType = BankAccountType::find($request->id);
            $BankAccountType->account_type_code = $request->account_type_code;
            $BankAccountType->account_type_name = $request->account_type_name;
            $BankAccountType->enabled = $request->has('enabled');
            $BankAccountType->modified_by = Auth::user()->id;
            $save = $BankAccountType->save();

            if ($save) {
                return $this->responseBody(true, "save", "Bank Account Type Saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBankAccountTypes()
    {
        try {
            $BankAccountType = BankAccountType::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadBankAccountTypes", "found", $BankAccountType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBankAccountTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $BankAccountType = BankAccountType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Bank Account Type Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBankAccountType($id)
    {
        try {
            $BankAccountType = BankAccountType::where('id', $id)->first();
            return $this->responseBody(true, "loadBankAccountType", "found", $BankAccountType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBankAccountType", "error", $exception->getMessage());
        }
    }

}
