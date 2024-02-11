<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Sf\Entities\FishGrade;
use Modules\Sf\Entities\Fishspecies;

class FishGradesMasterController extends Controller
{
    use commonFeatures;
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'QualityFishGrade' => ['required'],
            'PayFishGrade' => ['required'],
            'fish_species' => ['required'],

        ]);
        if(FishGrade::where('fish_species',$request->fish_species)->where('QFishGrade',$request->QFishGrade)->exists()){
            $this->validationError('QFishGrade','Fish grade Excist');
        }
        try {
            $Fish_grade = new FishGrade();
            $Fish_grade->QFishGrade = $request->QualityFishGrade;
            $Fish_grade->PayFishGrade = $request->PayFishGrade;
            $Fish_grade->fish_species = $request->fish_species;
            $Fish_grade->list_index = $request->list_index;
            $Fish_grade->enabled = $request->has('enabled');
            $Fish_grade->HNG_GRADE = $request->has('HNG_GRADE');
            $Fish_grade->created_by = Auth::user()->id;
            $save = $Fish_grade->save();



            if ($save) {
                return $this->responseBody(true, "save", "Fish grade saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'QualityFishGrade' => ['required'],
            'PayFishGrade' => ['required'],
            'fish_species' => ['required'],

        ]);
        $data=FishGrade::where('fish_species',$request->fish_species)->where('QFishGrade',$request->QFishGrade);

        if($data->exists()){
            if($data->first()->id!=$request->id){
                $this->validationError('QFishGrade','Fish grade Excist');
            }
        }
        try {
            $Fish_grade = FishGrade::find($request->id);
            $Fish_grade->QFishGrade = $request->QualityFishGrade;
            $Fish_grade->PayFishGrade = $request->PayFishGrade;
            $Fish_grade->fish_species = $request->fish_species;
            $Fish_grade->list_index = $request->list_index;
            $Fish_grade->enabled = $request->has('enabled');
            $Fish_grade->HNG_GRADE = $request->has('HNG_GRADE');
            $Fish_grade->modified_by = Auth::user()->id;
            $save = $Fish_grade->save();

            if ($save) {
                return $this->responseBody(true, "save", "Fish grade saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadFishGrades()
    {
        try {
            // $Fish_grade = FishGrade::orderBy('id','ASC')
            // ->get();
            $Fish_grade = DB::table('sf_fish_grades')
                        ->leftJoin('sf_fish_species','sf_fish_species.id','=','sf_fish_grades.fish_species')
                        ->select('sf_fish_grades.*','sf_fish_species.FishName')
                        ->orderBy('id','ASC')
                        ->get();

            return $this->responseBody(true, "loadFishGrades", "found", $Fish_grade);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishGrades", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $FishGrade = FishGrade::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Fish Grade Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Fish Grade Already in Use", $exception->getMessage());
        }
    }
    public function loadFishGrade($id)
    {
        try {
            $FishGrade = FishGrade::where('id', $id)->first();
            return $this->responseBody(true, "User", "loadFishGrade ", $FishGrade);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $FishGrade = FishGrade::where('id', $id)->first();
            return $this->responseBody(true, "view", "loadFishGrade ", $FishGrade);
        } catch (Exception $exception) {
            return $this->responseBody(false, "view", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadFishSpecies()
    {
        try {
            $Fishspecies = Fishspecies::where('enabled',true)
            ->get();

            return $this->responseBody(true, "loadFishSpecies", "found", $Fishspecies);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishSpecies", "Something went wrong", $ex->getMessage());
        }
    }
    public function loadRelatedGrades($id)
    {
        try {

            // $Fish_grade = FishGrade::orderBy('id','ASC')
            // ->get();
            $Fish_grade =DB::table('sf_fish_grades')
                        ->leftJoin('sf_fish_species','sf_fish_species.id','=','sf_fish_grades.fish_species')
                        ->where('sf_fish_grades.fish_species',$id)
                        ->select('sf_fish_grades.*','sf_fish_species.FishName')
                        ->orderBy('id','ASC')
                        ->get();

            return $this->responseBody(true, "loadFishGrades", "found", $Fish_grade);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadFishGrades", "Something went wrong", $ex->getMessage());
        }
    }
}
