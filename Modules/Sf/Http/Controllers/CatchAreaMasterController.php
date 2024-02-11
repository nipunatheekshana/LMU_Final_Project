<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\CatchArea;

class CatchAreaMasterController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'AreaCode' => ['required'],
            'AreaName' => ['required'],
        ]);
        if(CatchArea::where('AreaCode',$request->AreaCode)->exists()){
            $this->validationError('AreaCode','Area Code Exists');
        }
        if(CatchArea::where('AreaName',$request->AreaName)->exists()){
            $this->validationError('AreaName','Area Name Exists');
        }
        try {
            $CatchArea = new CatchArea();
            $CatchArea->AreaCode = $request->AreaCode;
            $CatchArea->AreaName = $request->AreaName;
            $CatchArea->list_index = $request->list_index;
            $CatchArea->enabled = $request->has('enabled');
            $CatchArea->created_by = Auth::user()->id;
            $save = $CatchArea->save();



            if ($save) {
                return $this->responseBody(true, "save", "CatchArea saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'AreaCode' => ['required'],
            'AreaName' => ['required'],
        ]);
        $data1=CatchArea::where('AreaCode',$request->AreaCode);
        $data2=CatchArea::where('AreaName',$request->AreaName);
        if($data1->exists()){
            if($data1->first()->id!=$request->id){
                $this->validationError('AreaCode','Area Code Exists');
            }
        }
        if($data2->exists()){
            if($data2->first()->id!=$request->id){
                $this->validationError('AreaName','Area name Exists');
            }
        }

        try {
            $CatchArea = CatchArea::find($request->id);
            $CatchArea->AreaCode = $request->AreaCode;
            $CatchArea->AreaName = $request->AreaName;
            $CatchArea->list_index = $request->list_index;

            $CatchArea->enabled = $request->has('enabled');
            $CatchArea->modified_by = Auth::user()->id;
            $save = $CatchArea->save();

            if ($save) {
                return $this->responseBody(true, "save", "CatchArea saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCatchAreas()
    {
        try {
            $CatchArea = CatchArea::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadCatchAreas", "found", $CatchArea);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCatchAreas", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CatchArea = CatchArea::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CatchArea Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadcatchAreaMaster($id)
    {
        try {
            $CatchArea = CatchArea::where('id', $id)->first();
            return $this->responseBody(true, "User", "CatchArea ", $CatchArea);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
}
