<?php
namespace ExportAPI\V1\Rpc\DownloadFile;

use Zend\Mvc\Controller\AbstractActionController;
use ExportAPI\Service\DownloadFile;

class DownloadFileController extends AbstractActionController
{
    /**
     * @var \ExportAPI\Service\DownloadFile $downloadFile
     */
    private $downloadFile;

    /**
     * Create an object of DownloadFileController
     *
     * @param  DownloadFile $downloadFile
     * @return object
     *
     * @access public
     */
    public function __construct(DownloadFile $downloadFile)
    {
        //\ExportAPI\Service\DownloadFile for file download
        $this->downloadFile = $downloadFile;
    }

    /**
     * RPC method that gets file ID and return data stream
     *
     * @return \Zend\Http\Response\Stream
     *
     * @access public
     */
    public function downloadFileAction()
    {
        //get client id
        $clientId = $this->getIdentity()->getAuthenticationIdentity()['client_id'];
        //get file id as GET param
        $fileId = $this->params()->fromRoute('fileID', "");
        //get requested file
        $response = $this->downloadFile->downloadFile($clientId, $fileId);

        return $response;
    }
}
