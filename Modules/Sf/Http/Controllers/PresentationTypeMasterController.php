<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Sf\Entities\Fishspecies;
use Modules\Sf\Entities\PresentationType;

class PresentationTypeMasterController extends Controller
{
    use commonFeatures;
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'PrsntCode' => ['required'],
            'PrsntName' => ['required'],
            'fish_species' => ['required'],

        ]);
        if (PresentationType::where('PrsntCode', $request->PrsntCode)->where('fish_species', $request->fish_species)->exists()) {
            $this->validationError('PrsntCode', 'PrsntCode Excist');
        }
        if (PresentationType::where('PrsntName', $request->PrsntName)->where('fish_species', $request->fish_species)->exists()) {
            $this->validationError('PrsntName', 'PrsntName Excist');
        }

        try {
            $PresentationType = new PresentationType();
            $PresentationType->PrsntCode = $request->PrsntCode;
            $PresentationType->PrsntName = $request->PrsntName;
            $PresentationType->fish_species = $request->fish_species;
            $PresentationType->list_index = $request->list_index;
            $PresentationType->enabled = $request->has('enabled');
            $PresentationType->created_by = Auth::user()->id;
            $save = $PresentationType->save();



            if ($save) {
                return $this->responseBody(true, "save", "PresentationType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'PrsntCode' => ['required'],
            'PrsntName' => ['required'],
            'fish_species' => ['required'],
        ]);
        $data1 = PresentationType::where('PrsntCode', $request->PrsntCode)->where('fish_species', $request->fish_species);
        $data2 = PresentationType::where('PrsntName', $request->PrsntName)->where('fish_species', $request->fish_species);

        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('PrsntCode', 'PrsntCode Excist');
            }
        }
        if ($data2->exists()) {
            if ($data2->first()->id != $request->id) {
                $this->validationError('PrsntName', 'PrsntName Excist');
            }
        }

        try {
            $PresentationType = PresentationType::find($request->id);
            $PresentationType->PrsntCode = $request->PrsntCode;
            $PresentationType->PrsntName = $request->PrsntName;
            $PresentationType->fish_species = $request->fish_species;
            $PresentationType->list_index = $request->list_index;
            $PresentationType->enabled = $request->has('enabled');
            $PresentationType->modified_by = Auth::user()->id;
            $save = $PresentationType->save();

            if ($save) {
                return $this->responseBody(true, "save", "PresentationType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadPresentationTypes()
    {
        try {
            // $PresentationType = PresentationType::orderBy('id', 'ASC')
            //     ->get();
            $PresentationType = DB::table('sf_presentation_type')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'sf_presentation_type.fish_species')
                ->select('sf_presentation_type.*', 'sf_fish_species.FishName')
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadPresentationTypes", "found", $PresentationType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPresentationTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $PresentationType = PresentationType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "PresentationType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadPresentationType($id)
    {
        try {
            $PresentationType = PresentationType::where('id', $id)->first();
            return $this->responseBody(true, "User", "PresentationType ", $PresentationType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadFishSpecies()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled', true)
                ->get();

            return $this->responseBody(true, "loadFishSpecies", "found", $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecies", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadRelatedPresentationTypes($id)
    {
        try {
            // $PresentationType = PresentationType::orderBy('id', 'ASC')
            //     ->get();
            $PresentationType = DB::table('sf_presentation_type')
                ->leftJoin('sf_fish_species', 'sf_fish_species.id', '=', 'sf_presentation_type.fish_species')
                ->where('sf_presentation_type.fish_species',$id)
                ->select('sf_presentation_type.*', 'sf_fish_species.FishName')
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadPresentationTypes", "found", $PresentationType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPresentationTypes", "Something went wrong", $ex->getMessage());
        }
    }
}
