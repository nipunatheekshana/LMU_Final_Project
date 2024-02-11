<?php

namespace Modules\Settings\Http\Controllers\API;

use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function bulkupdatefields(Request $request)
    {
        DB::beginTransaction();

        try {


            $requestData = $request->json()->all();

            foreach ($requestData as $tableData) {

                $tableName = $tableData['table'];

                foreach ($tableData['id_data'] as $data) {
                    $arr = [];
                    foreach ($data['data'] as $val) {
                        $arr[$val['field']] = $val['value'];
                    }
                    DB::table($tableName)->where('id', $data['id'])->update($arr);
                }
            }
            DB::commit();
        } catch (Exception $ex) {
            DB::rollback();
            return response([
                'status' => 'Error',
                'code' => 500,
                'message' => $ex->getMessage(),
            ], 500);
        }
    }
}
