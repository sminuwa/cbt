<?php

namespace App\Http\Controllers\Admin\Toolbox;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Tests\ExamTypeController;
use App\Http\Controllers\Admin\System\CentreController;
use App\Http\Controllers\Admin\System\VenueController;
use App\Http\Controllers\Admin\System\SubjectsController;
use App\Http\Controllers\Student\Dashboard\CandidateUploadController;
use Illuminate\Http\Request;

class ToolboxController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Show candidate types management
     */
    public function candidateTypes()
    {
        return view('pages.admin.toolbox.candidate_type');
    }

    /**
     * Show center and venue management
     */
    public function centerVenue()
    {
        return view('pages.admin.toolbox.manage_center_venue');
    }

    /**
     * Show subject management
     */
    public function subjects()
    {
        return view('pages.admin.toolbox.manage_subject');
    }

    /**
     * Show candidate upload interface
     */
    public function candidateUpload()
    {
        return view('pages.admin.toolbox.candidate_upload');
    }

    /**
     * Show candidate image upload interface
     */
    public function candidateImageUpload()
    {
        return view('pages.admin.toolbox.candidate_image_upload');
    }

    /**
     * Show invigilator panel
     */
    public function invigilatorPanel()
    {
        return view('pages.admin.toolbox.invigilator_panel');
    }

    /**
     * Show active candidates ajax view
     */
    public function activeAjax()
    {
        return view('pages.admin.toolbox.ajax.active');
    }
}

