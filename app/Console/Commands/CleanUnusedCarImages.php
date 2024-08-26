<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class CleanUnusedCarImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car:clean-unused-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Log that the command has started
        Log::info('CleanUnusedCarImages command started at: ' . now());

        //
        $registeredFiles = $this->GetAllDatabaseFiles();
        $files = $this->GetAllFilesFromStorage();

        foreach ($files as $file) {
            //$filePath = $directory . '/' . $file;

            // Check if the file exists in the database
            if (!in_array($file, $registeredFiles)) {

                // Remove the file
                Storage::disk('public')->delete($file);

                // Log that the file has deleted
                Log::info('The File: '. $file .' deleted at: ' . now());
            }
        }

        $this->info('Unused car images have been cleaned.');
        // Log that the command has finished
        Log::info('CleanUnusedCarImages command completed at: ' . now());

    }

    public function GetAllDatabaseFiles() : array{
        $allfiles = array();

        $cars = Car::all();
        $parts = Part::all();

        foreach ($cars as $car) {
            $registeredImages = explode('|', $car->imgs);
            $registeredImages[] = $car->img;

            $allfiles = array_merge($allfiles, $registeredImages);
        }

        foreach ($parts as $part) {
            $registeredImages = explode('|', $part->imgs);
            $registeredImages[] = $part->img;

            $allfiles = array_merge($allfiles, $registeredImages);
        }

        return $allfiles;
    }

    public function GetAllFilesFromStorage() : array{

        $allfiles = array();

        $cars = Storage::disk('public')->files('car_images');
        $parts = Storage::disk('public')->files('part_images');

        $allfiles = array_merge($cars, $parts);
        return $allfiles;
    }



}
