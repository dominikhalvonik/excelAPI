<?php
namespace ExportAPI\V1\Rpc\ExportXls;

use ExportAPI\Model\ManageFiles;

class ExportXlsControllerFactory
{
    public function __invoke($controllers)
    {
        $exportFile = $controllers->get(\ExportAPI\Service\ExportFile::class);
        $manageFilesModel = $controllers->get(ManageFiles::class);
        return new ExportXlsController($exportFile, $manageFilesModel);
    }
}
