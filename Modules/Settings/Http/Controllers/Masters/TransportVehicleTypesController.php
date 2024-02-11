<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\TransportMode;
use Modules\Settings\Entities\TransportVehicleType;

class TransportVehicleTypesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'VehicleTypeName' => ['required'],
            'TransportMode' => ['required'],
        ]);
        if (TransportVehicleType::where('VehicleTypeName', $request->VehicleTypeName)->exists()) {
            $this->validationError('VehicleTypeName', 'Vehicle Type Name Exists');
        }
        try {
            $TransportVehicleType = new TransportVehicleType();
            $TransportVehicleType->VehicleTypeName = $request->VehicleTypeName;
            $TransportVehicleType->TransportMode = $request->TransportMode;
            $TransportVehicleType->list_index = $request->list_index;
            $TransportVehicleType->enabled = $request->has('enabled');
            $TransportVehicleType->created_by = Auth::user()->id;
            $save = $TransportVehicleType->save();



            if ($save) {
                return $this->responseBody(true, "save", "TransportVehicleType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'VehicleTypeName' => ['required'],
            'TransportMode' => ['required'],
        ]);
        $data = TransportVehicleType::where('VehicleTypeName', $request->VehicleTypeName);
        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('VehicleTypeName', 'Vehicle Type Name Exists');
            }
        }
        try {
            $TransportVehicleType = TransportVehicleType::find($request->id);
            $TransportVehicleType->VehicleTypeName = $request->VehicleTypeName;
            $TransportVehicleType->TransportMode = $request->TransportMode;
            $TransportVehicleType->list_index = $request->list_index;
            $TransportVehicleType->enabled = $request->has('enabled');
            $TransportVehicleType->modified_by = Auth::user()->id;
            $save = $TransportVehicleType->save();

            if ($save) {
                return $this->responseBody(true, "save", "TransportVehicleType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadTransportVehicleTypes()
    {
        try {
            $TransportVehicleType = TransportVehicleType::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadTransportVehicleTypes", "found", $TransportVehicleType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadTransportVehicleTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $TransportVehicleType = TransportVehicleType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "TransportVehicleType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $TransportVehicleType = TransportVehicleType::where('id', $id)->first();
            return $this->responseBody(true, "User", "TransportVehicleType ", $TransportVehicleType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadTransportVehicleType($id)
    {
        try {
            $TransportVehicleType = TransportVehicleType::where('id', $id)->first();
            return $this->responseBody(true, "loadTransportVehicleType", "found", $TransportVehicleType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadTransportVehicleType", "error", $exception->getMessage());
        }
    }
    public function loadTransportMode()
    {
        try {
            $TransportMode = TransportMode::where('enabled', true)->get();

            return $this->responseBody(true, "loadParentGroups", '', $TransportMode);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadParentGroups", '', $ex->getMessage());
        }
    }
}
