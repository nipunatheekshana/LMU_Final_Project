<?php

namespace Modules\Selling\Http\Controllers;

use App\Http\common\commonFeatures;
use App\Http\common\nameingSeries;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Entities\Bank;
use Modules\Accounting\Entities\BankAccount;
use Modules\Accounting\Entities\Invoice;
use Modules\Mnu\Entities\PackingBox;
use Modules\Mnu\Entities\PackingListHeader;
use Modules\Selling\Entities\CustomerOrder;
use Modules\Settings\Entities\Company;
use Modules\Settings\Entities\Currency;
use Modules\Settings\Entities\Term;

class SalesInvoiceController extends Controller
{
    use commonFeatures, nameingSeries;
    public function loadCurrency()
    {
        try {
            $Currency = Currency::where('enabled', true)->get();
            return $this->responseBody(true, "loadCurrency", "Found", $Currency);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrency", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadShippingTerms()
    {
        try {
            $Term = Term::where('enabled', true)->where('type', 2)->select('id', 'title')->get();
            return $this->responseBody(true, "loadShippingTerms", "Found", $Term);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadShippingTerms", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadPls()
    {
        try {
            $PackingListHeader =  DB::table('mnu_packing_list_hd')
                ->join('selling_customers', 'selling_customers.id', '=', 'mnu_packing_list_hd.cus_id')
                ->join('crm_addresses', 'crm_addresses.id', '=', 'mnu_packing_list_hd.notify_id')
                ->join('selling_customer_order', 'selling_customer_order.id', '=', 'mnu_packing_list_hd.order_id')
                ->select([
                    'mnu_packing_list_hd.pl_number',
                    'mnu_packing_list_hd.pl_date',
                    'selling_customers.CusName as Customer',
                    'crm_addresses.AddressTitle as notify',
                    'selling_customer_order.order_number',
                    'selling_customer_order.customer_po_no',
                    'mnu_packing_list_hd.awb_no',
                    'mnu_packing_list_hd.id'
                ])
                ->get();
            return $this->responseBody(true, "loadPls", "Found", $PackingListHeader);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPls", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadExplDetails($id)
    {
        try {
            $PackingListHeader =  DB::table('mnu_packing_list_hd')
                ->join('selling_customers', 'selling_customers.id', '=', 'mnu_packing_list_hd.cus_id')
                ->join('crm_addresses', 'crm_addresses.id', '=', 'mnu_packing_list_hd.notify_id')
                ->join('selling_customer_order', 'selling_customer_order.id', '=', 'mnu_packing_list_hd.order_id')
                ->select([
                    'mnu_packing_list_hd.pl_number',
                    'mnu_packing_list_hd.pl_date',
                    'selling_customer_order.order_number',
                    'selling_customer_order.order_date',
                    'selling_customers.CusName as Customer',
                    'crm_addresses.AddressTitle as notify',
                ])
                ->where('mnu_packing_list_hd.id', $id)
                ->first();

            $boxes = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->where('mnu_packing_box_hd.pl_id', (int)$id)
                ->select([
                    'inventory_items.item_name',
                    DB::raw('COUNT(*) AS qty'),
                    DB::raw("SUM(mnu_packing_box_hd.box_gross_weight ) AS box_gross_weight"),
                    DB::raw("SUM(mnu_packing_box_hd.box_net_weight ) AS box_net_weight"),
                ])
                ->groupBy('mnu_packing_box_hd.prod_id')
                ->get();
            return $this->responseBody(true, "loadPls", "Found", ['PackingListHeader' => $PackingListHeader, 'boxes' => $boxes]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPls", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function AddPl($ExpPlId)
    {
        try {
            $PackingListHeader =  DB::table('mnu_packing_list_hd')
                ->join('selling_customers', 'selling_customers.id', '=', 'mnu_packing_list_hd.cus_id')
                ->join('crm_addresses', 'crm_addresses.id', '=', 'mnu_packing_list_hd.notify_id')
                ->join('selling_customer_order', 'selling_customer_order.id', '=', 'mnu_packing_list_hd.order_id')
                ->join('inventory_destinations', 'inventory_destinations.id', '=', 'mnu_packing_list_hd.destination_id')
                ->select([
                    'mnu_packing_list_hd.pl_number',
                    'mnu_packing_list_hd.pl_date',
                    'mnu_packing_list_hd.pl_number',
                    'mnu_packing_list_hd.ws_id',
                    'mnu_packing_list_hd.awb_no',
                    'mnu_packing_list_hd.flight_no',
                    'mnu_packing_list_hd.flight_date',
                    'mnu_packing_list_hd.shipment_no',
                    'mnu_packing_list_hd.consignee_add1',
                    'mnu_packing_list_hd.consignee_add2',
                    'mnu_packing_list_hd.consignee_city_towm',
                    'mnu_packing_list_hd.consignee_postal_code',
                    'mnu_packing_list_hd.consignee_country',
                    'mnu_packing_list_hd.notify_add1',
                    'mnu_packing_list_hd.notify_add2',
                    'mnu_packing_list_hd.notify_city_towm',
                    'mnu_packing_list_hd.notify_country',
                    'mnu_packing_list_hd.notify_postal_code',
                    'mnu_packing_list_hd.grn_nos_list',
                    'mnu_packing_list_hd.batch_nos_list',

                    'inventory_destinations.name as Destinatination_name',

                    'selling_customer_order.order_number',
                    'selling_customer_order.order_date',
                    'selling_customer_order.customer_po_no',

                    'selling_customers.CusName as Customer',
                    'crm_addresses.AddressTitle as notify',
                ])
                ->where('mnu_packing_list_hd.id', $ExpPlId)
                ->first();

            // $boxes = DB::table('mnu_packing_box_hd')
            //     ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
            //     ->where('mnu_packing_box_hd.pl_id', (int)$ExpPlId)
            //     ->select([
            //         'mnu_packing_box_hd.prod_id',
            //         'mnu_packing_box_hd.id',
            //         'mnu_packing_box_hd.pl_id',
            //         'inventory_items.item_name',
            //         'inventory_items.Item_Code',
            //         DB::raw('COUNT(mnu_packing_box_hd.id) AS qty'),
            //         DB::raw("SUM(mnu_packing_box_hd.box_gross_weight ) AS box_gross_weight"),
            //         DB::raw("SUM(mnu_packing_box_hd.box_net_weight ) AS box_net_weight"),
            //     ])
            //     ->groupBy('mnu_packing_box_hd.prod_id')
            //     ->get();
            $boxes = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->where('mnu_packing_box_hd.pl_id', (int)$ExpPlId)
                ->select([
                    'mnu_packing_box_hd.prod_id',
                    'mnu_packing_box_hd.id',
                    'mnu_packing_box_hd.pl_id',
                    'inventory_items.item_name',
                    'inventory_items.Item_Code',
                    'mnu_packing_box_hd.box_no',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.unit_rate_invoice_currency',

                ])
                ->get();
            $currancyId = Company::where('id', Auth::user()->company_id)->first('currency_id')->currency_id;
            $defaultCurr = DB::table('accounting_exchange_rate')
                ->leftJoin('settings_currencies', 'settings_currencies.id', '=', 'accounting_exchange_rate.currency')
                ->where('accounting_exchange_rate.company_id', Auth::user()->company_id)
                ->where('accounting_exchange_rate.date', Carbon::today()->format('Y-m-d'))
                ->where('accounting_exchange_rate.currency', (int)$currancyId)
                ->select('accounting_exchange_rate.exchange_rate', 'settings_currencies.currency_code')
                ->first();


            return $this->responseBody(true, "AddPl", "Found", ['PackingListHeader' => $PackingListHeader, 'boxes' => $boxes, 'defaultCurr' => $defaultCurr]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "AddPl", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadPaymentTerms()
    {
        try {
            $Term = Term::where('enabled', true)->where('type', 1)->select('id', 'title', 'description')->get();
            return $this->responseBody(true, "loadPaymentTerms", "Found", $Term);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadPaymentTerms", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadBaseCurrency($currencyId)
    {
        try {
            $ExchangeRate = DB::table('accounting_exchange_rate')
                ->join('settings_currencies', 'settings_currencies.id', '=', 'accounting_exchange_rate.currency')
                ->where('accounting_exchange_rate.company_id', Auth::user()->company_id)
                ->where('accounting_exchange_rate.currency', (int)$currencyId)
                ->where('accounting_exchange_rate.date', Carbon::today()->format('Y-m-d'))
                ->select('accounting_exchange_rate.exchange_rate', 'settings_currencies.currency_code')
                ->first();

            if ($ExchangeRate) {
                return $this->responseBody(true, "loadBaseCurrency", "found", $ExchangeRate);
            } else {
                return $this->responseBody(false, "loadBaseCurrency", "motFound", $ExchangeRate);
            }
        } catch (Exception $exception) {
            return $this->responseBody(false, "loadBaseCurrency", "loadCurrancy", $exception->getMessage());
        }
    }
    public function loadBankAccount()
    {
        try {
            $BankAccount = BankAccount::where('company', Auth::user()->company_id)->select('id', 'account_title')->get();
            return $this->responseBody(true, "loadBankAccount", "Found", $BankAccount);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBankAccount", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadBankAccountDetails($AccountId)
    {
        try {
            $BankAccount = DB::table('accounting_bank_accounts')
                ->join('accounting_banks', 'accounting_banks.id', '=', 'accounting_bank_accounts.bank')
                ->where('accounting_bank_accounts.id', $AccountId)
                ->select(
                    'accounting_banks.bank_name',
                    'accounting_bank_accounts.branch',
                    'accounting_bank_accounts.account_name',
                    'accounting_bank_accounts.account_number',
                    'accounting_bank_accounts.swift_code',
                )
                ->first();
            return $this->responseBody(true, "loadBankAccountDetails", "Found", $BankAccount);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBankAccountDetails", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadBank()
    {
        try {
            $Bank = Bank::select('id', 'bank_name')->get();
            return $this->responseBody(true, "loadBank", "Found", $Bank);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadBank", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function save(Request $request)
    {
        try {
            $invoice = new Invoice();
            $invoice->inv_no = $this->nameSeris('Invoice');
            $invoice->inv_date = $request->invoice_date;
            $invoice->order_id = CustomerOrder::where('order_number', $request->order_number)->first('id')->id;
            $invoice->order_number = $request->order_number;
            $invoice->cus_po_number = $request->po_number;
            $invoice->awb_no = $request->awb_no;
            $invoice->inv_comment = $request->inv_comment;
            $invoice->pl_id = $request->pl_id;
            $invoice->inv_status = 0; //
            $invoice->currency_id = $request->currency;
            $invoice->exchange_rate = $request->baseCurrRate;
            $invoice->flight_date = $request->flight_date;
            $invoice->flight_numbers = $request->flight_no;
            $invoice->consignee_name = $request->Customer;
            $invoice->consignee_add_line1 = $request->consignee_add1;
            $invoice->consignee_add_line2 = $request->consignee_add2;
            $invoice->consignee_add_line3 = $request->consignee_city_towm;
            $invoice->consignee_add_line4 = $request->consignee_postal_code;
            $invoice->consignee_add_line5 = $request->consignee_country;
            $invoice->notify_name = $request->notify;
            $invoice->notify_address_line1 = $request->notify_add1;
            $invoice->notify_address_line2 = $request->notify_add2;
            $invoice->notify_address_line3 = $request->notify_city_towm;
            $invoice->notify_address_line4 = $request->notify_postal_code;
            $invoice->notify_address_line5 = $request->notify_country;
            // $invoice->sales_contact_person = $request->data;
            // $invoice->sales_contact_number = $request->data;
            $invoice->shipment_number = $request->shipment_no;
            $invoice->destination = $request->Destinatination_name;
            // $invoice->destination_port = $request->data;
            $invoice->inv_term = $request->shipping_term;
            $invoice->inv_gross_value = $request->grandtotal;
            $invoice->net_weight_kg = $request->totNetWeight;
            $invoice->freight_rate = $request->freightVal;
            $invoice->freight_rate_type = $request->freight_type;
            // $invoice->freight_rate_lbs = $request->data;
            // $invoice->freight_rate_kg = $request->data;
            $invoice->freight_value = $request->freightTot;
            // $invoice->net_weight_lbs = $request->data;
            $invoice->discount_type = $request->discountType;
            $invoice->discount_rate = $request->discountVal;
            $invoice->discount_amount = $request->discountTot;
            $invoice->net_value = $request->totPriice;
            $invoice->payment_term = $request->payment_term;
            // $invoice->is_no_bank_details = $request->data;
            $invoice->bank_name = $request->bank_name;
            $invoice->bank_branch_name = $request->branch;
            $invoice->bank_account_id = $request->bank_account;
            $invoice->bank_account_name = $request->account_name;
            $invoice->bank_account_number = $request->account_number;
            $invoice->swift_code = $request->swift_code;
            $invoice->corresponding_bank = $request->bank;
            // $invoice->nature_of_product = $request->data;
            // $invoice->country_of_origin = $request->data;
            $invoice->list_of_batch_nos = $request->batch_nos_list;
            $invoice->list_of_gen_nos = $request->grn_nos_list;
            // $invoice->fao_zone = $request->data;
            // $invoice->fda_number = $request->data;
            // $invoice->eu_text = $request->data;
            // $invoice->tot_freight_value = $request->data;
            // $invoice->tot_handling_charges = $request->data;
            // $invoice->tot_other_cost = $request->data;
            // $invoice->tot_rm_cost = $request->data;
            // $invoice->tot_pm_cost = $request->data;
            // $invoice->is_processed = $request->data;
            // $invoice->processed_date_time = $request->data;
            // $invoice->processed_user_id = $request->data;
            // $invoice->is_posted = $request->data;
            // $invoice->posted_date_time = $request->data;
            // $invoice->poster_user_id = $request->data;
            // $invoice->is_printed = $request->data;
            // $invoice->is_disburment_processed = $request->data;
            $save = $invoice->save();
            if ($save) {
                foreach ($request->boxes as $box) {
                    $box = json_decode($box);
                    PackingBox::where('id', $box->id)
                        ->update([
                            'is_invoiced' => true,
                            'inv_id' => $invoice->id,
                            'unit_rate_local' => (int)$invoice->id * (int)$request->baseCurrRate,
                            'unit_rate_invoice_currency' => $box->unitPrice,
                        ]);
                }
                PackingListHeader::where('id', $request->pl_id)
                    ->update([
                        'is_invoiced'=>true,
                        'invoice_id'=>$invoice->id,
                        'invoice_number'=>$invoice->inv_no
                    ]);
            }




            return $this->responseBody(true, "save", "Found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function update(Request $request)
    {
        try {
            $invoice =  Invoice::find($request->id);
            $invoice->inv_no = $this->nameSeris('Invoice');
            $invoice->inv_date = $request->invoice_date;
            $invoice->order_number = $request->order_number;
            $invoice->cus_po_number = $request->po_number;
            $invoice->awb_no = $request->awb_no;
            $invoice->inv_comment = $request->inv_comment;
            $invoice->pl_id = $request->pl_id;
            $invoice->inv_status = 0; //
            $invoice->currency_id = $request->currency;
            $invoice->exchange_rate = $request->baseCurrRate;
            $invoice->flight_date = $request->flight_date;
            $invoice->flight_numbers = $request->flight_no;
            $invoice->consignee_name = $request->Customer;
            $invoice->consignee_add_line1 = $request->consignee_add1;
            $invoice->consignee_add_line2 = $request->consignee_add2;
            $invoice->consignee_add_line3 = $request->consignee_city_towm;
            $invoice->consignee_add_line4 = $request->consignee_postal_code;
            $invoice->consignee_add_line5 = $request->consignee_country;
            $invoice->notify_name = $request->notify;
            $invoice->notify_address_line1 = $request->notify_add1;
            $invoice->notify_address_line2 = $request->notify_add2;
            $invoice->notify_address_line3 = $request->notify_city_towm;
            $invoice->notify_address_line4 = $request->notify_postal_code;
            $invoice->notify_address_line5 = $request->notify_country;
            // $invoice->sales_contact_person = $request->data;
            // $invoice->sales_contact_number = $request->data;
            $invoice->shipment_number = $request->shipment_no;
            $invoice->destination = $request->Destinatination_name;
            // $invoice->destination_port = $request->data;
            $invoice->inv_term = $request->shipping_term;
            $invoice->inv_gross_value = $request->grandtotal;
            $invoice->net_weight_kg = $request->totNetWeight;
            $invoice->freight_rate = $request->freightVal;
            $invoice->freight_rate_type = $request->freight_type;
            // $invoice->freight_rate_lbs = $request->data;
            // $invoice->freight_rate_kg = $request->data;
            $invoice->freight_value = $request->freightTot;
            // $invoice->net_weight_lbs = $request->data;
            $invoice->discount_type = $request->discountType;
            $invoice->discount_rate = $request->discountVal;
            $invoice->discount_amount = $request->discountTot;
            $invoice->net_value = $request->totPriice;
            $invoice->payment_term = $request->payment_term;
            // $invoice->is_no_bank_details = $request->data;
            $invoice->bank_name = $request->bank_name;
            $invoice->bank_branch_name = $request->branch;
            $invoice->bank_account_id = $request->bank_account;
            $invoice->bank_account_name = $request->account_name;
            $invoice->bank_account_number = $request->account_number;
            $invoice->swift_code = $request->swift_code;
            $invoice->corresponding_bank = $request->bank;
            // $invoice->nature_of_product = $request->data;
            // $invoice->country_of_origin = $request->data;
            $invoice->list_of_batch_nos = $request->batch_nos_list;
            $invoice->list_of_gen_nos = $request->grn_nos_list;
            // $invoice->fao_zone = $request->data;
            // $invoice->fda_number = $request->data;
            // $invoice->eu_text = $request->data;
            // $invoice->tot_freight_value = $request->data;
            // $invoice->tot_handling_charges = $request->data;
            // $invoice->tot_other_cost = $request->data;
            // $invoice->tot_rm_cost = $request->data;
            // $invoice->tot_pm_cost = $request->data;
            // $invoice->is_processed = $request->data;
            // $invoice->processed_date_time = $request->data;
            // $invoice->processed_user_id = $request->data;
            // $invoice->is_posted = $request->data;
            // $invoice->posted_date_time = $request->data;
            // $invoice->poster_user_id = $request->data;
            // $invoice->is_printed = $request->data;
            // $invoice->is_disburment_processed = $request->data;
            $save = $invoice->save();
            if ($save) {
                foreach ($request->boxes as $box) {
                    $box = json_decode($box);
                    PackingBox::where('id', $box->id)
                        ->update([
                            'is_invoiced' => true,
                            'inv_id' => $invoice->id,
                            'unit_rate_local' => (int)$invoice->id * (int)$request->baseCurrRate,
                            'unit_rate_invoice_currency' => $box->unitPrice,
                        ]);
                }
                PackingListHeader::where('id', $request->pl_id)
                ->update([
                    'is_invoiced'=>true,
                    'invoice_id'=>$invoice->id,
                    'invoice_number'=>$invoice->inv_no
                ]);
            }




            return $this->responseBody(true, "save", "Found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "save", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadInvoices()
    {
        try {
            $invoice = DB::table('accounting_invoice_header')
                ->leftJoin('mnu_packing_list_hd', 'mnu_packing_list_hd.id', '=', 'accounting_invoice_header.pl_id')
                ->select([
                    'accounting_invoice_header.id',
                    'accounting_invoice_header.inv_no',
                    'accounting_invoice_header.inv_date',
                    'accounting_invoice_header.consignee_name',
                    'accounting_invoice_header.notify_name',
                    'mnu_packing_list_hd.pl_number',
                    'accounting_invoice_header.shipment_number',
                    'accounting_invoice_header.order_number',
                    'accounting_invoice_header.awb_no',
                    'accounting_invoice_header.flight_numbers',
                    'accounting_invoice_header.inv_gross_value',
                    'accounting_invoice_header.freight_value',
                    'accounting_invoice_header.discount_amount',
                    'accounting_invoice_header.net_value',
                    'accounting_invoice_header.is_processed',
                    'accounting_invoice_header.tot_other_cost',
                    'accounting_invoice_header.is_disburment_processed',
                ])
                ->get();
            return $this->responseBody(true, "loadInvoices", "Found", $invoice);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadInvoices", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function loadInvoice($id)
    {
        try {
            $selectArr = [
                'accounting_invoice_header.id',
                'accounting_invoice_header.inv_no',
                'accounting_invoice_header.inv_date',
                'accounting_invoice_header.order_id',
                'accounting_invoice_header.order_number',
                'accounting_invoice_header.cus_po_number',
                'accounting_invoice_header.awb_no',
                'accounting_invoice_header.inv_comment',
                'accounting_invoice_header.pl_id',
                'mnu_packing_list_hd.pl_number',
                'mnu_packing_list_hd.ws_id',
                'accounting_invoice_header.inv_status',
                'accounting_invoice_header.currency_id',
                'accounting_invoice_header.exchange_rate',
                'accounting_invoice_header.flight_date',
                'accounting_invoice_header.flight_numbers',
                'accounting_invoice_header.consignee_name',
                'accounting_invoice_header.consignee_add_line1',
                'accounting_invoice_header.consignee_add_line2',
                'accounting_invoice_header.consignee_add_line3',
                'accounting_invoice_header.consignee_add_line4',
                'accounting_invoice_header.consignee_add_line5',
                'accounting_invoice_header.notify_name',
                'accounting_invoice_header.notify_address_line1',
                'accounting_invoice_header.notify_address_line2',
                'accounting_invoice_header.notify_address_line3',
                'accounting_invoice_header.notify_address_line4',
                'accounting_invoice_header.notify_address_line5',
                'accounting_invoice_header.shipment_number',
                'accounting_invoice_header.destination',
                'accounting_invoice_header.inv_term',
                'accounting_invoice_header.inv_gross_value',
                'accounting_invoice_header.net_weight_kg',
                'accounting_invoice_header.freight_rate',
                'accounting_invoice_header.freight_rate_type',
                'accounting_invoice_header.freight_value',
                'accounting_invoice_header.discount_type',
                'accounting_invoice_header.discount_rate',
                'accounting_invoice_header.discount_amount',
                'accounting_invoice_header.net_value',
                'accounting_invoice_header.payment_term',
                'accounting_invoice_header.bank_name',
                'accounting_invoice_header.bank_branch_name',
                'accounting_invoice_header.bank_account_id',
                'accounting_invoice_header.bank_account_name',
                'accounting_invoice_header.bank_account_number',
                'accounting_invoice_header.swift_code',
                'accounting_invoice_header.corresponding_bank',
                'accounting_invoice_header.list_of_batch_nos',
                'accounting_invoice_header.list_of_gen_nos',
            ];
            $invoice = DB::table('accounting_invoice_header')
                ->leftJoin('mnu_packing_list_hd', 'mnu_packing_list_hd.id', '=', 'accounting_invoice_header.pl_id')
                ->where('accounting_invoice_header.id', $id)
                ->select($selectArr)
                ->first();
            $boxes = DB::table('mnu_packing_box_hd')
                ->join('inventory_items', 'inventory_items.id', '=', 'mnu_packing_box_hd.prod_id')
                ->where('inv_id', $id)
                ->where('is_invoiced', true)
                ->select([
                    'mnu_packing_box_hd.prod_id',
                    'mnu_packing_box_hd.id',
                    'mnu_packing_box_hd.pl_id',
                    'inventory_items.item_name',
                    'inventory_items.Item_Code',
                    'mnu_packing_box_hd.box_no',
                    'mnu_packing_box_hd.box_gross_weight',
                    'mnu_packing_box_hd.box_net_weight',
                    'mnu_packing_box_hd.unit_rate_invoice_currency',
                ])
                ->get();
            return $this->responseBody(true, "loadInvoices", "Found", ['invoice' => $invoice, 'boxes' => $boxes]);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadInvoices", "Something Went Wrong", $ex->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $Bank = Invoice::where('id', $id)->delete();
            PackingBox::where('inv_id',  $id)
                ->update([
                    'is_invoiced' => false,
                    'inv_id' => null,
                    'unit_rate_local' => null,
                    'unit_rate_invoice_currency' => null,
                    'modified_by' => Auth::user()->id
                ]);
            return $this->responseBody(true, "delete", "Found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "delete", "Something Went Wrong", $ex->getMessage());
        }
    }
}
