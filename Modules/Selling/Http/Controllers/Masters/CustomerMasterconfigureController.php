<?php

namespace Modules\Selling\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\PriceList;
use Modules\CRM\Entities\Address;
use Modules\CRM\Entities\Contact;
use Modules\CRM\Entities\CustomerAddress;
use Modules\CRM\Entities\CustomerContact;
use Modules\Selling\Entities\Customer;
use Modules\Selling\Entities\CustomerGroup;
use Modules\Selling\Entities\CustomerNotifyparty;
use Modules\Selling\Entities\CustomerType;
use Modules\Settings\Entities\Country;
use Modules\Settings\Entities\Currency;
use Modules\Settings\Entities\Language;

class CustomerMasterconfigureController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'CusCode' => ['required'],
            'CusName' => ['required'],
            'emailAddress' => ['nullable', 'email'],
            'MobileNo' => ['nullable', 'regex:/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/'],
            'logo' => ['nullable', 'image', 'max:1024'],

        ]);

        if (Customer::where('CusCode', $request->CusCode)->exists()) {
            $this->validationError('CusCode', 'Customer Code Exists');
        }

        if (Customer::where('CusName', $request->CusName)->exists()) {
            $this->validationError('CusName', 'Customer Name Exists');
        }

        try {
            $Customer = new Customer();
            $Customer->CusCode = $request->CusCode;
            $Customer->CusName = $request->CusName;
            $Customer->CusRegNo = $request->CusRegNo;
            $Customer->CusType = $request->CusType;
            $Customer->CusGroup = $request->CusGroup;
            $Customer->CusCountry = $request->CusCountry;
            $Customer->BillingCurrency = $request->BillingCurrency;
            $Customer->DefltLanguage = $request->DefltLanguage;
            $Customer->PrimaryContactPerson = $request->PrimaryContactPerson;
            $Customer->PrimaryContactAddress = $request->PrimaryContactAddress;
            $Customer->MobileNo = $request->MobileNo;
            $Customer->emailAddress = $request->emailAddress;
            $Customer->LicenceNo = $request->LicenceNo;
            $Customer->PriceList = $request->PriceList;
            $Customer->PrimaryBankAccount = $request->PrimaryBankAccount;
            $Customer->max_fish_age = $request->max_fish_age;
            $Customer->list_index = $request->list_index;
            $Customer->enabled = $request->has('enabled');
            $Customer->is_internal_customer = $request->has('is_internal_customer');
            $Customer->created_by = Auth::user()->id;
            $save = $Customer->save();

            if ($request->has('logo') && $save) {

                $const = '-Customer_logo';
                $imagename = $Customer->id . $const; //new image name
                $guessExtension = $request->file('logo')->guessExtension(); //file extention
                $file = $request->file('logo')->storeAs('Customer_images/' . $Customer->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/Customer_images/' . $Customer->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Customer::find($Customer->id);
                $image->logo = $url;
                $image->save();
            }



            if ($save) {
                return $this->responseBody(true, "save", "Customer Saved", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something Went Wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'CusCode' => ['required'],
            'CusName' => ['required'],
            'emailAddress' => ['nullable', 'email'],
            'MobileNo' => ['nullable', 'regex:/^(?:7|0|(?:\+94))[0-9]{9,10}$/'],
            'logo' => ['nullable', 'image', 'max:1024'],

        ]);
        try {
            $Customer = Customer::find($request->id);
            $Customer->CusCode = $request->CusCode;
            $Customer->CusName = $request->CusName;
            $Customer->CusRegNo = $request->CusRegNo;
            $Customer->CusType = $request->CusType;
            $Customer->CusGroup = $request->CusGroup;
            $Customer->CusCountry = $request->CusCountry;
            $Customer->BillingCurrency = $request->BillingCurrency;
            $Customer->DefltLanguage = $request->DefltLanguage;
            $Customer->PrimaryContactPerson = $request->PrimaryContactPerson;
            $Customer->PrimaryContactAddress = $request->PrimaryContactAddress;
            $Customer->MobileNo = $request->MobileNo;
            $Customer->emailAddress = $request->emailAddress;
            $Customer->LicenceNo = $request->LicenceNo;
            $Customer->PriceList = $request->PriceList;
            $Customer->PrimaryBankAccount = $request->PrimaryBankAccount;
            $Customer->max_fish_age = $request->max_fish_age;
            $Customer->list_index = $request->list_index;
            $Customer->enabled = $request->has('enabled');
            $Customer->is_internal_customer = $request->has('is_internal_customer');
            $Customer->modified_by = Auth::user()->id;
            $save = $Customer->save();

            if ($request->has('logo') && $save) {

                $const = '-Customer_logo';
                $imagename = $Customer->id . $const; //new image name
                $guessExtension = $request->file('logo')->guessExtension(); //file extention
                $file = $request->file('logo')->storeAs('Customer_images/' . $Customer->id, $imagename . '.' . $guessExtension, 'public_uploads');
                //build url for the image
                $const_url = 'uploads/Customer_images/' . $Customer->id . '/';
                $url = $const_url . $imagename . '.' . $guessExtension;

                $image = Customer::find($Customer->id);
                $image->logo = $url;
                $image->save();
            }

            if ($save) {
                return $this->responseBody(true, "save", "Customer Updated", 'data saved');
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something Went Wrong", $exception->getMessage());
        }
    }

    public function loadCustomers()
    {
        try {
            // $Customer = Customer::orderBy('id', 'ASC')
            //     ->get();
            $Customer = DB::table('selling_customers')
                ->leftJoin('settings_countries', 'settings_countries.id', '=', 'selling_customers.CusCountry')
                ->select('selling_customers.*', 'settings_countries.country_name')
                ->orderBy('id', 'ASC')
                ->get();

            return $this->responseBody(true, "loadCustomers", "found", $Customer);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomers", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $image = Customer::where('id', $id)->first()->logo;
            if (file_exists($image)) {
                unlink($image);
            }

            $Customer = Customer::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Customer Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Customer = Customer::where('id', $id)->first();
            return $this->responseBody(true, "User", "Customer ", $Customer);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function loadCustomerTypes()
    {
        try {
            $CustomerType = CustomerType::all();

            return $this->responseBody(true, "loadCustomerTypes", '', $CustomerType);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerTypes", '', $ex->getMessage());
        }
    }
    public function loadCustomerGroups()
    {
        try {
            $CustomerGroup = CustomerGroup::where('enabled', true)->get();

            return $this->responseBody(true, "loadCustomerGroups", '', $CustomerGroup);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerGroups", '', $ex->getMessage());
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
    public function loadCurrency()
    {
        try {
            $Country = Currency::where('enabled', true)->get();

            return $this->responseBody(true, "loadCurrency", '', $Country);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrency", '', $ex->getMessage());
        }
    }
    public function loadPriceList()
    {
        try {
            $PriceList = PriceList::where('enabled', true)->get();

            return $this->responseBody(true, "loadPriceList", '', $PriceList);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPriceList", '', $ex->getMessage());
        }
    }
    public function loadLanguage()
    {
        try {
            $Language = Language::where('enabled', true)->get();

            return $this->responseBody(true, "loadLanguage", '', $Language);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadLanguage", '', $ex->getMessage());
        }
    }
    public function loadContactPerson($cusId)
    {
        try {
            // $Contact = Contact::where('enabled',true)->get();
            $Contact = DB::table('crm_contacts')
                ->leftJoin('hrm_salutations', 'hrm_salutations.id', '=', 'crm_contacts.Salutation')
                ->leftJoin('crm_customercontact', 'crm_customercontact.ContactID', '=', 'crm_contacts.id')
                ->where('crm_customercontact.CusCode', $cusId)
                ->select('crm_contacts.*', 'hrm_salutations.salutation as saluwation_name')
                ->get();


            return $this->responseBody(true, "loadContactPerson", '', $Contact);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadContactPerson", '', $ex->getMessage());
        }
    }
    public function loadContactAddress($cusId)
    {
        try {
            // $Address = CustomerAddress::where('enabled',true)->where('CusCode',$cusId)->get();
            $Address = DB::table('crm_addresses')
                ->leftJoin('crm_customeraddress', 'crm_customeraddress.AddressID', '=', 'crm_addresses.id')
                ->where('crm_addresses.enabled', true)
                ->where('crm_customeraddress.CusCode', $cusId)
                ->select('crm_addresses.*')
                ->get();


            return $this->responseBody(true, "loadContactAddress", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadContactAddress", '', $ex->getMessage());
        }
    }
    public function loadCustomer($id)
    {
        try {
            $Customer = Customer::where('id', $id)->first();
            return $this->responseBody(true, "loadCustomer", "found", $Customer);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadCustomer", "error", $exception->getMessage());
        }
    }
    public function SetSessionAndReturnUrl($id)
    {
        try {
            session([
                'customer_id' => $id,
                'parent_url' => '/selling/customer_configure?' . $id
            ]);
            return $this->responseBody(true, "SetSessionAndReturnUrl", '', '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "SetSessionAndReturnUrl", 'something went wrong', $ex->getMessage());
        }
    }
    public function loadCustomerAddress($id)
    {
        try {
            $Address_arr = [];

            $Address_id = CustomerAddress::where('CusCode', $id)->select('AddressID')->get();
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


            return $this->responseBody(true, "loadCustomerAddress", '', $Address_arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerAddress", 'something went wrong', $ex->getMessage());
        }
    }

    public function loadCustomerContact($id)
    {
        try {
            $Contact_arr = [];

            $Contact_id = CustomerContact::where('CusCode', $id)->select('ContactID')->get();
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


            return $this->responseBody(true, "loadCustomerContact", '', $Contact_arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerContact", 'something went wrong', $ex->getMessage());
        }
    }
    public function loadCustomerNotify($id)
    {
        try {
            $Address_arr = [];

            $Address_id = CustomerNotifyparty::where('CusCode', $id)->select('notifypartyID')->get();
            foreach ($Address_id as $key) {
                // $Address = Address::where('id', $key->AddressID)->get();
                $Address = DB::table('crm_addresses')
                    ->leftJoin('crm_address_types', 'crm_addresses.AddressType', '=', 'crm_address_types.id')
                    ->leftJoin('settings_countries', 'crm_addresses.Country', '=', 'settings_countries.id')
                    ->select('crm_addresses.*', 'crm_address_types.AddressType as typeName', 'settings_countries.country_name')
                    ->where('crm_addresses.id', $key->notifypartyID)
                    ->get();

                array_push($Address_arr, $Address);
            }


            return $this->responseBody(true, "loadCustomerNotify", '', $Address_arr);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCustomerNotify", 'something went wrong', $ex->getMessage());
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
    public function loadNotify()
    {
        try {
            $Address = Address::where('is_notify', true)->where('enabled', true)->select('AddressTitle', 'id')->get();

            return $this->responseBody(true, "loadNotify", '', $Address);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadNotify", '', $ex->getMessage());
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
            case 'notify':
                $data = CustomerNotifyparty::where('notifypartyID', $request->linkId)->where('CusCode', $request->cusId)->exists();
                if ($data) {
                    $this->validationError('AddressID', 'This Notify alredy linked to this Customer');
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
                    $CustomerAddress = new CustomerAddress();
                    $CustomerAddress->AddressID = $request->linkId;
                    $CustomerAddress->CusCode = $request->cusId;
                    $CustomerAddress->save();
                    break;
                case 'notify':
                    $CustomerNotifyparty = new CustomerNotifyparty();
                    $CustomerNotifyparty->notifypartyID = $request->linkId;
                    $CustomerNotifyparty->CusCode = $request->cusId;
                    $CustomerNotifyparty->save();
                    break;
                case 'contact':
                    $CustomerContact = new CustomerContact();
                    $CustomerContact->ContactID = $request->linkId;
                    $CustomerContact->CusCode = $request->cusId;
                    $CustomerContact->save();
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
