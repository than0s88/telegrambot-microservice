<?php

namespace App\Http\Controllers;

use App\Http\Requests\TelegramAuthLoginRequest;

class TelegramBotController extends Controller
{
    public function webhook()
    {
        return "OK";
    }

    public function authLogin(TelegramAuthLoginRequest $request)
    {
        // return response()->json([
        //     'code' => 400,
        //     'message' => 'Data is not from Telegram',
        //     'data' => 'Data is not from Telegram'
        // ]);

        try {
            $auth_data = $request->validated();
            $bot_token = config('telegram.bots.mybot.token');

            $check_hash = $auth_data['hash'];
            unset($auth_data['hash']);
            $data_check_arr = [];

            foreach ($auth_data as $key => $value) {
                $data_check_arr[] = $key . '=' . $value;
            }

            sort($data_check_arr);
            $data_check_string = implode("\n", $data_check_arr);
            $secret_key = hash('sha256', $bot_token, true);
            $hash = hash_hmac('sha256', $data_check_string, $secret_key);

            //Validate auth data w/ bot token
            if (strcmp($hash, $check_hash) !== 0) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data is not from Telegram',
                    'data' => $auth_data
                ]);
            }
            if ((time() - $auth_data['auth_date']) > 86400) {
                return response()->json([
                    'code' => 400,
                    'message' => 'Data is outdated',
                    'data' => $auth_data
                ]);
            }
            unset($auth_data['auth_date']);
            $auth_data['first_name'] = $auth_data['first_name'] ?? null;
            $auth_data['last_name'] = $auth_data['last_name'] ?? null;
            $auth_data['photo_url'] = $auth_data['photo_url'] ?? null;

            return response()->json([
                'expiry' => null,
                'refresh' => '',
                'refresh_expiry' => null,
                'code' => null,
                'message' => 'pogi =ako',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'code' => 400,
                'message' => 'Something went wrong',
                'data' => $auth_data
            ]);
        }
    }
}
