<?php
namespace ExportAPI\V1\Rpc\ExportXls;

use Zend\Mvc\Controller\AbstractActionController;
use ExportAPI\Service\ExportFile;
use ExportAPI\Model\ManageFiles;

class ExportXlsController extends AbstractActionController
{
    /**
     * @var \ExportAPI\Service\ExportFile $exportFile
     */
    private $exportFile;

    /**
     * @var \ExportAPI\Model\ManageFiles $manageFilesModel
     */
    private $manageFilesModel;

    /**
     * Create an object of ExportXlsController
     *
     * @param  ExportFile $exportFile
     * @return object
     *
     * @access public
     */
    public function __construct(ExportFile $exportFile, ManageFiles $manageFilesModel)
    {
        //\ExportAPI\Service\ExportFile for file export
        $this->exportFile = $exportFile;
        //\ExportAPI\Model\ManageFiles for database file managment
        $this->manageFilesModel = $manageFilesModel;
    }

    /**
     * RPC method that gets JSON data and base on them creates XLS file
     *
     * @return json
     *
     * @access public
     */
    public function exportXlsAction()
    {
        //get request JSON
        $info = $this->getRequest()->getContent();
        //validate requested JSON
        $data = $this->checkJsonFormat($info);
        //init file path for new file
        $path = ROOT_PATH."/data/".date("dmY", time())."/".time()."_".uniqid()."/";
        //get client ID
        $clientId = $this->getIdentity()->getAuthenticationIdentity()['client_id'];
        //create file
        $file = $this->exportFile->createFile($data, $path, $clientId);

        //get project URI, example http://test.prism-servers.co.uk:80
        $uri = $this->getRequest()->getUri();
        $scheme = $uri->getScheme();
        $host = $uri->getHost();
        $port = $uri->getPort();
        //get inserted file data
        $fileData = $this->manageFilesModel->getFilePathByName($clientId, $file);
        $response = [];
        foreach ($fileData as $f) {
            //prepare download service URL with file ID
            $serviceUrl = $this->url()->fromRoute('export-api.rpc.download-file', array("fileID" => $f->getId()));
            //add file download URL to response array
            $response[basename($f->getFilepath())] = $scheme."://".$host.":".$port.$serviceUrl;
        }

        return $response;
    }

    /**
     * Validate the JSON file if it is in correct format
     *
     * @param  string $json
     * @return array
     * @throws Exception JSON string is not valid
     *
     * @access private
     */
    private function checkJsonFormat(string $json): array
    {
        //decode JSON to array
        $data = json_decode($json, true);
        //array must contain array of sheets with at least 1 sheet
        if(!is_array($data['sheets'])) {
            throw new \Exception("There must be at least one spredsheet in request.", 422);
        }
        //array must contain array of headers with at least 1 header value
        if(!is_array($data['headers'])) {
            throw new \Exception("There must be at least one spredsheet in request.", 422);
        }
        //array must contain array of data with at least 1 data value
        if(!is_array($data['data'])) {
            throw new \Exception("There must be at least one spredsheet in request.", 422);
        }
        //return correct array
        return $data;
    }
}
