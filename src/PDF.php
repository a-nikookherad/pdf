<?php

namespace App\Service\PDF;

use Illuminate\Support\Facades\Facade;
use PDF\Contracts\PDFLogicInterface;
use PDF\Logics\PDFLogic;

/**
 * @class  PDF PDFService
 * @method Static PDFLogic render()
 * @method Static PDFLogic download(string $path)
 * @method Static PDFLogic setHtml($html)
 * @method Static PDFLogic setConfig(array $config)
 */
class PDF extends Facade
{
    public static function getFacadeAccessor()
    {
        return resolve(PDFLogicInterface::class);
    }
}
