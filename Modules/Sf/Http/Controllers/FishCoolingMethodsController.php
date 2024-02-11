<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\FishCoolingMethod;

class FishCoolingMethodsController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'MethodName' => ['required'],
            'MethodCode' => ['required'],
        ]);
        if (FishCoolingMethod::where('MethodName', $request->MethodName)->exists()) {
            $this->validationError('MethodName', 'Method Name Exists');
        }
        if (FishCoolingMethod::where('MethodCode', $request->MethodCode)->exists()) {
            $this->validationError('MethodCode', 'Method Code Exists');
        }
        try {
            $FishCoolingMethod = new FishCoolingMethod();
            $FishCoolingMethod->MethodName = $request->MethodName;
            $FishCoolingMethod->MethodCode = $request->MethodCode;
            $FishCoolingMethod->list_index = $request->list_index;
            $FishCoolingMethod->enabled = $request->has('enabled');
            $FishCoolingMethod->created_by = Auth::user()->id;
            $save = $FishCoolingMethod->save();



            if ($save) {
                return $this->responseBody(true, "save", "FishCoolingMethod saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'MethodName' => ['required'],
            'MethodCode' => ['required'],
        ]);
        $data1 = FishCoolingMethod::where('MethodName', $request->MethodName);
        $data2 = FishCoolingMethod::where('MethodCode', $request->MethodCode);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('MethodName', 'Method Name Exists');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('MethodCode', 'Method Code Exists');
            }
        }
        try {
            $FishCoolingMethod = FishCoolingMethod::find($request->id);
            $FishCoolingMethod->MethodName = $request->MethodName;
            $FishCoolingMethod->MethodCode = $request->MethodCode;
            $FishCoolingMethod->list_index = $request->list_index;
            $FishCoolingMethod->enabled = $request->has('enabled');
            $FishCoolingMethod->modified_by = Auth::user()->id;
            $save = $FishCoolingMethod->save();

            if ($save) {
                return $this->responseBody(true, "save", "FishCoolingMethod saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadFishCoolingMethods()
    {
        try {
            $FishCoolingMethod = FishCoolingMethod::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadFishCoolingMethods", "found", $FishCoolingMethod);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishCoolingMethods", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $FishCoolingMethod = FishCoolingMethod::where('id', $id)->delete();
            return $this->responseBody(true, "User", "FishCoolingMethod Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $FishCoolingMethod = FishCoolingMethod::where('id', $id)->first();
            return $this->responseBody(true, "User", "FishCoolingMethod ", $FishCoolingMethod);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadFishCoolingMethod($id)
    {
        try {
            $FishCoolingMethod = FishCoolingMethod::where('id', $id)->first();
            return $this->responseBody(true, "loadFishCoolingMethod", "found", $FishCoolingMethod);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadFishCoolingMethod", "error", $exception->getMessage());
        }
    }
    public function loadParentGroups()
    {
        try {
            $FishCoolingMethod = FishCoolingMethod::where('isGroup', true)->get();

            return $this->responseBody(true, "loadParentGroups", '', $FishCoolingMethod);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroups", '', $ex->getMessage());
        }
    }
}
