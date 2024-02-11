<?php

namespace Modules\Accounting\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\ItemPrice;
use Modules\Accounting\Entities\PriceList;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\UOM;

class ItemPriceController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'item' => ['required'],
            'price_list' => ['required'],
            'uom' => ['required'],
            'price' => ['required'],
        ]);
        if(ItemPrice::where('item',$request->item)->where('price_list',$request->price_list)->where('uom',$request->uom)->exists()){
            $this->validationError('price_list','This item exists in the price list');
        }
        try {
            $ItemPrice = new ItemPrice();
            $ItemPrice->item = $request->item;
            $ItemPrice->price_list = $request->price_list;
            $ItemPrice->uom = $request->uom;
            $ItemPrice->price = $request->price;
            $ItemPrice->enabled = $request->has('enabled');
            $ItemPrice->created_by = Auth::user()->id;
            $save = $ItemPrice->save();



            if ($save) {
                return $this->responseBody(true, "save", "ItemPrice saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'item' => ['required'],
            'price_list' => ['required'],
            'uom' => ['required'],
            'price' => ['required'],
        ]);
        $data=ItemPrice::where('item',$request->item)->where('price_list',$request->price_list)->where('uom',$request->uom);
        if($data->exists()){
            if($data->first()->id!=$request->id){
                $this->validationError('price_list','This item exists in the price list');
            }
        }
        try {
            $ItemPrice = ItemPrice::find($request->id);
            $ItemPrice->item = $request->item;
            $ItemPrice->price_list = $request->price_list;
            $ItemPrice->uom = $request->uom;
            $ItemPrice->price = $request->price;
            $ItemPrice->enabled = $request->has('enabled');
            $ItemPrice->modified_by = Auth::user()->id;
            $save = $ItemPrice->save();

            if ($save) {
                return $this->responseBody(true, "save", "ItemPrice saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadItemPrices()
    {
        try {
            // $ItemPrice = ItemPrice::orderBy('id','ASC')
            // ->get();
            $ItemPrice =DB::table('accounting_item_price')
                            // ->leftJoin('inventory_uom','inventory_uom.id','=','accounting_item_price.uom')
                            ->leftJoin('accounting_price_list','accounting_price_list.id','=','accounting_item_price.price_list')
                            ->leftJoin('inventory_items','inventory_items.id','=','accounting_item_price.item')
                            ->select('accounting_item_price.id','accounting_item_price.price','accounting_price_list.price_list_name as price_list','inventory_items.item_name as item')
                            ->orderBy('id','ASC')
                            ->get();

            return $this->responseBody(true, "loadItemPrices", "found", $ItemPrice);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemPrices", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ItemPrice = ItemPrice::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ItemPrice Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadItemPrice($id)
    {
        try {
            $ItemPrice = ItemPrice::where('id', $id)->first();
            return $this->responseBody(true, "loadItemPrice", "found", $ItemPrice);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadItemPrice", "error", $exception->getMessage());
        }
    }
    public function loadItems()
    {
        try {
            $Item = Item::where('enabled',true)->get();

            return $this->responseBody(true, "loadItems", '', $Item);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", '', $ex->getMessage());
        }
    }
    public function loadPriceLists()
    {
        try {
            $PriceList = PriceList::where('enabled',true)->get();

            return $this->responseBody(true, "loadItems", '', $PriceList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItems", '', $ex->getMessage());
        }
    }
    public function loadUOMs()
    {
        try {
            $UOM = UOM::where('enabled',true)->get();

            return $this->responseBody(true, "loadUOMs", '', $UOM);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadUOMs", '', $ex->getMessage());
        }
    }
    public function loadPriceList($id)
    {
        try {
            // $ItemPrice = ItemPrice::orderBy('id','ASC')
            // ->get();
            $loadPriceList =DB::table('accounting_item_price')
                            ->leftJoin('inventory_uom','inventory_uom.id','=','accounting_item_price.uom')
                            // ->leftJoin('accounting_price_list','accounting_price_list.id','=','accounting_item_price.price_list')
                            ->leftJoin('inventory_items','inventory_items.id','=','accounting_item_price.item')
                            ->where('accounting_item_price.price_list',$id)
                            ->select('accounting_item_price.id','accounting_item_price.price','inventory_uom.UomName as uom','inventory_items.item_name as item')
                            ->orderBy('id','ASC')
                            ->get();

            return $this->responseBody(true, "loadItemPrices", "found", $loadPriceList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemPrices", "Something went wrong", $ex->getMessage());
        }
    }
}
