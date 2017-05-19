<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 19.05.2017
 * Time: 10:41
 */

namespace ExportAPI\Service;

use ExportAPI\Model\ManageFiles;
use Zend\Http\Response\Stream;
use Zend\Http\Headers;

class DownloadFile
{
    /**
     * @var \ExportAPI\Model\ManageFiles $fileManageModel
     */
    private $fileManageModel;

    /**
     * @var \Zend\Http\Response\Stream $stream
     */
    private $stream;

    /**
     * @var \Zend\Http\Headers $headers
     */
    private $headers;

    /**
     * Create an object of DownloadFile
     *
     * @param  ManageFiles $fileManageModel
     * @return object
     *
     * @access public
     */
    public function __construct(ManageFiles $fileManageModel, Stream $stream, Headers $headers)
    {
        //\ExportAPI\Model\ManageFiles for database operations
        $this->fileManageModel = $fileManageModel;
        //\Zend\Http\Response\Stream for file streaming
        $this->stream = $stream;
        //\Zend\Http\Headers for changing HTTP headers
        $this->headers = $headers;

    }

    /**
     * Get XLS file from server and return it as response
     *
     * @param  string $clientId     client id from OAuth
     * @param  string $fileId
     *
     * @return \Zend\Http\Response\Stream
     *
     * @access public
     */
    public function downloadFile(string $clientId, string $fileId): Stream
    {
        //get File object from database
        $file = $this->fileManageModel->getFilePathById($clientId, $fileId);
        //init PHP finfo object for file informations
        $finfo = new \finfo(FILEINFO_MIME);
        //open file and set HTTP stream
        $this->stream->setStream(fopen($file->getFilepath(), 'r'));
        //set HTTP code
        $this->stream->setStatusCode(200);
        //set stream name as file name
        $this->stream->setStreamName(basename($file->getFilepath()));
        //set necessary headers for download
        $this->headers->addHeaders(array(
            'Content-Type'        => $finfo->file($file->getFilepath()),
            'Content-Length'      => filesize($file->getFilepath()),
            'Content-Disposition' => "attachment; filename='".basename($file->getFilepath())."'"
        ));
        $this->stream->setHeaders($this->headers);
        //return HTTP streem with correct headers
        return $this->stream;
    }
}