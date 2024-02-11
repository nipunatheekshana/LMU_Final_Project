<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Log SQL Queries @ storage/logs/query.log
        DB::listen(function ($query) {
            $sql = $query->sql;
            // Exclude specific queries from being logged
            if (
                $sql === 'select * from `users` where `id` = ? limit 1' ||
                $sql === 'select exists(select * from `settings_user_settings` where `user_id` = ?) as `exists`' ||
                $sql === 'select * from `settings_user_settings` where `user_id` = ? limit 1'
            ) {
                return;
            }
            $timestamp = Carbon::now()->format('Y.m.d h:i:s.v A');
            File::append(
                storage_path('/logs/query.log'),
                $timestamp . ' | ' . $sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . PHP_EOL
            );
        });
    }
}
