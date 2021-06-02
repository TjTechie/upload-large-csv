<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\AccoutingExports;
use Illuminate\Bus\Batchable;
use Throwable;

class ExportsCsvFile implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $arrmixData;
    public $arrmixHeader;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arrmixData, $arrmixHeader)
    {
        $this->arrmixData = $arrmixData;
        $this->arrmixHeader = $arrmixHeader;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        foreach( $this->arrmixData as $mixData ) {
            $arrmixExportData = array_combine( $this->arrmixHeader, $mixData );
            AccoutingExports::create($arrmixExportData);
        }
       
    }

}
