<?php

namespace Modules\Sf\Http\Controllers;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Settings\Entities\Country;
use Modules\Sf\Entities\Boat;
use Modules\Sf\Entities\BoatCategory;
use Modules\Sf\Entities\BoatHoldType;

class BoatController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'BoatName' => ['required'],

        ]);
        if ($request->has('BoatHold') && $request->HoldReason == 'null') {
            $this->validationError('HoldReason', 'Hold Reason Neded');
        }
        if (Boat::where('BoatCode',  $request->BoatCode)->exists()) {
            $this->validationError('BoatCode', 'Boat Code exists');
        }
        if (Boat::where('BoatRegNo',  $request->BoatRegNo)->exists()) {
            $this->validationError('BoatRegNo', 'BoatRegNo exists');
        }
        try {
            $Boat = new Boat();
            $Boat->BoatID = $request->BoatID;
            $Boat->BoatRegNo = $request->BoatRegNo;
            $Boat->BoatCode = $request->BoatCode;
            $Boat->RegCountry = $request->RegCountry;
            $Boat->BoatName = $request->BoatName;
            $Boat->BoatShortName = $request->BoatShortName;
            $Boat->Call_Sign = $request->Call_Sign;
            $Boat->BoatCategory = $request->BoatCategory;
            $Boat->BoatLength = $request->BoatLength;
            $Boat->EngineCapacity = $request->EngineCapacity;
            $Boat->BoatWeight = $request->BoatWeight;
            $Boat->LicenseNo = $request->LicenseNo;
            $Boat->LicenseExpDate = $request->LicenseExpDate;
            $Boat->OwnerName = $request->OwnerName;
            $Boat->SkipperName = $request->SkipperName;
            $Boat->NoofTanks = $request->NoofTanks;
            $Boat->NoofCrew = $request->NoofCrew;
            $Boat->HoldReason = $request->HoldReason;
            $Boat->list_index = $request->list_index;
            $Boat->LicenseRequired = $request->has('LicenseRequired');
            $Boat->LogSheetRequired = $request->has('LogSheetRequired');
            $Boat->BoatHold = $request->has('BoatHold');
            $Boat->enabled = $request->has('enabled');
            $Boat->created_by = Auth::user()->id;
            $save = $Boat->save();

            $file = null;
            if ($request->has('boatImg') && $save) {
                $file = $request->file('boatImg');
                $this->UpdateImage($file, $Boat->id, 'boat');
            }
            if ($request->has('skipperSign') && $save) {
                $file = $request->file('skipperSign');
                $this->UpdateImage($file, $Boat->id, 'signature');
            }
            if ($request->has('licenceImage') && $save) {
                $file = $request->file('licenceImage');
                $this->UpdateImage($file, $Boat->id, 'licence');
            }


            if ($save) {
                return $this->responseBody(true, "save", "Boat saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'BoatName' => ['required'],
        ]);
        $data = Boat::where('BoatCode',  $request->BoatCode);
        $data1 = Boat::where('BoatRegNo',  $request->BoatRegNo);

        if ($data->exists()) {
            if ($data->first()->id != $request->id) {
                $this->validationError('BoatCode', 'Boat Code exists');
            }
        }
        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('BoatRegNo', 'BoatRegNo exists');
            }
        }
        if ($request->has('BoatHold') && $request->HoldReason == 'null') {
            $this->validationError('HoldReason', 'Hold Reason Neded');
        }
        try {
            $Boat = Boat::find($request->id);
            $Boat->BoatID = $request->BoatID;
            $Boat->BoatRegNo = $request->BoatRegNo;
            $Boat->BoatCode = $request->BoatCode;
            $Boat->RegCountry = $request->RegCountry;
            $Boat->BoatName = $request->BoatName;
            $Boat->BoatShortName = $request->BoatShortName;
            $Boat->Call_Sign = $request->Call_Sign;
            $Boat->BoatCategory = $request->BoatCategory;
            $Boat->BoatLength = $request->BoatLength;
            $Boat->EngineCapacity = $request->EngineCapacity;
            $Boat->BoatWeight = $request->BoatWeight;
            $Boat->LicenseNo = $request->LicenseNo;
            $Boat->LicenseExpDate = $request->LicenseExpDate;
            $Boat->OwnerName = $request->OwnerName;
            $Boat->SkipperName = $request->SkipperName;
            $Boat->NoofTanks = $request->NoofTanks;
            $Boat->NoofCrew = $request->NoofCrew;
            $Boat->HoldReason = $request->HoldReason;
            $Boat->list_index = $request->list_index;
            $Boat->LicenseRequired = $request->has('LicenseRequired');
            $Boat->LogSheetRequired = $request->has('LogSheetRequired');
            $Boat->BoatHold = $request->has('BoatHold');
            $Boat->enabled = $request->has('enabled');

            $Boat->modified_by = Auth::user()->id;
            $save = $Boat->save();

            $file = null;
            if ($request->has('skipperSign') && $save) {
                $file = $request->file('skipperSign');
                $this->UpdateImage($file, $Boat->id, 'signature');
            }
            if ($request->has('boatImg') && $save) {
                $file = $request->file('boatImg');
                $this->UpdateImage($file, $Boat->id, 'boat');
            }

            if ($request->has('licenceImage') && $save) {
                $file = $request->file('licenceImage');
                $this->UpdateImage($file, $Boat->id, 'licence');
            }

            if ($save) {
                return $this->responseBody(true, "save", "Boat saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    function UpdateImage($image, $id, $type)
    {
        try {
            $path = Storage::putFile('private/images', new File($image));

            $img = Boat::find($id);
            switch ($type) {
                case 'boat':
                    $img->boatImg = explode('/', $path)[2];
                    break;
                case 'signature':
                    $img->skipperSign = explode('/', $path)[2];
                    break;
                case 'licence':
                    $img->licenceImage = explode('/', $path)[2];
                    break;
            }
            $img->save();
        } catch (Exception $Ex) {
            return $Ex->getMessage();
        }
    }

    public function loadboats()
    {
        try {
            $Boat = Boat::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadboats", "found", $Boat);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadboats", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $this->deleteImage($id, 'boat');
            $this->deleteImage($id, 'signature');
            $this->deleteImage($id, 'licence');
            Boat::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Boat Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Boat = Boat::where('id', $id)->first();
            return $this->responseBody(true, "User", "Boat ", $Boat);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadBoat($id)
    {
        try {
            $Boat = Boat::where('id', $id)->first();
            return $this->responseBody(true, "loadBoat", "found", $Boat);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBoat", "error", $exception->getMessage());
        }
    }
    public function loadCountries()
    {
        try {
            $Country = Country::where('enabled', true)->get();

            return $this->responseBody(true, "loadCountries", '', $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCountries", '', $ex->getMessage());
        }
    }
    public function loadBoatCategories()
    {
        try {
            $BoatCategory = BoatCategory::where('enabled', true)->get();

            return $this->responseBody(true, "loadBoatCategories", '', $BoatCategory);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBoatCategories", '', $ex->getMessage());
        }
    }
    public function loadBoatHoldReason()
    {
        try {
            $BoatHoldType = BoatHoldType::where('enabled', true)->get();

            return $this->responseBody(true, "loadBoatHoldReason", '', $BoatHoldType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBoatHoldReason", '', $ex->getMessage());
        }
    }
    public function deleteImage($id, $img)
    {
        try {
            $image = Boat::where('id', $id)->first();
            $colum = '';
            switch ($img) {
                case 'boat':
                    $colum = 'boatImg';
                    break;
                case 'signature':
                    $colum = 'skipperSign';
                    break;
                case 'licence':
                    $colum = 'licenceImage';
                    break;
            }
            $path = 'app/private/images/' . $image->$colum;

            if (file_exists(storage_path($path))) {
                unlink(storage_path($path));
                Boat::where('id', $id)
                    ->update([$colum => null]);
            }
            return $this->responseBody(true, "deleteImage", "Landingsite Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "deleteImage", "Something went wrong", $exception->getMessage());
        }
    }
}
