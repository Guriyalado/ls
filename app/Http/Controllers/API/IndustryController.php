<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Industry;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Industry as IndustryResource;
use App\Http\Controllers\BaseController as BaseController;
class IndustryController extends BaseController
{
    /* all industries*/
    public function getAllIndustries()
    {
        $industries = Industry::all();
        return $this->sendResponse(IndustryResource::collection($industries), 'Industries fetched.');
    }
}
