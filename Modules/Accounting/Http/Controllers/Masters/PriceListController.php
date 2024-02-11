<?php

namespace Modules\Accounting\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Accounting\Entities\PriceList;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Currency;

class PriceListController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required'],
            'price_list_name' => ['required'],
            'currency' => ['required'],
        ]);

        if(PriceList::where('company',$request->company)->where('price_list_name',$request->price_list_name)->exists()){
            $this->validationError('price_list_name','price List Name Exists');
        }
        try {
            $PriceList = new PriceList();
            $PriceList->company = $request->company;
            $PriceList->price_list_name = $request->price_list_name;
            $PriceList->currency = $request->currency;
            $PriceList->buying = $request->has('buying');
            $PriceList->selling = $request->has('selling');
            $PriceList->list_index = $request->list_index;
            $PriceList->enabled = $request->has('enabled');
            $PriceList->created_by = Auth::user()->id;
            $save = $PriceList->save();



            if ($save) {
                return $this->responseBody(true, "save", "PriceList saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'company' => ['required'],
            'price_list_name' => ['required'],
            'currency' => ['required'],
        ]);
        $data=PriceList::where('company',$request->company)->where('price_list_name',$request->price_list_name);

        if($data->exists()){
            if($data->first()->id!=$request->id){
                $this->validationError('price_list_name','price List Name Exists');
            }
        }
        try {
            $PriceList = PriceList::find($request->id);
            $PriceList->company = $request->company;
            $PriceList->price_list_name = $request->price_list_name;
            $PriceList->currency = $request->currency;
            $PriceList->buying = $request->has('buying');
            $PriceList->selling = $request->has('selling');
            $PriceList->list_index = $request->list_index;
            $PriceList->enabled = $request->has('enabled');
            $PriceList->modified_by = Auth::user()->id;
            $save = $PriceList->save();

            if ($save) {
                return $this->responseBody(true, "save", "PriceList saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadPriceLists()
    {
        try {
            $PriceList = PriceList::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadPriceLists", "found", $PriceList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPriceLists", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $PriceList = PriceList::where('id', $id)->delete();
            return $this->responseBody(true, "User", "PriceList Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadPriceList($id)
    {
        try {
            $PriceList = PriceList::where('id', $id)->first();
            return $this->responseBody(true, "loadPriceList", "found", $PriceList);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadPriceList", "error", $exception->getMessage());
        }
    }
    public function loadCompanies()
    {
        try {
            $Company = Company::where('enabled',true)->get();

            return $this->responseBody(true, "loadCompanies", '', $Company);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCompanies", '', $ex->getMessage());
        }
    }
    public function loadCurrencies()
    {
        try {
            $Currency = Currency::where('enabled',true)->get();

            return $this->responseBody(true, "loadCurrencies", '', $Currency);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrencies", '', $ex->getMessage());
        }
    }

}
