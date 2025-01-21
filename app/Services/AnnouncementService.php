<?php

namespace App\Services;

use App\Http\Resources\AnnouncementCollection;
use App\Models\Announcement;
use Carbon\Carbon;

class AnnouncementService
{

    public function convertDate($date): string
    {
        return date("Y-m-d", strtotime($date));
    }

    public function isPresentDate($startDate, $endDate): bool
    {
        $currentDate = Carbon::today(); 
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        if ($startDate->isToday()) {
            return true;
        }

        return $startDate <= $currentDate && $currentDate <= $endDate;
    }


    public function setActiveStatus()
    {
        Announcement::chunk(200, function ($announcements) {
            foreach ($announcements as $data) {
                $data->active = $this->isPresentDate($data->startDate, $data->endDate);
                $data->save();
            }
        });
    }

    public function getAnnouncement($request)
    {
        $this->setActiveStatus();
        $query = Announcement::select('users.name', 'announcements.*')
            ->join('users', 'announcements.user_id', '=', 'users.id')
            ->orderBy('id', 'Desc');

        if (auth()->check()) {
            $query->where('user_id', auth()->user()->id);
        } else {
            $query->where('active', 1);
        }

        return new AnnouncementCollection($query->paginate($request->limit));
    }
}
