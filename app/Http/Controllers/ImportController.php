<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Importer;

class ImportController extends Controller
{
    // create anagrafiche.txt file (data1 | data2 | data3 | data 4)
    public function importT4814()
    {
        // Importer object
        $Importer = new Importer();

        // run import method
        $Importer->import_configurations_T4814();
    }
}
