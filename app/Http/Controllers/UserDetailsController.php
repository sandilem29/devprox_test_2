<?php

namespace App\Http\Controllers;

use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use File;

class UserDetailsController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $number_of_records = $request->input('number_of_records');

        $faker = Faker::create();
        $names_array = array();
        $surnames_array = array();

        // use laravel fake factory to create random names and surnames
        for ($i = 1; $i <= 20; ++$i) {
            array_push($names_array, $faker->firstName);
            array_push($surnames_array, $faker->lastName);
        }

        $random_data = array();
        for ($i = 1; $i <= $number_of_records; ++$i) {
            $random_name = $names_array[mt_rand(0, sizeof($names_array) - 1)];
            $random_surname = $surnames_array[mt_rand(0, sizeof($surnames_array) - 1)];
            $timestamp = mt_rand(1, time());
            $random_date = $faker->date('Y/m/d', $timestamp);
            $initials = substr($random_name, 0, 1);

            $age = (date('Y') - date('Y', strtotime(date('Y-m-d', strtotime(str_replace('/', '-', $random_date))))));

            $random_data[] = array($i,
                                        $random_name,
                                        $random_surname,
                                        $initials,
                                        $age, $random_date, );
        }

        $file_handler = fopen('php://memory', 'w');
        $headers_array = array('id', 'name', 'surname', 'initials', 'age', 'date of birth');

        // add header files
        fputcsv($file_handler, $headers_array);

        foreach ($random_data as $line) {
            fputcsv($file_handler, $line);
        }

        fseek($file_handler, 0);
        $csv = stream_get_contents($file_handler);
        fclose($file_handler);
        // create the output folder in the storage location
        $output_folder = storage_path().'/app/output/';

        // remove the folder and its files if its already exists and avoid overwritting
        if (File::isDirectory($output_folder)) {
            Storage::deleteDirectory($output_folder);
        }
        Storage::makeDirectory('output');
        // save the file in the storage folder with the name output.csv and put the contents;
        Storage::put('/output/output.csv', $csv);

        return view('upload_file');
    }

    public function upload_file(Request $request)
    {
        $request->validate(['file' => 'required|mimes:csv,txt']);

        $path = $request->file('file')->getRealPath();
        $file = file($path);

        $data = array_slice($file, 1);

        $parts = (array_chunk($data, 1000));
        $i = 1;
        foreach ($parts as $line) {
            $filename = base_path('resources/pendingusers/'.date('y-m-d-H-i-s').$i.'.csv');
            file_put_contents($filename, $line);
            ++$i;
        }
        session()->flash('message', 'queued for importing');

        return view('upload_file');
    }

    public function import()
    {
        $records = [];
        $path = base_path('resources/pendingusers');
        foreach (glob($path.'/*.csv') as $file) {
            $file = new \SplFileObject($file, 'r');
            $file->seek(PHP_INT_MAX);
            $records[] = $file->key();
        }
        $toImport = array_sum($records);

        return view('upload_file', compact('toImport'));
    }
}
