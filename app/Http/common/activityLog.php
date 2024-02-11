<?php

namespace App\Http\common;

use Carbon\Carbon;
use Exception;
use Modules\Buying\Entities\GRNDetail;
use Illuminate\Support\Facades\Auth;
use Modules\Mnu\Entities\PackingBox;
use Modules\Mnu\Entities\ProductionDetail;

use function PHPUnit\Framework\isNull;

trait activityLog
{
    public function logActivity($icon, $color, $activity, $type, $id)
    {
        try {
            $obj = $this->getObj($type, $id);

            $data = $this->getData($obj);

            array_push($data, ['icon' => $icon, 'color' => $color, 'activity' => $activity, 'time' => Carbon::now()->toDateTimeString() . " (" . Auth::user()->id . ")"]);

            $obj->update(['activityLog' => json_encode($data)]);
        } catch (Exception $ex) {
            return $ex;
        }
    }
    function getObj($type, $id)
    {
        $obj = '';
        switch ($type) {
            case 'grnDetail':
                $obj = GRNDetail::where('id', $id);
                break;
            case 'packingBox':
                $obj = PackingBox::where('id', $id);
                break;
            case 'productionDtl':
                $obj = ProductionDetail::where('id', $id);
                break;
        }
        return $obj;
    }
    function getData($obj)
    {
        $data = [];
        $activityLog = $obj->first('activityLog')->activityLog;
        if (!$activityLog == null) {
            $data = json_decode($activityLog);
        }
        return $data;
    }
    public function getActivityLog($id, $type)
    {
        try {
            $obj = $this->getObj($type, $id);

            $data = $this->getData($obj);
            return $data;
        } catch (Exception $ex) {
            return $ex;
        }
    }
}
