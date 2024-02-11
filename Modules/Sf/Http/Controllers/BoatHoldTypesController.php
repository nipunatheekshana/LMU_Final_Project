<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Sf\Entities\BoatHoldType;

class BoatHoldTypesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'HoldTypeName' => ['required'],

        ]);
        try {
            $BoatHoldType = new BoatHoldType();
            $BoatHoldType->HoldTypeName = $request->HoldTypeName;
            $BoatHoldType->list_index = $request->list_index;
            $BoatHoldType->enabled = $request->has('enabled');
            $BoatHoldType->created_by = Auth::user()->id;
            $save = $BoatHoldType->save();



            if ($save) {
                return $this->responseBody(true, "save", "BoatHoldType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'HoldTypeName' => ['required'],

        ]);
        try {
            $BoatHoldType = BoatHoldType::find($request->id);
            $BoatHoldType->HoldTypeName = $request->HoldTypeName;
            $BoatHoldType->list_index = $request->list_index;
            $BoatHoldType->enabled = $request->has('enabled');
            $BoatHoldType->modified_by = Auth::user()->id;
            $save = $BoatHoldType->save();

            if ($save) {
                return $this->responseBody(true, "save", "BoatHoldType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBoatHoldTypes()
    {
        try {
            // $BoatHoldType = BoatHoldType::orderBy('id','ASC')
            // ->get();

            $BoatHoldType = BoatHoldType::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadBoatHoldTypes", "found", $BoatHoldType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBoatHoldTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $BoatHoldType = BoatHoldType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "BoatHoldType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $BoatHoldType = BoatHoldType::where('id', $id)->first();
            return $this->responseBody(true, "User", "BoatHoldType ", $BoatHoldType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadBoatHoldType($id)
    {
        try {
            $BoatHoldType = BoatHoldType::where('id', $id)->first();
            return $this->responseBody(true, "loadBoatHoldType", "found", $BoatHoldType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBoatHoldType", "error", $exception->getMessage());
        }
    }
}
