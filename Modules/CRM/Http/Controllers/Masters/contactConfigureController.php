<?php

namespace Modules\CRM\Http\Controllers\Masters;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Buying\Entities\SupplierContact;
use Modules\CRM\Entities\Contact;
use Modules\CRM\Entities\CustomerContact;
use Modules\HRM\Entities\Gender;
use Modules\HRM\Entities\Salutation;

class contactConfigureController extends Controller
{
    use commonFeatures;

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'FirstName' => ['required'],
            'Designation' => ['required'],
            'LastName' => ['required'],

        ]);
        try {
            $Contact = new Contact();
            $Contact->FirstName = $request->FirstName;
            $Contact->MiddleName = $request->MiddleName;
            $Contact->LastName = $request->LastName;
            $Contact->Salutation = $request->Salutation;
            $Contact->Designation = $request->Designation;
            $Contact->Gender = $request->Gender;
            $Contact->PrimaryAddress = $request->PrimaryAddress;
            $Contact->list_index = $request->list_index;
            $Contact->enabled = $request->has('enabled');
            $Contact->created_by = Auth::user()->id;
            $save = $Contact->save();

            $url='/crm/contact_list';


            //when contact is added from customerMasterconfigureController
            // session data is set from customerMasterconfigureController -> SetSessionAndReturnUrl
            if(session()->has('customer_id')){
                $CustomerContact=new CustomerContact();
                $CustomerContact->ContactID=$Contact->id;
                $CustomerContact->CusCode=session('customer_id');
                $CustomerContact->save();

                $url=session('parent_url');

                session()->pull('customer_id');
                session()->pull('parent_url');

            }
             //when contact is added from supplierConfigureController
            // session data is set from supplierConfigureController -> SetSessionAndReturnUrl
            if(session()->has('supplier_id')){
                $SupplierContact=new SupplierContact();
                $SupplierContact->ContactID=$Contact->id;
                $SupplierContact->SupID=session('supplier_id');
                $SupplierContact->save();

                $url=session('parent_url');

                session()->pull('supplier_id');
                session()->pull('parent_url');

            }



            if ($save) {
                return $this->responseBody(true, "save", "Contact saved", $url);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'FirstName' => ['required'],
            'Designation' => ['required'],
            'LastName' => ['required'],
        ]);
        try {
            $Contact = Contact::find($request->id);
            $Contact->FirstName = $request->FirstName;
            $Contact->MiddleName = $request->MiddleName;
            $Contact->LastName = $request->LastName;
            $Contact->Salutation = $request->Salutation;
            $Contact->Designation = $request->Designation;
            $Contact->Gender = $request->Gender;
            $Contact->PrimaryAddress = $request->PrimaryAddress;
            $Contact->list_index = $request->list_index;
            $Contact->enabled = $request->has('enabled');
            $Contact->modified_by = Auth::user()->id;
            $save = $Contact->save();

            $url='/crm/contact_list';

            //when contact is updated from customerMasterconfigureController
            // session data is set from customerMasterconfigureController -> SetSessionAndReturnUrl
            if(session()->has('customer_id')){
                $url=session('parent_url');
                session()->pull('customer_id');
                session()->pull('parent_url');

            }
             //when contact is updated from supplierConfigureController
            // session data is set from supplierConfigureController -> SetSessionAndReturnUrl
            if(session()->has('supplier_id')){
                $url=session('parent_url');
                session()->pull('supplier_id');
                session()->pull('parent_url');

            }
            if ($save) {
                return $this->responseBody(true, "save", "Contact saved", $url);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "save", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadcontacts()
    {
        try {
            $Contact = Contact::orderBy('id','ASC')
            ->get();

            return $this->responseBody(true, "loadContacts", "found", $Contact);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadContacts", "Something went wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Contact = Contact::where('id', $id)->delete();
            return $this->responseBody(true, "User", "Contact Deleted", null);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }
    public function view($id)
    {
        try {
            $Contact = Contact::where('id', $id)->first();
            return $this->responseBody(true, "User", "Contact ", $Contact);
        } catch (Exception $exception) {
            return $this->responseBody(false, "User", "Something went wrong", $exception->getMessage());
        }
    }

    public function loadContact($id)
    {
        try {
            $Contact = Contact::where('id', $id)->first();
            return $this->responseBody(true, "loadContact", "found", $Contact);
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadContact", "error", $exception->getMessage());
        }
    }
    public function loadSaluation()
    {
        try {
            $Salutation = Salutation::where('enabled', true)->get();

            return $this->responseBody(true, "loadSaluation", '', $Salutation);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadSaluation", '', $ex->getMessage());
        }
    }
    public function loadGender()
    {
        try {
            $Gender = Gender::where('enabled', true)->get();

            return $this->responseBody(true, "loadGender", '', $Gender);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadGender", '', $ex->getMessage());
        }
    }

}
