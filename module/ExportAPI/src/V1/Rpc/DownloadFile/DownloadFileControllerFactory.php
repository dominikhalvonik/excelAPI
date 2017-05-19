<?php
namespace ExportAPI\V1\Rpc\DownloadFile;

class DownloadFileControllerFactory
{
    public function __invoke($controllers)
    {
        $downloadFile = $controllers->get(\ExportAPI\Service\DownloadFile::class);
        return new DownloadFileController($downloadFile);
    }
}
