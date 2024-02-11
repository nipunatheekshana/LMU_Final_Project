<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\CuttingType;

class CuttingtypeMasterController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CutTypeCode' => ['required'],
            'CutTypeName' => ['required'],
        ]);
        if(CuttingType::where('CutTypeCode',$request->CutTypeCode)->exists()){
            $this->validationError('CutTypeCode','Cut Type Code Exists');

        }
        if(CuttingType::where('CutTypeName',$request->CutTypeName)->exists()){
            $this->validationError('CutTypeName','Cut Type Name Exists');

        }
        try {
            $CuttingType = new CuttingType();
            $CuttingType->CutTypeCode = $request->CutTypeCode;
            $CuttingType->CutTypeName = $request->CutTypeName;
            $CuttingType->list_index = $request->list_index;
            $CuttingType->enabled = $request->has('enabled');
            $CuttingType->created_by = Auth::user()->id;
            $save = $CuttingType->save();



            if ($save) {
                return $this->responseBody(true, "save", "CuttingType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CutTypeCode' => ['required'],
            'CutTypeName' => ['required'],
        ]);
        $data1=CuttingType::where('CutTypeCode',$request->CutTypeCode);
        $data2=CuttingType::where('CutTypeName',$request->CutTypeName);
        if($data1->exists()){
            if($data1->first()->id!=$request->id){
                $this->validationError('CutTypeCode','Cut Type Code Exists');
            }
        }
        if($data2->exists()){
            if($data2->first()->id!=$request->id){
                $this->validationError('CutTypeName','Cut Type Name Exists');
            }
        }
        try {
            $CuttingType = CuttingType::find($request->id);
            $CuttingType->CutTypeCode = $request->CutTypeCode;
            $CuttingType->CutTypeName = $request->CutTypeName;
            $CuttingType->list_index = $request->list_index;
            $CuttingType->enabled = $request->has('enabled');
            $CuttingType->modified_by = Auth::user()->id;
            $save = $CuttingType->save();

            if ($save) {
                return $this->responseBody(true, "save", "CuttingType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCuttingTypes()
    {
        try {
            $CuttingType = CuttingType::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadCuttingTypes", "found", $CuttingType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCuttingTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CuttingType = CuttingType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CuttingType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadcuttingtypeMaster($id)
    {
        try {
            $CuttingType = CuttingType::where('id', $id)->first();
            return $this->responseBody(true, "User", "CuttingType ", $CuttingType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
}
