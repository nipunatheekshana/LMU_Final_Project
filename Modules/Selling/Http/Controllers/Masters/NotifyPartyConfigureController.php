<?php

namespace Modules\Selling\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\CRM\Entities\Address;
use Modules\CRM\Entities\AddressType;
use Modules\CRM\Entities\CustomerAddress;
use Modules\Selling\Entities\CustomerNotifyparty;
use Modules\Settings\Entities\Country;

class NotifyPartyConfigureController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'AddressTitle' => ['required'],
            'emailAddress' => ['nullable', 'email'],
            'Phone' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'Fax' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
        ]);
        try {
            $Address = new Address();
            $Address->AddressTitle = $request->AddressTitle;
            $Address->emailAddress = $request->emailAddress;
            $Address->Phone = $request->Phone;
            $Address->Fax = $request->Fax;
            $Address->Longitude = $request->Longitude;
            $Address->LongLat = $request->LongLat;
            $Address->Latitude = $request->Latitude;
            $Address->AddressType = $request->AddressType;
            $Address->Addressline1 = $request->Addressline1;
            $Address->Addressline2 = $request->Addressline2;
            $Address->CityTown = $request->CityTown;
            $Address->Country = $request->Country;
            $Address->PostalCode = $request->PostalCode;
            $Address->list_index = $request->list_index;
            $Address->PreferedBillingAddress = $request->has('PreferedBillingAddress');
            $Address->PreferedShippingAddress = $request->has('PreferedShippingAddress');
            $Address->enabled = $request->has('enabled');
            $Address->is_notify = true;
            $Address->created_by = Auth::user()->id;
            $save = $Address->save();


            $url='/selling/notifyparty_list';

            //when notify is added from customerMasterconfigureController
            // session data is set from customerMasterconfigureController -> SetSessionAndReturnUrl
            if(session()->has('customer_id')){
                $CustomerNotifyparty=new CustomerNotifyparty();
                $CustomerNotifyparty->notifypartyID=$Address->id;
                $CustomerNotifyparty->CusCode=session('customer_id');
                $CustomerNotifyparty->save();

                $url=session('parent_url');

                session()->pull('customer_id');
                session()->pull('parent_url');

            }




            if ($save) {
                return $this->responseBody(true, "save", "Address Saved", $url);
            }
        } catch (Exception $exception) {
                return $this->responseBody(true, "save", "Address Saved", $url);
                return $this->responseBody(false, "save", "Something Went Wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'AddressTitle' => ['required'],
            'emailAddress' => ['nullable', 'email'],
            'Phone' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'Fax' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
        ]);
        try {
            $Address = Address::find($request->id);
            $Address->AddressTitle = $request->AddressTitle;
            $Address->emailAddress = $request->emailAddress;
            $Address->Phone = $request->Phone;
            $Address->Fax = $request->Fax;
            $Address->Longitude = $request->Longitude;
            $Address->LongLat = $request->LongLat;
            $Address->Latitude = $request->Latitude;
            $Address->AddressType = $request->AddressType;
            $Address->Addressline1 = $request->Addressline1;
            $Address->Addressline2 = $request->Addressline2;
            $Address->CityTown = $request->CityTown;
            $Address->Country = $request->Country;
            $Address->PostalCode = $request->PostalCode;
            $Address->list_index = $request->list_index;
            $Address->is_notify = true;
            $Address->PreferedBillingAddress = $request->has('PreferedBillingAddress');
            $Address->PreferedShippingAddress = $request->has('PreferedShippingAddress');
            $Address->enabled = $request->has('enabled');
            $Address->modified_by = Auth::user()->id;
            $save = $Address->save();

            $url='/selling/notifyparty_list';

            //when address is updated from customerMasterconfigureController
            // session data is set from customerMasterconfigureController -> SetSessionAndReturnUrl
            if(session()->has('customer_id')){
                $url=session('parent_url');
                session()->pull('customer_id');
                session()->pull('parent_url');

            }

            if ($save) {
                return $this->responseBody(true, "save", "Address saved", $url);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadAddresses()
    {
        try {
            $Address = Address::where('is_notify', TRUE)
            ->orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadAddresss", "found", $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAddresss", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Address = Address::where('id', $id)->delete();
            $CustomerAddress = CustomerAddress::where('AddressID',$id)->delete();
            return $this->responseBody(true, "User", "Address Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Address = Address::where('id', $id)->first();
            return $this->responseBody(true, "User", "Address ", $Address);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCountries()
    {
        try {
            $Country = Country::where('enabled', true)->get();

            return $this->responseBody(true, "loadcountries", '', $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadcountries", '', $ex->getMessage());
        }
    }
    public function loadAddressType()
    {
        try {
            $Address_type = AddressType::all();

            return $this->responseBody(true, "loadAddressType", '', $Address_type);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAddressType", '', $ex->getMessage());
        }
    }
    public function loadAddress($id)
    {
        try {
            $Address = Address::where('id', $id)->first();
            return $this->responseBody(true, "loadAddress", "found", $Address);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadAddress", "error", $exception->getMessage());
        }
    }

}
