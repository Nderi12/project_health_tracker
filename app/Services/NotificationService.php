<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Rider;
use App\Models\User;

class NotificationService
{
    /**
     * Notification service function to send a owner specific notification
     *
     * @param [string] $type: owner-notificatin|customer-notification
     * @param [integer] $owner: Rider id
     * @param [string] $title: Eg. This is a title
     * @param [string] $body: Eg. This is the notification body
     * @return void
     * @author Nderi Kamau <nderikamau1212@gmail.com>
     */
    public static function sendNotification($type, $owner, $title, $body)
    {
        $url = env('FCM_URL');

        switch ($type) {
            case 'rider-notification':
                $rider = Rider::where('id', $owner)->with(['devices'])->first();

                $rider->notifications()->create([
                    'title' => $title,
                    'body' => $body
                ]);
                
                $fcmToken = $rider->devices->pluck('device_token')->toArray();
                break;
            case 'customer-notification':
                $customer = Customer::where('id', $owner)->with(['devices'])->first();

                $customer->notifications()->create([
                    'title' => $title,
                    'body' => $body
                ]);

                $fcmToken = $customer->devices->pluck('device_token')->toArray();
                break;
            default:
                $fcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();
                break;
        }

        $data = [
            "registration_ids" => $fcmToken,
            "notification" => [
                "title" => $title,
                "body" => $body,
            ]
        ];

        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . env('FIREBASE_SERVER_KEY'),
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);

        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        return $result;
    }
}
