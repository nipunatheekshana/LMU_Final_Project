<?php

namespace App\Http\common;

use App\Models\Activity_log;
use App\Models\Activity_log_field;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait commonFeatures
{
    /**
     * responseBody
     * This is used to create response.
     * @param success This is the paramter require boolean
     * @param name This is the paramter require ui table name
     * @param message This is the paramter require message content
     * @param result This is the paramter require result as some of data to return client
     * @return Json This returns as response.
     */
    private function responseBody($success, $name, $message, $result)
    {
        $body = [
            "success" => $success,
            "message" => $message,
            "name" => $name,
            "result" => $result
        ];
        return $body;
    }

    private function isBool($args)
    {
        if ($args == 'true') {
            return true;
        }
        return false;
    }

    // private function log_activity($formName, $dataId, $values)
    // {
    //     try {
    //         $activityLog = new Activity_log();
    //         $activityLog->user_id = Auth::user()->id;
    //         $activityLog->form_name = $formName;
    //         $activityLog->data_id = $dataId;
    //         $save = $activityLog->save();
    //         if ($values != null && $save) {
    //             foreach ($values as $value) {
    //                 if ($value['field'] != 'updated_at') {
    //                     $activityLogField = new Activity_log_field();
    //                     $activityLogField->activity_id = $activityLog->id;
    //                     $activityLogField->new_value = $value['change'];
    //                     $activityLogField->field_name = $value['field'];
    //                     $activityLogField->save();
    //                 }
    //             }
    //         }



    //         return $this->responseBody(true, "log_activity", "Activity logged", '');
    //     } catch (Exception $ex) {

    //         return $this->responseBody(false, "log_activity", "Something went Wrong", $ex->getMessage());
    //     }
    // }
    // private function getChangedArray($model)
    // {
    //     try {
    //         if (!$model->wasRecentlyCreated) {
    //             $changes = [];
    //             foreach ($model->getChanges() as $key => $value) {
    //                 array_push($changes, ['field' => $key, 'change' => $value]);
    //             }
    //         }
    //         return $changes;
    //     } catch (Exception $ex) {
    //         return $ex->getMessage();
    //     }
    // }
    private function validationError($field,$message){
        throw ValidationException::withMessages([$field => $message]);
    }
}
