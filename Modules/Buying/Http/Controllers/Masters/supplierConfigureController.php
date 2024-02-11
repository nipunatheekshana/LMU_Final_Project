<?php

namespace Modules\Buying\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Buying\Entities\Supplier;
use Modules\Buying\Entities\SupplierAddress;
use Modules\Buying\Entities\SupplierContact;
use Modules\Buying\Entities\SupplierGroup;
use Modules\CRM\Entities\Contact;
use Modules\CRM\Entities\CustomerAddress;
use Modules\CRM\Entities\CustomerContact;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\Currency;

class supplierConfigureController extends Controller
{
    use  commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_name' => ['required'],
            // 'supplier_group' => ['required'],
            'website' => ['nullable', 'url'],
            'image' => ['nullable','image', 'max:1024'],
        ]);
        try {
            $Supplier = new Supplier();
            $Supplier->supplier_name = $request->supplier_name;
            $Supplier->country = $request->country;
            $Supplier->default_bank_account = $request->default_bank_account;
            $Supplier->tax_id = $request->tax_id;
            $Supplier->tax_category = $request->tax_category;
            $Supplier->tax_withholding_category = $request->tax_withholding_category;
            $Supplier->represents_company = $request->represents_company;
            $Supplier->supplier_group = $request->supplier_group;
            $Supplier->supplier_type = $request->supplier_type;
            $Supplier->pan = $request->pan;
            $Supplier->language = $request->language;
            $Supplier->default_currency = $request->default_currency;
            $Supplier->default_price_list = $request->default_price_list;
            $Supplier->payment_terms = $request->payment_terms;
            $Supplier->hold_type = $request->hold_type;
            $Supplier->release_date = $request->release_date;
            $Supplier->website = $request->website;
            $Supplier->supplier_details = $request->supplier_details;
            $Supplier->_comments = $request->_comments;
            $Supplier->list_index = $request->list_index;
            $Supplier->is_transporter = $request->has('is_transporter');
            $Supplier->is_internal_supplier = $request->has('is_internal_supplier');
            $Supplier->allow_purchase_invoice_creation_without_purchase_order = $request->has('allow_purchase_invoice_creation_without_purchase_order');
            $Supplier->allow_purchase_invoice_creation_without_purchase_receipt = $request->has('allow_purchase_invoice_creation_without_purchase_receipt');
            $Supplier->on_hold = $request->has('on_hold');
            $Supplier->enabled = $request->has('enabled');
            $Supplier->created_by = Auth::user()->id;
            $save = $Supplier->save();

            if ($request->has('image') && $save) {

                $const = '-supplier_image';
                $imagename = $Supplier->id . $const; //new image name
                $guessExtension = $request->file('image')->guessExtension(); //file extention
                $file = $request->file('image')->storeAs('supplier_images/' . $Supplier->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/supplier_images/' . $Supplier->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Supplier::find($Supplier->id);
                $image->image = $url;
                $image->save();
            }


            if ($save) {
                return $this->responseBody(true, "save", "Supplier saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'supplier_name' => ['required'],
            'website' => ['nullable', 'url'],
        ]);
        try {
            $Supplier = Supplier::find($request->id);
            $Supplier->supplier_name = $request->supplier_name;
            $Supplier->country = $request->country;
            $Supplier->default_bank_account = $request->default_bank_account;
            $Supplier->tax_id = $request->tax_id;
            $Supplier->tax_category = $request->tax_category;
            $Supplier->tax_withholding_category = $request->tax_withholding_category;
            $Supplier->represents_company = $request->represents_company;
            $Supplier->supplier_group = $request->supplier_group;
            $Supplier->supplier_type = $request->supplier_type;
            $Supplier->pan = $request->pan;
            $Supplier->language = $request->language;
            $Supplier->default_currency = $request->default_currency;
            $Supplier->default_price_list = $request->default_price_list;
            $Supplier->payment_terms = $request->payment_terms;
            $Supplier->hold_type = $request->hold_type;
            $Supplier->release_date = $request->release_date;
            $Supplier->website = $request->website;
            $Supplier->supplier_details = $request->supplier_details;
            $Supplier->_comments = $request->_comments;
            $Supplier->list_index = $request->list_index;
            $Supplier->is_transporter = $request->has('is_transporter');
            $Supplier->is_internal_supplier = $request->has('is_internal_supplier');
            $Supplier->allow_purchase_invoice_creation_without_purchase_order = $request->has('allow_purchase_invoice_creation_without_purchase_order');
            $Supplier->allow_purchase_invoice_creation_without_purchase_receipt = $request->has('allow_purchase_invoice_creation_without_purchase_receipt');
            $Supplier->on_hold = $request->has('on_hold');
            $Supplier->enabled = $request->has('enabled');
            $Supplier->modified_by = Auth::user()->id;
            $save = $Supplier->save();

            if ($request->has('image') && $save) {

                $const = '-supplier_image';
                $imagename = $Supplier->id . $const; //new image name
                $guessExtension = $request->file('image')->guessExtension(); //file extention
                $file = $request->file('image')->storeAs('supplier_images/' . $Supplier->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/supplier_images/' . $Supplier->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Supplier::find($Supplier->id);
                $image->image = $url;
                $image->save();
            }


            if ($save) {
                return $this->responseBody(true, "save", "Supplier saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadSuppliers()
    {
        try {
            $Supplier = Supplier::orderBy('id', 'ASC')->get();

            return $this->responseBody(true, "loadSuppliers", "found", $Supplier);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSuppliers", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = Supplier::where('id', $id)->first()->image;
            if (file_exists($image)) {
                unlink($image);
            }
            $Supplier = Supplier::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Supplier Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Supplier = Supplier::where('id', $id)->first();
            return $this->responseBody(true, "User", "Supplier ", $Supplier);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadSupplier($id)
    {
        try {
            $Supplier = Supplier::where('id', $id)->first();
            return $this->responseBody(true, "loadSupplier", "found", $Supplier);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadSupplier", "error", $exception->getMessage());
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
    public function loadSupplierGroup()
    {
        try {
            $SupplierGroup = SupplierGroup::where('enabled', true)->get();

            return $this->responseBody(true, "loadSupplierGroup", '', $SupplierGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSupplierGroup", '', $ex->getMessage());
        }
    }
    public function loadCurrencies()
    {
        try {
            $Currency = Currency::where('enabled', true)->get();

            return $this->responseBody(true, "loadCurrencies", '', $Currency);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrencies", '', $ex->getMessage());
        }
    }
    public function SetSessionAndReturnUrl($id)
    {
        try {
            session([
                'supplier_id' => $id,
                'parent_url' => '/buying/supplier_configure?' . $id
            ]);
            return $this->responseBody(true, "SetSessionAndReturnUrl", '', '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "SetSessionAndReturnUrl", 'something went wrong', $ex->getMessage());
        }
    }
    public function loadSupplierAddress($id)
    {
        try {
            $Address_arr = [];

            $Address_id = SupplierAddress::where('SupID', $id)->select('AddressID')->get();
            foreach ($Address_id as $key) {
                // $Address = Address::where('id', $key->AddressID)->get();
                $Address = DB::table('crm_addresses')
                    ->leftJoin('crm_address_types', 'crm_addresses.AddressType', '=', 'crm_address_types.id')
                    ->leftJoin('settings_countries', 'crm_addresses.Country', '=', 'settings_countries.id')
                    ->select('crm_addresses.*', 'crm_address_types.AddressType as typeName', 'settings_countries.country_name')
                    ->where('crm_addresses.id', $key->AddressID)
                    ->get();

                array_push($Address_arr, $Address);
            }


            return $this->responseBody(true, "loadSupplierAddress", '', $Address_arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSupplierAddress", 'something went wrong', $ex->getMessage());
        }
    }
    public function loadSupplierContact($id)
    {
        try {
            $Contact_arr = [];

            $Contact_id = SupplierContact::where('SupID', $id)->select('ContactID')->get();
            foreach ($Contact_id as $key) {
                // $Address = Address::where('id', $key->AddressID)->get();
                $Contact = DB::table('crm_contacts')
                    ->leftJoin('hrm_genders', 'crm_contacts.Gender', '=', 'hrm_genders.id')
                    ->leftJoin('hrm_salutations', 'crm_contacts.Salutation', '=', 'hrm_salutations.id')
                    ->select('crm_contacts.*', 'hrm_genders.gender as genderName', 'hrm_salutations.salutation as saluationNAme')
                    ->where('crm_contacts.id', $key->ContactID)
                    ->get();

                array_push($Contact_arr, $Contact);
            }


            return $this->responseBody(true, "loadSupplierContact", '', $Contact_arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSupplierContact", 'something went wrong', $ex->getMessage());
        }
    }
    public function loadAddress()
    {
        try {
            $Address = DB::table('crm_customeraddress')
                ->leftJoin('crm_addresses', 'crm_addresses.id', '=', 'crm_customeraddress.CusCode')
                ->leftJoin('crm_address_types', 'crm_addresses.AddressType', '=', 'crm_address_types.id')
                // ->whereNot('crm_customeraddress.CusCode', $id)
                ->select('crm_addresses.id', 'crm_addresses.AddressTitle', 'crm_address_types.AddressType as typeName',)
                ->get();

            return $this->responseBody(true, "loadAddress", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadAddress", '', $ex->getMessage());
        }
    }

    public function loadContacts()
    {
        try {
            $Address = Contact::where('enabled', true)->select('FirstName', 'LastName', 'id')->get();

            return $this->responseBody(true, "loadContacts", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadContacts", '', $ex->getMessage());
        }
    }
    public function link(Request $request)
    {
        switch ($request->type) {
            case 'Address':
                $data = CustomerAddress::where('AddressID', $request->linkId)->where('CusCode', $request->cusId)->exists();
                if ($data) {
                    $this->validationError('AddressID', 'This address alredy linked to this Customer');
                }
                break;

            case 'contact':
                $data = CustomerContact::where('ContactID', $request->linkId)->where('CusCode', $request->cusId)->exists();
                if ($data) {
                    $this->validationError('AddressID', 'This Contact alredy linked to this Customer');
                }
                break;

            default:
                # code...
                break;
        }
        try {
            switch ($request->type) {
                case 'Address':
                    $SupplierAddress=new SupplierAddress();
                    $SupplierAddress->AddressID=$request->linkId;
                    $SupplierAddress->SupID= $request->SupoId;
                    $SupplierAddress->save();
                    break;
                case 'contact':
                    $SupplierContact=new SupplierContact();
                    $SupplierContact->ContactID=$request->linkId;
                    $SupplierContact->SupID= $request->SupoId;
                    $SupplierContact->save();
                    break;
                default:
                    # code...
                    break;
            }

            // if ($save) {
            return $this->responseBody(true, "save", "Customer Saved", 'data saved');
            // }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something Went Wrong", $exception->getMessage());
        }
    }
}
