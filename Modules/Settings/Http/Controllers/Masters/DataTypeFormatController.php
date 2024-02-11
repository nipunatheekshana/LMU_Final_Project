<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Settings\Entities\DataType;
use Modules\Settings\Entities\DataTypeFormat;

class DataTypeFormatController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'data_type_id' => ['required'],
            'format' => ['required'],
        ]);
        if (DataTypeFormat::where('data_type_id',$request->data_type_id)->where('format',$request->format)->exists()) {
            $this->validationError('format', 'this Data type Alredy Has a this format Please Edit or delete It');
        }
        try {
            $DataTypeFormat = new DataTypeFormat();
            $DataTypeFormat->data_type_id = $request->data_type_id;
            $DataTypeFormat->format = $request->format;
            $DataTypeFormat->sample_data = $request->sample_data;
            $DataTypeFormat->enabled = $request->has('enabled');
            $DataTypeFormat->created_by = Auth::user()->id;
            $save = $DataTypeFormat->save();



            if ($save) {
                return $this->responseBody(true, "save", "DataTypeFormat saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'data_type_id' => ['required'],
            'format' => ['required'],
        ]);
        $data = DataTypeFormat::where('data_type_id',$request->data_type_id)->where('format',$request->format);
        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('format', 'this Data type Alredy Has a this format Please Edit or delete It');
            }
        }
        try {
            $DataTypeFormat = DataTypeFormat::find($request->id);
            $DataTypeFormat->data_type_id = $request->data_type_id;
            $DataTypeFormat->format = $request->format;
            $DataTypeFormat->sample_data = $request->sample_data;
            $DataTypeFormat->enabled = $request->has('enabled');
            $DataTypeFormat->modified_by = Auth::user()->id;
            $save = $DataTypeFormat->save();

            if ($save) {
                return $this->responseBody(true, "save", "DataTypeFormat saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDataTypeFormats()
    {
        try {
            // $DataTypeFormat = DataTypeFormat::orderBy('id','ASC')
            // ->get();
            $DataTypeFormat = DB::table('settings_data_types_formats')
                ->leftJoin('settings_data_types', 'settings_data_types.id', '=', 'settings_data_types_formats.data_type_id')
                ->select('settings_data_types_formats.id', 'settings_data_types_formats.format', 'settings_data_types.data_type')
                ->get();
            return $this->responseBody(true, "loadDataTypeFormats", "found", $DataTypeFormat);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadDataTypeFormats", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $DataTypeFormat = DataTypeFormat::where('id', $id)->delete();
            return $this->responseBody(true, "User", "DataTypeFormat Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadDataTypeFormat($id)
    {
        try {
            $DataTypeFormat = DataTypeFormat::where('id', $id)->first();
            return $this->responseBody(true, "loadDataTypeFormat", "found", $DataTypeFormat);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadDataTypeFormat", "error", $exception->getMessage());
        }
    }
    public function loadDataTypes()
    {
        try {
            $DataType = DataType::where('enabled', true)->get();

            return $this->responseBody(true, "loadParentGroups", '', $DataType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroups", '', $ex->getMessage());
        }
    }
}
