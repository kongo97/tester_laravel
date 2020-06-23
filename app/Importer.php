<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Importer extends Model
{
    // get registries
    public function import_configurations_T4814()
    {
        // initialize CSV
        $csv = $this->initializeCSV();

        // set data for db insert
        $data = [];

        // loop csv
        foreach($csv as $key => $value)
        {   
            // get region id
            $region_id = $this->getRegionId($value[0]);

            // get type id
            $type_id = $this->getTypeId($value[1]);

            // get fuel id
            $fuel_id = $this->getFuelId($value[2]);

            // get lower limit
            $lower_limit = $value[3];

            // get upper limit
            $upper_limit = $value[4];

            // get reference id
            $reference_id = $this->getReferenceId($value[5]);

            // get coefficient
            $coefficient = $value[6];

            // get reduction
            $reduction = $this->getReduction($value[7]);

            // get reduction duration
            $reduction_duration = $value[8];

            // get reduced coefficient
            $reduced_coefficient = $value[9];

            // add record to data
            $data[] = [
                "id" => $key + 1,
                "id_regione" => $region_id,
                "id_tipologia" => $type_id,
                "id_alimentazione" => $fuel_id,
                "limite_inferiore" => $lower_limit,
                "limite_superiore" => $upper_limit,
                "id_riferimento" => $reference_id,
                "coefficiente" => (float)$coefficient,
                "riduzione" => $reduction,
                "durata_riduzione" => $reduction_duration,
                "coefficiente_ridotto" => $reduced_coefficient
            ];
        }

        echo "<pre>";
        print_r($data);
        echo "</pre>";

        // db insert
        DB::table('configurazioni')->insert($data);

        echo "done!";
    }

    // initialize csv
    public function initializeCSV()
    {
        // read csv
        $csv = array_map('str_getcsv', file(storage_path('app/public/configurazioni.csv')));

        // set normalized csv
        $normalized_csv = [];

        // loop csv
        foreach($csv as $key => $value)
        {
            // check fuel
            if($value[2] == "STANDARD")
            {
                // set new records
                $new_records = [];

                // add first new record
                $new_records[] = [
                    $value[0],
                    $value[1],
                    "benzina",
                    $value[3],
                    $value[4],
                    $value[5],
                    $value[6],
                    $value[7],
                    $value[8],
                    $value[9]
                ];

                // add second new record
                $new_records[] = [
                    $value[0],
                    $value[1],
                    "diesel",
                    $value[3],
                    $value[4],
                    $value[5],
                    $value[6],
                    $value[7],
                    $value[8],
                    $value[9]
                ];

                // add new records to normalized csv
                $normalized_csv = array_merge($normalized_csv, $new_records); 
            }
            elseif($value[2] == "GPL_METANO")
            {
                // set new records
                $new_records = [];

                // add first new record
                $new_records[] = [
                    $value[0],
                    $value[1],
                    "gpl",
                    $value[3],
                    $value[4],
                    $value[5],
                    $value[6],
                    $value[7],
                    $value[8],
                    $value[9]
                ];

                // add second new record
                $new_records[] = [
                    $value[0],
                    $value[1],
                    "metano",
                    $value[3],
                    $value[4],
                    $value[5],
                    $value[6],
                    $value[7],
                    $value[8],
                    $value[9]
                ];

                // add new records to normalized csv
                $normalized_csv = array_merge($normalized_csv, $new_records); 
            }
            else
            {
                // add record to normalized csv
                $normalized_csv[] = $value;
            }
        }

        // return normalized csv
        return $normalized_csv;
    }

    // get region id from region name
    public function getRegionId($region = null)
    {
        // check region value
        if($region == null)
        {
            return false;
        }

        // region to lowercase (like db)
        $region = strtolower($region);

        // initialize region id
        $region_id = null;

        // set region id
        if($region == "lombardia")
        {
            $region_id = 1;
        }
        elseif($region == "trento")
        {
            $region_id = 2;
        }
        elseif($region == "bolzano")
        {
            $region_id = 3;
        }
        elseif($region == "emilia romagna")
        {
            $region_id = 4;
        }
        elseif($region == "lazio")
        {
            $region_id = 5;
        }
        elseif($region == "veneto")
        {
            $region_id = 6;
        }
        elseif($region == "toscana")
        {
            $region_id = 7;
        }
        elseif($region == "sicilia")
        {
            $region_id = 8;
        }
        elseif($region == "marche")
        {
            $region_id = 9;
        }
        elseif($region == "umbria")
        {
            $region_id = 10;
        }
        elseif($region == "basilicata")
        {
            $region_id = 11;
        }
        elseif($region == "molise")
        {
            $region_id = 12;
        }
        elseif($region == "puglia")
        {
            $region_id = 13;
        }
        elseif($region == "abruzzo")
        {
            $region_id = 14;
        }
        elseif($region == "calabria")
        {
            $region_id = 15;
        }
        elseif($region == "campania")
        {
            $region_id = 16;
        }
        elseif($region == "piemonte")
        {
            $region_id = 17;
        }
        elseif($region == "friuli venezia giulia")
        {
            $region_id = 18;
        }
        elseif($region == "sardegna")
        {
            $region_id = 19;
        }
        elseif($region == "liguria")
        {
            $region_id = 20;
        }
        elseif($region == "valle d'aosta")
        {
            $region_id = 21;
        }

        // check region id value
        if($region_id == null)
        {
            return false;
        }

        // return region id
        return $region_id;
    }

    // get type id
    public function getTypeId($type = null)
    {
        // check type value
        if($type == null)
        {
            return false;
        }

        // type to lowercase (like db)
        $type = strtolower($type);

        // initialize type id
        $type_id = null;

        // set type id
        if($type == "pc")
        {
            $type_id = 1;
        }
        elseif($type == "n1")
        {
            $type_id = 2;
        }
        elseif($type == "lcv")
        {
            $type_id = 3;
        }

        // check type id value
        if($type_id == null)
        {
            return false;
        }

        // return type id
        return $type_id;
    }

    // get fuel id
    public function getFuelId($fuel = null)
    {
        // check fuel value
        if($fuel == null)
        {
            return false;
        }

        // fuel to lowercase (like db)
        $fuel = strtolower($fuel);

        // initialize fuel id
        $fuel_id = null;

        // set fuel id
        if($fuel == "benzina")
        {
            $fuel_id = 1;
        }
        elseif($fuel == "diesel")
        {
            $fuel_id = 2;
        }
        elseif($fuel == "metano")
        {
            $fuel_id = 3;
        }
        elseif($fuel == "gpl")
        {
            $fuel_id = 4;
        }
        elseif($fuel == "ibrido")
        {
            $fuel_id = 5;
        }
        elseif($fuel == "elettrico")
        {
            $fuel_id = 6;
        }

        // check fuel id value
        if($fuel_id == null)
        {
            return false;
        }

        // return fuel id
        return $fuel_id;
    }

    // get reference id
    public function getReferenceId($reference = null)
    {
        // check reference value
        if($reference == null)
        {
            return false;
        }

        // reference to lowercase (like db)
        $reference = strtolower($reference);

        // initialize reference id
        $reference_id = null;

        // set reference id
        if($reference == "maxloadingcapacity")
        {
            $reference_id = 1;
        }
        elseif($reference == "kw")
        {
            $reference_id = 2;
        }

        // check reference id value
        if($reference_id == null)
        {
            return false;
        }

        // return reference id
        return $reference_id;
    }

    // get reduction value
    public function getReduction($reduction = null)
    {
        // check reduction value
        if($reduction == null)
        {
            return false;
        }

        // reduction to lowercase (like db)
        $reduction = strtolower($reduction);

        // initialize reduction value
        $reduction_value = null;

        // set reduction value
        if($reduction == "no")
        {
            $reduction_value = 0;
        }
        elseif($reduction == "si")
        {
            $reduction_value = 1;
        }

        // check reduction value value
        if($reduction_value == null)
        {
            return false;
        }

        // return reduction value
        return $reduction_value;
    }
}
