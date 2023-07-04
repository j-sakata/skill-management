<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Google_Client;
use Google_Service_Calendar;
use DateTime;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    /**
     * Show the dashboard screen.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $holidays = $this->get_holiday_from_google_calendar();
        $schedules = $this->get_schedule_from_google_calendar();
        return Inertia::render('Dashboard', ['user_id' => $user_id, 'holidays' => $holidays, 'schedules' => $schedules]);
    }

    /**
     * Get holiday from google calendar.
     *
     * @return array
     */
    Public function get_holiday_from_google_calendar()
    {
        // https://www.asobou.co.jp/blog/web/googlecalender2
        // 取得したAPIキー
        $api_key = $_ENV['GOOGLE_CALENDAR_API'];
        // カレンダーID
        $calendar_id = urlencode('japanese__ja@holiday.calendar.google.com');  // Googleの提供する日本の祝日カレンダー
        // データの開始日
        $start = date('2020-01-01\T00:00:00\Z');
        // データの終了日
        $end = date('2024-12-31\T00:00:00\Z');

        $url = "https://www.googleapis.com/calendar/v3/calendars/" . $calendar_id . "/events?";
        $query = [
            'key' => $api_key,
            'timeMin' => $start,
            'timeMax' => $end,
            'maxResults' => 50,
            'orderBy' => 'startTime',
            'singleEvents' => 'true'
        ];

        $holidays = [];
        if ($data = file_get_contents($url. http_build_query($query), true)) {
            $data = json_decode($data);
            // $data->itemには日本の祝日カレンダーの"予定"が入ってきます
            foreach ($data->items as $row) {
                // [予定の日付 => 予定のタイトル]
                $holidays[$row->start->date] = $row->summary;
            }
        }
        return $holidays;
    }

    /**
     * Get schedule from google calendar.
     *
     * @return array
     */
    Public function get_schedule_from_google_calendar()
    {
        // 秘密鍵.jsonまでのパス
        $json_path = $_ENV['JSON_PATH'];
        // データの開始日
        $start = date(date('Y'). '-01-01\T00:00:00\Z');
        // データの終了日
        $end = date(date('Y'). '-12-31\T00:00:00\Z');
        // カレンダーID
        $calendar_id = $_ENV['CALENDAR_ID'];;

        $client = new Google_Client();
        // スコープをカレンダーの読み取りに設定
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        // 認証設定
        $client->setAuthConfig($json_path);

        // カレンダーサービスの作成
        $service = new Google_Service_Calendar($client);

        $option = [
            'timeMin' => $start,
            'timeMax' => $end,
            'maxResults' => 50,
            'orderBy' => 'startTime',
            'singleEvents' => 'true'
        ];
        // データの取得
        $response = $service->events->listEvents($calendar_id, $option);
        $events = $response->getItems();

        $schedules = [];
        if (!empty($events)) {
            foreach ($events as $event) {
                // 終日予定はdate、時刻指定はdateTimeにデータが入り、もう片方にはNULLが入っている
                $start = new DateTime(!is_null($event->start->date)?$event->start->date:$event->start->dateTime);
                $end   = new DateTime(!is_null($event->end->date)?$event->end->date:$event->end->dateTime);
                $schedules[$start->format('Y-m-d')][] = [
                    'start' => $start->format('Y-m-d H:i:s'),
                    'end' => $end->format('Y-m-d H:i:s'),
                    'title' => (string)$event->summary,
                    'description' => (string)$event->description
                ];
            }
        }
        return $schedules;
    }
}
