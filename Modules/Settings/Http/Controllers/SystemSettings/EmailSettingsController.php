<?php

namespace Modules\Settings\Http\Controllers\SystemSettings;

use App\Http\common\commonFeatures;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use Modules\Settings\Emails\SettingTestEmail;

class EmailSettingsController extends Controller
{
    use commonFeatures;
    public function loadCurrentSettings()
    {
        try {
            $array = [
                "mailDriver" => $_ENV['MAIL_MAILER'],
                "host" => $_ENV['MAIL_HOST'],
                "port" => $_ENV['MAIL_PORT'],
                "userName" => $_ENV['MAIL_USERNAME'],
                "password" => $_ENV['MAIL_PASSWORD'],
                "encryption" => $_ENV['MAIL_ENCRYPTION'],
                "mailFromAddress" => $_ENV['MAIL_FROM_ADDRESS'],
                "mailFromName" => $_ENV['MAIL_FROM_NAME'],
            ];

            return $this->responseBody(true, "loadCurrentSettings", "found", $array);
        } catch (Exception $ex) {
            return $this->responseBody(false, "loadCurrentSettings", "Error", $ex->getMessage());
        }
    }
    public function SaveNewsettings(Request $request)
    {
        try {

            $path = base_path('.env');

            if (file_exists($path)) {
                if ($request->mailDriver != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_MAILER=' . $_ENV['MAIL_MAILER'],
                        'MAIL_MAILER=' . $request->mailDriver,
                        file_get_contents($path)
                    ));
                }
                if ($request->host != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_HOST=' . $_ENV['MAIL_HOST'],
                        'MAIL_HOST=' . $request->host,
                        file_get_contents($path)
                    ));
                }
                if ($request->port != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_PORT=' . $_ENV['MAIL_PORT'],
                        'MAIL_PORT=' . $request->port,
                        file_get_contents($path)
                    ));
                }
                if ($request->userName != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_USERNAME=' . $_ENV['MAIL_USERNAME'],
                        'MAIL_USERNAME=' . $request->userName,
                        file_get_contents($path)
                    ));
                }
                if ($request->password != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_PASSWORD=' . $_ENV['MAIL_PASSWORD'],
                        'MAIL_PASSWORD=' . $request->password,
                        file_get_contents($path)
                    ));
                }
                if ($request->encryption != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_ENCRYPTION=' . $_ENV['MAIL_ENCRYPTION'],
                        'MAIL_ENCRYPTION=' . $request->encryption,
                        file_get_contents($path)
                    ));
                }
                if ($request->mailFromAddress != null) {
                    file_put_contents($path, str_replace(
                        'MAIL_FROM_ADDRESS=' . '"' . $_ENV['MAIL_FROM_ADDRESS'] . '"',
                        'MAIL_FROM_ADDRESS=' . '"' . $request->mailFromAddress . '"',
                        file_get_contents($path)
                    ));
                }
                if ($request->mailFromName != null) {
                    file_put_contents($path, str_replace(
                        'APP_NAME=' . $_ENV['APP_NAME'],
                        'APP_NAME=' . $request->mailFromName,
                        file_get_contents($path)
                    ));
                }
            }

            return $this->responseBody(true, "SaveNewsettings", "found", '');
        } catch (Exception $ex) {
            return $this->responseBody(false, "SaveNewsettings", "Error", $ex->getMessage());
        }
    }

    public function testEmail(Request $request){
        $validatedData = $request->validate([
            'content' => ['required'],
            'email' => ['nullable', 'email'],

        ]);
        try {

            Mail::to($request->emailAddress)->send(new SettingTestEmail($request->content));

            return $this->responseBody(true, "Test Email has been sent", "Email Sent", '');

        } catch (Exception $ex) {
            return $this->responseBody(false, "Some thing went wrong", "Error", $ex->getMessage());

        }
    }
}
