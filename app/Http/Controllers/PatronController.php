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
            if ($request->alert_name === 'subscription_created') {
                return $this->handleSubscriptionCreated($user, $request);
            } elseif ($request->alert_name === 'subscription_updated') {
                return $this->handleSubscriptionUpdated($user, $request);
            } elseif (
                $request->alert_name === 'subscription_cancelled' or
                $request->alert_name === 'subscription_payment_refunded'
            ) {
                return $this->handleSubscriptionCancelled($user, $request);
            }
        } else {
            return 'Forbidden';
        }
    }

    public function handleSubscriptionCreated($user, $request)
    {
        if ($user) {
            if (Patron::where('user_id', $user->id)->count() === 0) {
                Patron::create([
                    'user_id' => $user->id,
                    'checkout_id' => $request->checkout_id,
                    'subscription_plan_id' => $request->subscription_plan_id,
                    'update_url' => $request->update_url,
                    'cancel_url' => $request->cancel_url,
                    'event_time' => $request->event_time,
                    'next_bill_date' => $request->next_bill_date,
                ]);
                $user->isPatron = true;
                $user->save();

                return 'Success';
            } else {
                return 'Already Subscribed';
            }
        } else {
            return 'No user';
        }
    }

    public function handleSubscriptionUpdated($user, $request)
    {
        if ($user) {
            $user->patron->checkout_id = $request->checkout_id;
            $user->patron->subscription_plan_id = $request->subscription_plan_id;
            $user->patron->update_url = $request->update_url;
            $user->patron->cancel_url = $request->cancel_url;
            $user->patron->save();

            return 'Success';
        } else {
            return 'No user';
        }
    }

    public function handleSubscriptionCancelled($user, $request)
    {
        if ($user) {
            $user->patron->delete();
            $user->isPatron = false;
            $user->darkMode = false;
            $user->isPrivate = false;
            $user->save();

            return 'Success';
        } else {
            return 'No user';
        }
    }
}
