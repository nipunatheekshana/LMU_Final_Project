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
use Modules\Sf\Entities\Landingsite;

class LandingsiteMasterController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'LandingSiteName' => ['required'],
            'Longitude' => ['required'],
            'Latitude' => ['required'],
            'LongLat' => ['required'],
            'LandingSiteImage' => ['image', 'max:1024'],
        ]);
        try {
            $Landingsite = new Landingsite();
            $Landingsite->LandingSiteName = $request->LandingSiteName;
            $Landingsite->Longitude = $request->Longitude;
            $Landingsite->Latitude = $request->Latitude;
            $Landingsite->LongLat = $request->LongLat;
            $Landingsite->countryCode = $request->countryCode;
            $Landingsite->list_index = $request->list_index;
            $Landingsite->enabled = $request->has('enabled');
            $Landingsite->created_by = Auth::user()->id;
            $save = $Landingsite->save();

            if ($request->has('LandingSiteImage') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('LandingSiteImage')));

                $image = Landingsite::find($Landingsite->id);
                $image->LandingSiteImage = explode('/', $path)[2];
                $image->save();
            }



            if ($save) {
                return $this->responseBody(true, "save", "Landingsite saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'LandingSiteName' => ['required'],
            'Longitude' => ['required'],
            'Latitude' => ['required'],
            'LongLat' => ['required'],
            'LandingSiteImage' => ['image', 'max:1024'],
        ]);
        try {
            $Landingsite = Landingsite::find($request->id);
            $Landingsite->LandingSiteName = $request->LandingSiteName;
            $Landingsite->Longitude = $request->Longitude;
            $Landingsite->Latitude = $request->Latitude;
            $Landingsite->LongLat = $request->LongLat;
            $Landingsite->countryCode = $request->countryCode;
            $Landingsite->list_index = $request->list_index;
            $Landingsite->enabled = $request->has('enabled');
            $Landingsite->modified_by = Auth::user()->id;
            $save = $Landingsite->save();

            if ($request->has('LandingSiteImage') && $save) {
                $path = Storage::putFile('private/images', new File($request->file('LandingSiteImage')));

                $image = Landingsite::find($Landingsite->id);
                $image->LandingSiteImage = explode('/', $path)[2];
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Landingsite saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadLandingsites()
    {
        try {
            $Landingsite = Landingsite::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadLandingsites", "found", $Landingsite);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadLandingsites", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $this->DeleteImage($id);
            Landingsite::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Landingsite Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadlandingsiteMaster($id)
    {
        try {
            $Landingsite = Landingsite::where('id', $id)->first();
            return $this->responseBody(true, "User", "Landingsite ", $Landingsite);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCountries()
    {
        try {
            $Country = Country::Where('enabled', true)->get();

            return $this->responseBody(true, "loadCountries", "found", $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCountries", "Something went wrong", $ex->getMessage());
        }
    }
    public function DeleteImage($id)
    {
        try {
            $image = Landingsite::where('id', $id)->first()->LandingSiteImage;
            $path = 'app/private/images/' . $image;

            if (file_exists(storage_path($path))) {
                unlink(storage_path($path));
                $Landingsite = Landingsite::find($id);
                $Landingsite->LandingSiteImage = '';
                $Landingsite->modified_by = Auth::user()->id;
                $save = $Landingsite->save();
            }


            return $this->responseBody(true, "User", "Landingsite Image Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
}
