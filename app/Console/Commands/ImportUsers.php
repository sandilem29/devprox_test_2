<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CsvImport;

class ImportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'import users in the split csv folder';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = base_path('resources/pendingusers/*.csv');

        //run 2 loops at a time

        foreach (array_slice(glob($path), 0, 2) as $file) {
            //read the data into an array
            $data = array_map('str_getcsv', file($file));

            foreach ($data as $row) {
                //insert the record or update if the email already exists

                $new_import = new CsvImport();
                $new_import->id = $row[0];
                $new_import->name = $row[1];
                $new_import->surname = $row[2];
                $new_import->initials = $row[3];
                $new_import->age = $row[4];
                $new_import->date_of_birth = $row[5];
                $new_import->save();
            }
            //delete the file
            unlink($file);
        }
    }
}
