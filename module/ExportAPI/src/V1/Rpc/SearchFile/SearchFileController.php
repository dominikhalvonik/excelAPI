<?php
namespace ExportAPI\V1\Rpc\SearchFile;

use Zend\Mvc\Controller\AbstractActionController;
use ExportAPI\Model\ManageFiles;

class SearchFileController extends AbstractActionController
{
    /**
     * @var \ExportAPI\Model\ManageFiles $manageFilesModel
     */
    private $manageFilesModel;

    /**
     * Create an object of SearchFileController
     *
     * @param  ManageFiles manageFilesModel
     * @return object
     *
     * @access public
     */
    public function __construct(ManageFiles $manageFilesModel)
    {
        $this->manageFilesModel = $manageFilesModel;
    }

    /**
     * RPC method that base on GET param will return all matching files for
     * user that identifies his self via OAuth
     *
     * @return json
     *
     * @access public
     */
    public function searchFileAction()
    {
        //get project URI, example http://test.prism-servers.co.uk:80
        $uri = $this->getRequest()->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $port = $uri->getPort();
        //get file name from URL s GET param
        $fileName = $this->params()->fromRoute('fileName', "");
        //get client ID from OAuth
        $clientId = $this->getIdentity()->getAuthenticationIdentity()['client_id'];
        //get all files that match the criteria
        $files = $this->manageFilesModel->getFilePathByName($clientId, $fileName);
        //init response array
        $response = [];
        //loop the files
        foreach ($files as $file) {
            //prepare download service URL with file ID
            $serviceUrl = $this->url()->fromRoute('export-api.rpc.download-file', array("fileID" => $file->getId()));
            //add file download URL to response array
            $response[basename($file->getFilepath())] = $scheme."://".$host.":".$port.$serviceUrl;
        }

        return $response;
    }
}
