<?php

namespace Modules\Accounting\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\ExchangeRate;

class ExchangeRateController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => ['required'],
        ]);
        // if (ExchangeRate::where('date', $request->date)->exists()) {
        //     $this->validationError('date', 'Date Exists');
        // }
        try {
            $ExchangeRate = new ExchangeRate();
            $ExchangeRate->company_id = $request->company_id;
            $ExchangeRate->date = $request->date;
            $ExchangeRate->currency = $request->currency;
            $ExchangeRate->exchange_rate = $request->exchange_rate;
            $ExchangeRate->for_buying = $request->has('for_buying');
            $ExchangeRate->for_selling = $request->has('for_selling');
            $ExchangeRate->enabled = $request->has('enabled');
            $ExchangeRate->created_by = Auth::user()->id;
            $save = $ExchangeRate->save();



            if ($save) {
                return $this->responseBody(true, "save", "Exchange Rate Saved", 'Data Saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something Went Wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'currency' => ['required'],
        ]);
        $data = ExchangeRate::where('currency', $request->currency);
        // if ($data->exists()) {
        //     if ($data->first()->exchange_rate != $request->exchange_rate) {
        //         $this->validationError('exchange_rate', 'Exchange Rate Not Changed');
        //     }
        // }
        try {
            $ExchangeRate = ExchangeRate::find($request->id);
            $ExchangeRate->company_id = $request->company_id;
            $ExchangeRate->date = $request->date;
            $ExchangeRate->currency = $request->currency;
            $ExchangeRate->exchange_rate = $request->exchange_rate;
            $ExchangeRate->for_buying = $request->has('for_buying');
            $ExchangeRate->for_selling = $request->has('for_selling');
            $ExchangeRate->enabled = $request->has('enabled');
            $ExchangeRate->modified_by = Auth::user()->id;
            $save = $ExchangeRate->save();

            if ($save) {
                return $this->responseBody(true, "save", "Exchange Rate saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadExchangeRates()
    {
        try {
            $ExchangeRate = DB::table('accounting_exchange_rate')
                                ->leftJoin('settings_currencies','accounting_exchange_rate.currency','=','settings_currencies.id')
                                ->select('accounting_exchange_rate.id','accounting_exchange_rate.date','settings_currencies.currency_code','settings_currencies.currency_name','accounting_exchange_rate.exchange_rate','accounting_exchange_rate.for_buying','accounting_exchange_rate.for_selling')
                                ->orderBy('date','DESC')
                                ->get();

            return $this->responseBody(true, "Load Exchange Rates", "Found", $ExchangeRate);
        } catch (Exception $ex) {
            return $this->responseBody(false, "Load Exchange Rates", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ExchangeRate = ExchangeRate::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Exchange Rate Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadExchangeRate($id)
    {
        try {
            $ExchangeRate = ExchangeRate::where('id', $id)->first();
            return $this->responseBody(true, "loadExchangeRate", "found", $ExchangeRate);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadExchangeRate", "error", $exception->getMessage());
        }
    }

}
