<?php

namespace Modules\Settings\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Settings\Entities\BarcodeType;

class BarcodeTypesController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'barcodeType' => ['required'],
        ]);
        if (BarcodeType::where('barcodeType', $request->barcodeType)->exists()) {
            $this->validationError('barcodeType', 'Barcode Type Exists');
        }

        try {
            $BarcodeType = new BarcodeType();
            $BarcodeType->barcodeType = $request->barcodeType;
            $BarcodeType->category = $request->category;
            $BarcodeType->characterSet = $request->characterSet;
            $BarcodeType->length = $request->length;
            $BarcodeType->checksum = $request->checksum;
            $BarcodeType->notes = $request->notes;
            $BarcodeType->enabled = $request->has('enabled');
            $BarcodeType->created_by = Auth::user()->id;
            $save = $BarcodeType->save();

            if ($request->has('sampleImage') && $save) {

                $const = '-BarcodeSample_image';
                $imagename = $BarcodeType->id . $const; //new image name
                $guessExtension = $request->file('sampleImage')->guessExtension(); //file extention
                $file = $request->file('sampleImage')->storeAs('BarcodeSample_images/' . $BarcodeType->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/BarcodeSample_images/' . $BarcodeType->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = BarcodeType::find($BarcodeType->id);
                $image->sampleImage = $url;
                $image->save();
            }


            if ($save) {
                return $this->responseBody(true, "save", "BarcodeType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'barcodeType' => ['required'],
        ]);
        $data1 = BarcodeType::where('barcodeType', $request->barcodeType);
        if ($data1->exists()) {
            if ($data1->first()->id != $request->id) {
                $this->validationError('barcodeType', 'Barcode Type Exists');
            }
        }

        try {
            $BarcodeType = BarcodeType::find($request->id);
            $BarcodeType->barcodeType = $request->barcodeType;
            $BarcodeType->category = $request->category;
            $BarcodeType->characterSet = $request->characterSet;
            $BarcodeType->length = $request->length;
            $BarcodeType->checksum = $request->checksum;
            $BarcodeType->notes = $request->notes;
            $BarcodeType->enabled = $request->has('enabled');
            $BarcodeType->modified_by = Auth::user()->id;
            $save = $BarcodeType->save();


            if ($request->has('sampleImage') && $save) {

                $const = '-BarcodeSample_image';
                $imagename = $BarcodeType->id . $const; //new image name
                $guessExtension = $request->file('sampleImage')->guessExtension(); //file extention
                $file = $request->file('sampleImage')->storeAs('BarcodeSample_images/' . $BarcodeType->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/BarcodeSample_images/' . $BarcodeType->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = BarcodeType::find($BarcodeType->id);
                $image->sampleImage = $url;
                $image->save();
            }
            if ($save) {
                return $this->responseBody(true, "save", "BarcodeType saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBarcodeTypes()
    {
        try {
            $BarcodeType = BarcodeType::orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadBarcodeTypes", "found", $BarcodeType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBarcodeTypes", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = BarcodeType::where('id', $id)->first()->sampleImage;
            if (file_exists($image)) {
                unlink($image);
            }
            $BarcodeType = BarcodeType::where('id', $id)->delete();
            return $this->responseBody(true, "User", "BarcodeType Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadBarcodeType($id)
    {
        try {
            $BarcodeType = BarcodeType::where('id', $id)->first();
            return $this->responseBody(true, "loadBarcodeType", "found", $BarcodeType);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBarcodeType", "error", $exception->getMessage());
        }
    }
}
