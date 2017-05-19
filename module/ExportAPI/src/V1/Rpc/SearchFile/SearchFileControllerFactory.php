<?php
namespace ExportAPI\V1\Rpc\SearchFile;

use ExportAPI\Model\ManageFiles;

class SearchFileControllerFactory
{
    public function __invoke($controllers)
    {
        $manageFilesModel = $controllers->get(ManageFiles::class);
        return new SearchFileController($manageFilesModel);
    }
}
