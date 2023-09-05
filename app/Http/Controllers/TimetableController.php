<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TimetableController extends Controller
{
    public function index()
    {
        dd($this->getHTML(14,1));
    }

    private function getHTML($year, $semester){
        
        $url = "https://erp.kluniversity.in/index.php?r=timetables%2Funiversitymasteracademictimetableview%2Findividualstudenttimetableget&UniversityMasterAcademicTimetableView%5Bacademicyear%5D={$year}&UniversityMasterAcademicTimetableView%5Bsemesterid%5D={semester}" ;


        // Set the request headers
        $headers = [
            'Cookie' => 'PHPSESSID=' . config('app.php_session_id'),
        ];

        // Send a GET request to the URL with headers
        $response = Http::withHeaders($headers)->get($url);

        // Check if the request was successful
        if ($response->successful()) {
            // Get the HTML content
            $html = $response->body();
            return ["success", $html];
        }

        // Handle the case where the request was not successful (e.g., an error occurred)
        return ['failure', response()->json(['message' => 'Failed to fetch data'], 500)];
    }
}
