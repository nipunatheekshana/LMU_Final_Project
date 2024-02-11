<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserSetting extends Model
{
    use HasFactory;

    protected $guarded  = [];
    protected $table = 'settings_user_settings';

    protected static function newFactory()
    {
        return \Modules\Settings\Database\factories\UserSettingFactory::new();
    }
}
