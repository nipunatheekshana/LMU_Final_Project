<?php

namespace Modules\Quality\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Quality\Entities\QualityCheckParamater;

class QualityCheckParamatersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'QParamName' => ['required'],
        ]);
        try {
            $QualityCheckParamater = new QualityCheckParamater();
            $QualityCheckParamater->QParamName = $request->QParamName;
            $QualityCheckParamater->MinValue = $request->MinValue;
            $QualityCheckParamater->MaxValue = $request->MaxValue;
            $QualityCheckParamater->list_index = $request->list_index;
            $QualityCheckParamater->enabled = $request->has('enabled');
            $QualityCheckParamater->created_by = Auth::user()->id;
            $save = $QualityCheckParamater->save();



            if ($save) {
                return $this->responseBody(true, "save", "QualityCheckParamater saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'QParamName' => ['required'],
        ]);
        try {
            $QualityCheckParamater = QualityCheckParamater::find($request->id);
            $QualityCheckParamater->QParamName = $request->QParamName;
            $QualityCheckParamater->MinValue = $request->MinValue;
            $QualityCheckParamater->MaxValue = $request->MaxValue;
            $QualityCheckParamater->list_index = $request->list_index;
            $QualityCheckParamater->enabled = $request->has('enabled');
            $QualityCheckParamater->modified_by = Auth::user()->id;
            $save = $QualityCheckParamater->save();

            if ($save) {
                return $this->responseBody(true, "save", "QualityCheckParamater saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadqualityCheckParameters()
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadQualityCheckParamaters", "found", $QualityCheckParamater);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadQualityCheckParamaters", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('id', $id)->delete();
            return $this->responseBody(true, "User", "QualityCheckParamater Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('id', $id)->first();
            return $this->responseBody(true, "User", "QualityCheckParamater ", $QualityCheckParamater);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadQualityCheckParameter($id)
    {
        try {
            $QualityCheckParamater = QualityCheckParamater::where('id', $id)->first();
            return $this->responseBody(true, "loadQualityCheckParamater", "found", $QualityCheckParamater);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadQualityCheckParamater", "error", $exception->getMessage());
        }
    }


}
