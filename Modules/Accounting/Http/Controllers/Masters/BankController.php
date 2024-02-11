<?php

namespace Modules\Accounting\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\Bank;

class BankController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'bank_name' => ['required'],
        ]);
        if (Bank::where('bank_name', $request->bank_name)->exists()) {
            $this->validationError('bank_name', 'Bank Exists');
        }
        try {
            $Bank = new Bank();
            $Bank->bank_name = $request->bank_name;
            $Bank->enabled = $request->has('enabled');
            $Bank->created_by = Auth::user()->id;
            $save = $Bank->save();



            if ($save) {
                return $this->responseBody(true, "save", "Bank saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'bank_name' => ['required'],
        ]);
        $data = Bank::where('bank_name', $request->bank_name);
        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('bank_name', 'Bank Exists');
            }
        }
        try {
            $Bank = Bank::find($request->id);
            $Bank->bank_name = $request->bank_name;
            $Bank->enabled = $request->has('enabled');
            $Bank->modified_by = Auth::user()->id;
            $save = $Bank->save();

            if ($save) {
                return $this->responseBody(true, "save", "Bank saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBanks()
    {
        try {
            $Bank = Bank::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadBanks", "found", $Bank);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBanks", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Bank = Bank::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Bank Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBank($id)
    {
        try {
            $Bank = Bank::where('id', $id)->first();
            return $this->responseBody(true, "loadBank", "found", $Bank);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBank", "error", $exception->getMessage());
        }
    }
   
}
