<?php

namespace Modules\CRM\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Buying\Entities\SupplierAddress;
use Modules\CRM\Entities\Address;
use Modules\CRM\Entities\AddressType;
use Modules\CRM\Entities\CustomerAddress;
use Modules\Settings\Entities\Country;

class AddressConfigureController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'AddressTitle' => ['required'],
            'emailAddress' => ['nullable', 'email'],
            // 'Phone' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            // 'Phone' => ['nullable', 'regex:/(01)[0-9]{9}/'],
            'Phone' => ['nullable', 'regex:/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/'],

            'Fax' => ['nullable', 'regex:/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/'],
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
            $Address->created_by = Auth::user()->id;
            $save = $Address->save();


            $url='/crm/address_list';

            //when address is added from customerMasterconfigureController
            // session data is set from customerMasterconfigureController -> SetSessionAndReturnUrl
            if(session()->has('customer_id')){
                $CustomerAddress=new CustomerAddress();
                $CustomerAddress->AddressID=$Address->id;
                $CustomerAddress->CusCode=session('customer_id');
                $CustomerAddress->save();

                $url=session('parent_url');

                session()->pull('customer_id');
                session()->pull('parent_url');

            }
            //when address is added from supplierConfigureController
            // session data is set from supplierConfigureController -> SetSessionAndReturnUrl
            if(session()->has('supplier_id')){
                $SupplierAddress=new SupplierAddress();
                $SupplierAddress->AddressID=$Address->id;
                $SupplierAddress->SupID=session('supplier_id');
                $SupplierAddress->save();

                $url=session('parent_url');

                session()->pull('supplier_id');
                session()->pull('parent_url');

            }



            if ($save) {
                return $this->responseBody(true, "save", "Address saved", $url);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'AddressTitle' => ['required'],
            'emailAddress' => ['nullable', 'email'],
            // 'Phone' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            // 'Phone' => ['nullable', 'regex:/(01)[0-9]{9}/'],
            'Phone' => ['nullable', 'regex:/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/'],

            'Fax' => ['nullable', 'regex:/((?:\+|00)[17](?: |\-)?|(?:\+|00)[1-9]\d{0,2}(?: |\-)?|(?:\+|00)1\-\d{3}(?: |\-)?)?(0\d|\([0-9]{3}\)|[1-9]{0,3})(?:((?: |\-)[0-9]{2}){4}|((?:[0-9]{2}){4})|((?: |\-)[0-9]{3}(?: |\-)[0-9]{4})|([0-9]{7}))/'],
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

            $Address->PreferedBillingAddress = $request->has('PreferedBillingAddress');
            $Address->PreferedShippingAddress = $request->has('PreferedShippingAddress');
            $Address->enabled = $request->has('enabled');
            $Address->modified_by = Auth::user()->id;
            $save = $Address->save();

            $url='/crm/address_list';

            //when address is updated from customerMasterconfigureController
            // session data is set from customerMasterconfigureController -> SetSessionAndReturnUrl
            if(session()->has('customer_id')){
                $url=session('parent_url');
                session()->pull('customer_id');
                session()->pull('parent_url');

            }

            //when address is updated from supplierConfigureController
            // session data is set from supplierConfigureController -> SetSessionAndReturnUrl
            if(session()->has('supplier_id')){
                $url=session('parent_url');
                session()->pull('supplier_id');
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
            $Address = Address::where('is_notify', FALSE)
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
