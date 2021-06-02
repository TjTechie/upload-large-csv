<?php

namespace App\Http\Controllers;

use App\Models\AccoutingExports;
use Illuminate\Http\Request;
use App\Jobs\ExportsCsvFile;
use Illuminate\Support\Facades\Bus;

class AccountingExportsController extends Controller
{
    /**show the upload view */
    public function index()
    {
        return view('upload_file');
    }

    public function storeFileDetails()
    {
        if (request()->has('csvfile')) {

            $arrmixFileContents = file(request()->csvfile);
            // chunk the files
            $arrmixFilesChunks = array_chunk($arrmixFileContents, 1000);
            $arrstrHeader = [];

            // create an empty batch and dispatch
            $batch = Bus::batch([])->dispatch();

            foreach ($arrmixFilesChunks as $index => $arrmixFileChunks) {
                $arrmixFileContentsUploaded = array_map('str_getcsv', $arrmixFileChunks);
                if ($index === 0) {
                    $arrstrHeader = $arrmixFileContentsUploaded[0];
                    unset($arrmixFileContentsUploaded[0]);
                }
                // add the job in batch
                $batch->add(new ExportsCsvFile($arrmixFileContentsUploaded, $arrstrHeader));
            }
        } else {
            return response()->json('File was not selected for upload');
        }

        return response()->json(['id' => $batch->id]);
    }

    /*** 
    get the batch details
     ***/
    public function batch()
    {
        $intBatchId = request('id');
        return response()->json(Bus::findBatch($intBatchId));
    }
}
