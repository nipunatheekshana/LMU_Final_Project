<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\CatchMethod;

class CatchMethodMasterController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CatchMethodCode' => ['required'],
            'CatchMethodName' => ['required'],
        ]);
        if (CatchMethod::where('CatchMethodCode', $request->CatchMethodCode)->exists()) {
            $this->validationError('CatchMethodCode', 'Catch Method Code exists');
        }
        if (CatchMethod::where('CatchMethodName', $request->CatchMethodName)->exists()) {
            $this->validationError('CatchMethodName', 'Catch Method name exists');
        }
        try {
            $CatchMethod = new CatchMethod();
            $CatchMethod->CatchMethodCode = $request->CatchMethodCode;
            $CatchMethod->CatchMethodName = $request->CatchMethodName;
            $CatchMethod->list_index = $request->list_index;
            $CatchMethod->enabled = $request->has('enabled');
            $CatchMethod->created_by = Auth::user()->id;
            $save = $CatchMethod->save();



            if ($save) {
                return $this->responseBody(true, "save", "CatchMethod saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CatchMethodCode' => ['required'],
            'CatchMethodName' => ['required'],
        ]);

        $data1 = CatchMethod::where('CatchMethodCode', $request->CatchMethodCode);
        $data2 = CatchMethod::where('CatchMethodName', $request->CatchMethodName);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('CatchMethodCode', 'Catch Method Code exists');
            }
        }
        if ($data2->exists()) {
            if($data2->first()->id!=$request->id){
                $this->validationError('CatchMethodName', 'Catch Method name exists');
            }
        }
        try {
            $CatchMethod = CatchMethod::find($request->id);
            $CatchMethod->CatchMethodCode = $request->CatchMethodCode;
            $CatchMethod->CatchMethodName = $request->CatchMethodName;
            $CatchMethod->list_index = $request->list_index;
            $CatchMethod->enabled = $request->has('enabled');
            $CatchMethod->modified_by = Auth::user()->id;
            $save = $CatchMethod->save();

            if ($save) {
                return $this->responseBody(true, "save", "CatchMethod saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadCatchMethods()
    {
        try {
            $CatchMethod = CatchMethod::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadCatchMethods", "found", $CatchMethod);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCatchMethods", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $CatchMethod = CatchMethod::where('id', $id)->delete();
            return $this->responseBody(true, "User", "CatchMethod Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadcatchMethodMaster($id)
    {
        try {
            $CatchMethod = CatchMethod::where('id', $id)->first();
            return $this->responseBody(true, "User", "CatchMethod ", $CatchMethod);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
}
