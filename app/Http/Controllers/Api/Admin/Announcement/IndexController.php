<?php

namespace App\Http\Controllers\Api\Admin\Announcement;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Notifications\Announcement;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Announcement\StoreRequest;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;

class IndexController extends Controller
{
    /**
     * Display a listing of batches in draft status
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $users = User::all();
        $batch = str_random(10) . Carbon::now()->timestamp;

        // @TODO remove this and create a JOB for this!
        foreach ($users as $key => $user) {
            $user->notify(new Announcement($user->id, $request->all(), $batch));
        }

        return successful(trans('message.admin.announcement.success.store'));
    }

    /**
     * Display listing sources
     *
     * @return json
     */
    public function index(Request $request)
    {
        if ($request->has('count') && $request->has('page')) {
            $count = $request->has('count') ? $request->count : 10;
            $announcements = Notification::groupBy('batch_id')->orderBy('created_at', 'DESC')->paginate($count);
        } else {
            $announcements = Notification::groupBy('batch_id')->orderBy('created_at', 'DESC')->get();
            $announcements = get_current_notifications($announcements);
        }
        return success_data(compact('announcements'));
    }

    /**
     * Update
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $batch_id)
    {
        $arr = [
            'topic' => $request->input('topic'),
            'content' => $request->input('content'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'batch_id' => $batch_id
        ];
        $notifications = Notification::where('batch_id', $batch_id)->update(['data' => json_encode($arr), 'read_at' => null]);

        return successful(trans('message.admin.announcement.success.update'), [
            'batch_id' => $batch_id,
        ]);
    }

    /**
     * Delete announcement
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function destroy($batch_id)
    {
        $notifications = Notification::where('batch_id', $batch_id)->delete();
        return successful(trans('message.admin.announcement.success.destroy'));
    }
}
