<?php

namespace App\Http\Controllers;

use App\Services\AnnouncementService;
use Illuminate\Http\Request;

class AnnouncementGuestController extends Controller
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
