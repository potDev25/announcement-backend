<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnouncementRequest;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{

    protected $ANNOUNCEMENT_SERVICE;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->ANNOUNCEMENT_SERVICE = $announcementService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $announcements = $this->ANNOUNCEMENT_SERVICE->getAnnouncement($request);

        return response($announcements);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $payload = $request->validated();
        $payload['user_id'] = auth()->user()->id;
        $payload['startDate'] = $this->ANNOUNCEMENT_SERVICE->convertDate($payload['startDate']);
        $payload['endDate'] = $this->ANNOUNCEMENT_SERVICE->convertDate($payload['endDate']);
        $payload['active'] = $this->ANNOUNCEMENT_SERVICE->isPresentDate($payload['startDate'], $payload['endDate']);
        $announcement = Announcement::create($payload);

        return response($announcement);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreAnnouncementRequest $request, Announcement $announcement)
    {
        $payload = $request->validated();
        $payload['startDate'] = $this->ANNOUNCEMENT_SERVICE->convertDate($payload['startDate']);
        $payload['endDate'] = $this->ANNOUNCEMENT_SERVICE->convertDate($payload['endDate']);
        $payload['active'] = $this->ANNOUNCEMENT_SERVICE->isPresentDate($payload['startDate'], $payload['endDate']);
        $announcement->update($payload);

        return response($announcement);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Announcement $announcement)
    {
        $announcement->delete();
        return response(200);
    }
}
