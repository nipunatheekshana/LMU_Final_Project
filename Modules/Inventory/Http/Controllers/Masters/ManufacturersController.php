<?php

namespace Modules\Inventory\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Inventory\Entities\Manufacturer;
use Modules\Inventory\Entities\Manufacturers;
use Modules\Settings\Entities\Country;

class ManufacturersController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'website' => ['nullable','url'],
            'name' => ['required'],
        ]);
        try {
            $Manufacturers = new Manufacturer();
            $Manufacturers->name = $request->name;
            $Manufacturers->short_name = $request->short_name;
            $Manufacturers->website = $request->website;
            $Manufacturers->country = $request->country;
            $Manufacturers->notes = $request->notes;
            $Manufacturers->list_index = $request->list_index;
            $Manufacturers->enabled = $request->has('enabled');
            $Manufacturers->created_by = Auth::user()->id;
            $save = $Manufacturers->save();

            if ($request->has('logo') && $save) {

                $const = '-Manufacturer_image';
                $imagename = $Manufacturers->id . $const; //new image name
                $guessExtension = $request->file('logo')->guessExtension(); //file extention
                $file = $request->file('logo')->storeAs('Manufacturer_images/' . $Manufacturers->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/Manufacturer_images/' . $Manufacturers->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Manufacturer::find($Manufacturers->id);
                $image->logo = $url;
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Manufacturers saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'website' => ['nullable','url'],
        ]);
        try {
            $Manufacturers = Manufacturer::find($request->id);
            $Manufacturers->name = $request->name;
            $Manufacturers->short_name = $request->short_name;
            $Manufacturers->website = $request->website;
            $Manufacturers->country = $request->country;
            $Manufacturers->notes = $request->notes;
            $Manufacturers->list_index = $request->list_index;
            $Manufacturers->enabled = $request->has('enabled');
            $Manufacturers->modified_by = Auth::user()->id;
            $save = $Manufacturers->save();

            if ($request->has('logo') && $save) {

                $const = '-Manufacturer_image';
                $imagename = $Manufacturers->id . $const; //new image name
                $guessExtension = $request->file('logo')->guessExtension(); //file extention
                $file = $request->file('logo')->storeAs('Manufacturer_images/' . $Manufacturers->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/Manufacturer_images/' . $Manufacturers->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Manufacturer::find($Manufacturers->id);
                $image->logo = $url;
                $image->save();
            }
            if ($save) {
                return $this->responseBody(true, "save", "Manufacturers saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadManufacturers()
    {
        try {
            $Manufacturers = Manufacturer::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadManufacturerss", "found", $Manufacturers);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadManufacturerss", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = Manufacturer::where('id', $id)->first()->logo;
            if (file_exists($image)) {
                unlink($image);
            }
            $Manufacturers = Manufacturer::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Manufacturers Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadManufacturer($id)
    {
        try {
            $Manufacturers = Manufacturer::where('id', $id)->first();
            return $this->responseBody(true, "loadManufacturers", "found", $Manufacturers);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadManufacturers", "error", $exception->getMessage());
        }
    }
    public function loadCountries()
    {
        try {
            $Country = Country::where('enabled',true)->get();

            return $this->responseBody(true, "loadCountries", '', $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCountries", '', $ex->getMessage());
        }
    }

}
