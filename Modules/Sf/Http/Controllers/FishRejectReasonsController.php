<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\FishRejectReason;

class FishRejectReasonsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'RejectReasonCode' => ['required'],
            'RejectReasonName' => ['required'],
        ]);
        if(FishRejectReason::where('rejectCode',$request->RejectReasonCode)->exists()){
            $this->validationError('rejectCode','Cut Type Code Exists');

        }
        if(FishRejectReason::where('rejectReason',$request->RejectReasonName)->exists()){
            $this->validationError('rejectReason','Cut Type Name Exists');

        }
        try {
            $FishRejectReason = new FishRejectReason();
            $FishRejectReason->rejectCode = $request->RejectReasonCode;
            $FishRejectReason->rejectReason = $request->RejectReasonName;
            $FishRejectReason->list_index = $request->list_index;
            $FishRejectReason->enabled = $request->has('enabled');
            $FishRejectReason->created_by = Auth::user()->id;
            $save = $FishRejectReason->save();



            if ($save) {
                return $this->responseBody(true, "save", "FishRejectReason saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'RejectReasonCode' => ['required'],
            'RejectReasonName' => ['required'],
        ]);
        $data1=FishRejectReason::where('rejectCode',$request->RejectReasonCode);
        $data2=FishRejectReason::where('rejectReason',$request->RejectReasonName);
        if($data1->exists()){
            if($data1->first()->id!=$request->id){
                $this->validationError('RejectReasonCode','Cut Type Code Exists');
            }
        }
        if($data2->exists()){
            if($data2->first()->id!=$request->id){
                $this->validationError('RejectReasonName','Cut Type Name Exists');
            }
        }
        try {
            $FishRejectReason = FishRejectReason::find($request->id);
            $FishRejectReason->rejectCode = $request->RejectReasonCode;
            $FishRejectReason->rejectReason = $request->RejectReasonName;
            $FishRejectReason->list_index = $request->list_index;
            $FishRejectReason->enabled = $request->has('enabled');
            $FishRejectReason->modified_by = Auth::user()->id;
            $save = $FishRejectReason->save();

            if ($save) {
                return $this->responseBody(true, "save", "FishRejectReason saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadFishRejectReasons()
    {
        try {
            $FishRejectReason = FishRejectReason::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadFishRejectReasons", "found", $FishRejectReason);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishRejectReasons", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $FishRejectReason = FishRejectReason::where('id', $id)->delete();
            return $this->responseBody(true, "User", "FishRejectReason Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadRejectReason($id)
    {
        try {
            $FishRejectReason = FishRejectReason::where('id', $id)->first();
            return $this->responseBody(true, "User", "FishRejectReason ", $FishRejectReason);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
}
