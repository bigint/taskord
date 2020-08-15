<?php

namespace App\Http\Controllers;

use App\Models\Patron;
use App\Models\User;
use Illuminate\Http\Request;

class PatronController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $public_key_string = env('PADDLE_PUBLIC_KEY');
        $public_key = openssl_get_publickey($public_key_string);
        $signature = base64_decode($request->p_signature);
        $fields = $request->all();
        unset($fields['p_signature']);
        ksort($fields);
        foreach ($fields as $k => $v) {
            if (! in_array(gettype($v), ['object', 'array'])) {
                $fields[$k] = "$v";
            }
        }
        $data = serialize($fields);
        $verification = openssl_verify($data, $signature, $public_key, OPENSSL_ALGO_SHA1);
        if ($verification == 1) {
            $user = User::where('email', $request->email)->first();
            if (Patron::where('user_id', $user->id)->count() === 0) {
                if ($user) {
                    Patron::create([
                        'user_id' => $user->id,
                        'checkout_id' => $request->checkout_id,
                        'cancel_url' => $request->cancel_url,
                        'event_time' => $request->event_time,
                        'next_bill_date' => $request->next_bill_date,
                    ]);
                    $user->isPatron = true;
                    $user->save();

                    return 'Success';
                } else {
                    return 'No user';
                }
            } else {
                return 'Already Subscribed';
            }
        } else {
            return 'Forbidden!';
        }
    }

    public function patron()
    {
        return view('pages.patron');
    }
}
