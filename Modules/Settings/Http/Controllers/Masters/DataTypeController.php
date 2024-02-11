<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\DataType;

class DataTypeController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'data_type' => ['required'],
        ]);
        if (DataType::where('data_type', $request->data_type)->exists()) {
            $this->validationError('data_type', 'Data type Exists');
        }
        try {
            $DataType = new DataType();
            $DataType->data_type = $request->data_type;
            $DataType->enabled = $request->has('enabled');
            $DataType->created_by = Auth::user()->id;
            $save = $DataType->save();



            if ($save) {
                return $this->responseBody(true, "save", "DataType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'data_type' => ['required'],
        ]);
        $data = DataType::where('data_type', $request->data_type);
        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('data_type', 'Data type Exists');
            }
        }
        try {
            $DataType = DataType::find($request->id);
            $DataType->data_type = $request->data_type;
            $DataType->enabled = $request->has('enabled');
            $DataType->modified_by = Auth::user()->id;
            $save = $DataType->save();

            if ($save) {
                return $this->responseBody(true, "save", "DataType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDataTypes()
    {
        try {
            $DataType = DataType::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadDataTypes", "found", $DataType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDataTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $DataType = DataType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "DataType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDataType($id)
    {
        try {
            $DataType = DataType::where('id', $id)->first();
            return $this->responseBody(true, "loadDataType", "found", $DataType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDataType", "error", $exception->getMessage());
        }
    }
}
