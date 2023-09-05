<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Advisor;

class LoginController extends Controller
{
    public function index()
    {
        $url = "https://erp.kluniversity.in/index.php?r=studentinfo%2Fstudentprofileinfo%2Fviewprofileindi";
        $html = $this->getHtml($url);
        
        if ($html[0] == "failure") {
            return $html[1];
        }

        $html = $html[1];

        $userData = $this->extractDataForProfile($html);
        $advisorData = $this->extractAdvisorsTableData($html);

        // dd($userData, $advisorData);

        $userData['advisor_uni_id'] = $advisorData[0]['advisor_uni_id'];


        $advisor = Advisor::updateOrCreate(['advisor_uni_id' => $userData['advisor_uni_id']], $advisorData[0]);
        $user = User::updateOrCreate(["first_name" => $userData['first_name'], "last_name" => $userData['last_name']], $userData);

        return response()->json(['message' => 'User created successfully', 'user' => $user, 'advisor' => $advisor]);

    }

    public function courses()
    {
        $url = "https://erp.kluniversity.in/index.php?r=studentinfo%2Fstudentcoursemappingmasterinfoview%2Ftab_index_personal&dp-11-page=2&page=";

        $ifLast = false;
        $count = 1;
        $data = [];

        while (!$ifLast) 
        {
            $html = $this->getHtml($url.$count);
            
            if ($html[0] == "failure") {
                return $html[1];
            }

            $html = $html[1];

            $ifLast = $this->checkifLast($html);

            
            $userData = $this->extractDataForCourses($html);
            $data = array_merge($data, $userData);
            $count++;
        }

        for ($i=0; $i < count($data); $i++) { 
            $data[$i]['user_id'] = 1;
        }

        // dd($data);

        $user = User::find(1);
        $user->courses()->createMany($data);
        return response()->json(['message' => 'Courses created successfully', 'user' => $user, 'courses' => $user->courses]);
    }

    private function extractValueTab1($xpath, $label)
    {
        $query = "//td[contains(text(), '$label')]/following-sibling::td/label";
        $nodeList = $xpath->query($query);

        if ($nodeList->length > 0) {
            $value = $nodeList->item(0)->textContent;
            $value = trim(str_replace(':', '', $value));
            return $value;
        }

        return null;
    }

    private function getFieldNameTab1($label)
    {
        // Convert the label to snake_case for the field name
        return strtolower(str_replace(' ', '_', $label));
    }

    private function getHtml($url)
    {

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

    private function checkifLast($html)
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress libxml errors
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Create a DOMXPath object to query the document
        $xpath = new \DOMXPath($dom);

        $query = "//div[@class='summary']//b";
        $nodeList = $xpath->query($query);

        if ($nodeList->length > 0) {
            $current_fin = $nodeList->item(0)->textContent;
            $current_fin = explode("-", $current_fin)[1];
            $fin = $nodeList->item(1)->textContent;
            return $current_fin == $fin;
        }

        return null;
    }

    private function extractAddress($xpath)
    {
        $query = "//td[contains(text(), 'Present Address')]/following-sibling::td";
        $nodeList = $xpath->query($query);

        if ($nodeList->length > 0) {
            // Extract all the text nodes within the Present Address row
            $addressParts = [];
            foreach ($nodeList as $node) {
                $value = trim($node->textContent);
                if (strlen($value) ==  0) {
                    // Skip empty text nodes
                    continue;
                }
                $addressParts[] = $value;
            }

            // Combine the address parts into a single string
            $address = implode(', ', $addressParts);

            return trim($address);
        }

    }

    private function extractDataForCourses($html)
    {
        // Create a DOMDocument and load the HTML content
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress libxml errors
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Create a DOMXPath object to query the document
        $xpath = new \DOMXPath($dom);

        // Find the table
        $table = $xpath->query('//table[@class="table table-striped table-bordered"]')->item(0);

        if ($table) {
            // Initialize an array to store the table data
            $tableData = [];

            // Get the table rows
            $rows = $xpath->query('tbody/tr', $table);

            foreach ($rows as $row) {
                // Initialize an object to represent a table row
                // $rowData = new \stdClass();
                $rowData = [];

                // Get the table cells in the row
                $cells = $xpath->query('td', $row);

                // Extract and store data in the object
                // $rowData->number = trim($cells->item(0)->textContent);
                // $rowData->year = trim($cells->item(1)->textContent);
                // $rowData->academic_year = trim($cells->item(2)->textContent);
                // $rowData->semester = trim($cells->item(3)->textContent);
                // $rowData->course_code = trim($cells->item(4)->textContent);
                // $rowData->course_description = trim($cells->item(5)->textContent);
                // $rowData->ltps = trim($cells->item(6)->textContent);
                // $rowData->section = trim($cells->item(7)->textContent);
                // $rowData->faculty_name = trim($cells->item(8)->textContent);

                $rowData['year'] = trim($cells->item(1)->textContent);
                $rowData['academic_year'] = trim($cells->item(2)->textContent);
                $rowData['semester'] = trim($cells->item(3)->textContent);
                $rowData['course_code'] = trim($cells->item(4)->textContent);
                $rowData['course_description'] = trim($cells->item(5)->textContent);
                $rowData['ltps'] = trim($cells->item(6)->textContent);
                $rowData['section'] = trim($cells->item(7)->textContent);
                $rowData['faculty_name'] = trim($cells->item(8)->textContent);

                // Add the row object to the table data array
                $tableData[] = $rowData;
            }

            return $tableData;
        }

        return null;
    }


    private function extractDataForProfile($html)
    {

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress libxml errors
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Create a DOMXPath object to query the document
        $xpath = new \DOMXPath($dom);

        // Extract data using XPath expressions
        $userData = [];

        $fieldLabels = [
            'First Name',
            'Middle Name',
            'Last Name',
            'Gender',
            'Father Name',
            'Mother Name',
            'Mother Maiden Name',
            'Date Of Birth',
            'Blood Group',
            'Martial Status',
            'Mother Tongue',
            'Cast Category',
            'Personal E-mail',
            'Identification',
            'Disability',
            'Place of Birth',
            'Height',
            'Weight',
            'Religion',
            'Nationality',
            'Admission Date',
            'Major Degree',
            'Refered By',
            'Program',
            'Regulation',
            'Campus',
            'Admission Type',
            'Hostel Status',
        ];

        // Extract data for each field
        foreach ($fieldLabels as $label) {
            $userData[$this->getFieldNameTab1($label)] = $this->extractValueTab1($xpath, $label);
        }

        $userData['height'] = (int) trim(str_replace('cm', '', $userData['height']));
        $userData['weight'] = (int) trim(str_replace('kg', '', $userData['weight']));
        $userData['date_of_birth'] = date('Y-m-d', strtotime($userData['date_of_birth']));

        $userData['address'] = $this->extractAddress($xpath);
        return $userData;
    }

    private function extractAdvisorsTableData($html)
    {
        // Create a DOMDocument and load the HTML content
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Suppress libxml errors
        $dom->loadHTML($html);
        libxml_clear_errors();

        // Create a DOMXPath object to query the document
        $xpath = new \DOMXPath($dom);

        // Find the table with id="tab11"
        $table = $xpath->query('//div[@id="tab11"]//table[@class="table table-striped table-bordered"]')->item(0);

        if ($table) {
            // Initialize an array to store the table data
            $tableData = [];

            // Get the table rows
            $rows = $xpath->query('tbody/tr', $table);

            foreach ($rows as $row) {
                // Initialize an object to represent a table row
                // $rowData = new \stdClass();

                $rowData = [];

                // Get the table cells in the row
                $cells = $xpath->query('td', $row);

                // Extract and store data in the object
                // $rowData->number = trim($cells->item(0)->textContent);
                // $rowData->advisor_uni_id = trim($cells->item(1)->textContent);
                // $rowData->advisor_name = trim($cells->item(2)->textContent);

                $rowData['advisor_uni_id'] = trim($cells->item(1)->textContent);
                $rowData['advisor_name'] = trim($cells->item(2)->textContent);
                

                // Add the row object to the table data array
                $tableData[] = $rowData;
            }

            return $tableData;
        }

        return null;
    }


    

}
