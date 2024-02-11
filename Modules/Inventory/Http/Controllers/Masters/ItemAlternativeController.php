<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Inventory\Entities\Item;
use Modules\Inventory\Entities\ItemAlternative;

class ItemAlternativeController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'item' => ['required'],
            'item_alternative' => ['required'],
        ]);
        if($request->item==$request->item_alternative){
            $this->validationError('item_alternative','Cant Use the same Item As alternative');
        }
        if(ItemAlternative::where('item',$request->item)->where('item_alternative',$request->item_alternative)->exists()){
            $this->validationError('item_alternative','Alternative Exists');
        }
        try {
            $ItemAlternative = new ItemAlternative();
            $ItemAlternative->item = $request->item;
            $ItemAlternative->item_alternative = $request->item_alternative;
            $ItemAlternative->two_way = $request->has('two_way');
            $ItemAlternative->enabled = $request->has('enabled');
            $ItemAlternative->created_by = Auth::user()->id;
            $save = $ItemAlternative->save();



            if ($save) {
                return $this->responseBody(true, "save", "ItemAlternative saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'item' => ['required'],
            'item_alternative' => ['required'],
        ]);
        $data=ItemAlternative::where('item',$request->item)->where('item_alternative',$request->item_alternative);
        if($request->item==$request->item_alternative){
            $this->validationError('item_alternative','Cant Use the same Item As alternative');
        }
        if($data->exists()){
            if($data->first()->id!=$request->id){
                $this->validationError('item_alternative','Alternative Exists');
            }
        }
        try {
            $ItemAlternative = ItemAlternative::find($request->id);
            $ItemAlternative->item = $request->item;
            $ItemAlternative->item_alternative = $request->item_alternative;
            $ItemAlternative->two_way = $request->has('two_way');
            $ItemAlternative->enabled = $request->has('enabled');
            $ItemAlternative->modified_by = Auth::user()->id;
            $save = $ItemAlternative->save();

            if ($save) {
                return $this->responseBody(true, "save", "ItemAlternative saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadItemAlternatives()
    {
        try {
            // $ItemAlternative = ItemAlternative::orderBy('id','ASC')
            // ->get();
            $ItemAlternative = DB::table('inventory_item_alternatives as IA')
                                ->leftJoin('inventory_items as I','IA.item','I.id')
                                ->leftJoin('inventory_items as D','IA.item_alternative','D.id')
                                ->select('IA.id', 'I.item_name as item','D.item_name as item_alternative')
                                ->orderBy('IA.id','ASC')
                                ->get();


            return $this->responseBody(true, "loadItemAlternatives", "found", $ItemAlternative);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadItemAlternatives", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $ItemAlternative = ItemAlternative::where('id', $id)->delete();
            return $this->responseBody(true, "User", "ItemAlternative Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadItemAlternative($id)
    {
        try {
            $ItemAlternative = ItemAlternative::where('id', $id)->first();
            return $this->responseBody(true, "loadItemAlternative", "found", $ItemAlternative);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadItemAlternative", "error", $exception->getMessage());
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

}

