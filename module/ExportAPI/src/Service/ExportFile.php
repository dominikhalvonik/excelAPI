<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.05.2017
 * Time: 10:02
 */

namespace ExportAPI\Service;

use ExportAPI\Model\ManageFiles;
use PHPExcel;
use PHPExcel_Worksheet_PageSetup;
use PHPExcel_Cell_DataType;
use PHPExcel_Worksheet;
use PHPExcel_Writer_Excel5;
use PHPExcel_Exception;

class ExportFile
{
    /**
     * @var \ExportAPI\Model\ManageFiles $fileManageModel
     */
    private $fileManageModel;

    /**
     * @var \PHPExcel $excel
     */
    private $excel;

    /**
     * Create an object of ExportFile
     *
     * @param  ManageFiles $fileManageModel
     * @return object
     *
     * @access public
     */
    public function __construct(ManageFiles $fileManageModel)
    {
        //\ExportAPI\Model\ManageFiles for database operations
        $this->fileManageModel = $fileManageModel;
        //\PHPExcel for creation of XLS file
        $this->excel = new PHPExcel();
    }

    /**
     * Create XLS file base on array input
     *
     * @param  array  $fileData
     * @param  string $path
     * @param  string $clientId     client id from OAuth
     *
     * @return string
     * @throws PHPExcel_Exception if unable to create file
     *
     * @access public
     */
    public function createFile(array $fileData, string $path = "", string $clientId): string
    {
        //set basic style for document
        $this->excel->getActiveSheet()->getPageMargins()->setTop(0.8);
        $this->excel->getActiveSheet()->getPageMargins()->setRight(0.8);
        $this->excel->getActiveSheet()->getPageMargins()->setLeft(0.8);
        $this->excel->getActiveSheet()->getPageMargins()->setBottom(0.8);
        //init sheet index that represents which sheet we are on
        $sheetIndex = 0;
        //create default file name
        $fileName = "export_".time()."_".mt_rand(0, 1000).".xls";
        //loop sheets
        foreach ($fileData['sheets'] as $sheetKey => $sheetName) {
            //if $sheetIndex is 0 that means we are currently on the 1 sheet
            if ($sheetIndex == 0) {
                //set sheets name
                $currentDocument = $this->excel->getActiveSheet()->setTitle($sheetName);
            } else {
                //create next sheet and set sheets name
                $currentDocument = $this->excel->createSheet($sheetIndex);
                $currentDocument->setTitle($sheetName);
            }
            //set layout style
            $currentDocument->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
            $currentDocument->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
            $currentDocument->getPageSetup()->setFitToPage(true);
            $currentDocument->getPageSetup()->setFitToWidth(1);
            $currentDocument->getPageSetup()->setFitToHeight(0);
            //add file name to footer
            if(isset($fileData['name'])) {
                $fileName = $fileData['name'].".xls";
                $currentDocument->getHeaderFooter()->setOddHeader($fileData['name']);
            } else {
                $currentDocument->getHeaderFooter()->setOddHeader($fileName);
            }
            //set trade mark to footer
            $currentDocument->getHeaderFooter()->setOddFooter('© ' . date('Y') . ' Just Data Systems Ltd - Prism WMS ');
            //column index init
            $col = 0;
            //loop spreadsheet header data
            foreach($fileData['headers'][$sheetKey] as $headerName => $headerOptions) {
                //set header value to sheet
                $currentDocument->setCellValueByColumnAndRow($col, 1, $headerName);
                //if is font size(bold etc.) is set, set it
                if(isset($headerOptions['font-size'])) {
                    $this->setFontStyle($headerOptions['font-size'], $col, 1, $currentDocument);
                }
                //set auto-resizing for cells in this column(example A, B etc.)
                $currentDocument->getColumnDimensionByColumn($col)->setAutoSize(true);
                //init row index for this column
                $row = 1;
                //loop spreadsheet data for current header
                foreach ($fileData['data'][$sheetKey][$headerName] as $dataValue => $dataOptions) {
                    //set data type for cell
                    if(isset($dataOptions['type'])) {
                        $dataType = $this->getCellDataType($dataOptions['type']);
                        $currentDocument->getCellByColumnAndRow($col, $row)->setValueExplicit($dataValue, $dataType);
                    } else {
                        $currentDocument->getCellByColumnAndRow($col, $row)->setValueExplicit($dataValue, PHPExcel_Cell_DataType::TYPE_STRING);
                    }
                    //move to next row
                    $row++;
                }
                //move to next column
                $col++;
            }
            //move to next sheet
            $sheetIndex++;
        }
        //set active sheet(the one that will be open when user open the document) to first one
        $this->excel->setActiveSheetIndex(0);
        try {
            //create folders for file upload
            $this->prepareUploadSpace($path);
            //save file to prepred folder
            $objWriter = new PHPExcel_Writer_Excel5($this->excel);
            $objWriter->save($path.$fileName);
            //add record to database
            $this->fileManageModel->createFileRecord($clientId, $path.$fileName);
            //return files base path
            return $path.$fileName;
        } catch (PHPExcel_Exception $exception) {
            throw $exception;
        }

    }

    /**
     * Return correct cell data type
     *
     * @param  string $type
     *
     * @return string
     *
     * @access private
     */
    private function getCellDataType(string $type)
    {
        switch ($type) {
            case "string":
                return PHPExcel_Cell_DataType::TYPE_STRING;
                break;
            case "number":
                return PHPExcel_Cell_DataType::TYPE_NUMERIC;
                break;
            default:
                return PHPExcel_Cell_DataType::TYPE_STRING;
        }
    }

    /**
     * Set font style for given cell
     *
     * @param  string               $fontStyle    bold
     * @param  int                  $col          column index
     * @param  int                  $row          row index
     * @param  PHPExcel_Worksheet   $sheetObject
     *
     * @return string
     *
     * @access private
     */
    private function setFontStyle(string $fontStyle, int $col, int $row, PHPExcel_Worksheet $sheetObject)
    {
        switch($fontStyle) {
            case "bold":
                $sheetObject->getCellByColumnAndRow($col, $row)->getStyle()->getFont()->setBold(true);
                break;
            default:
                $sheetObject->getCellByColumnAndRow($col, $row)->getStyle()->getFont()->setBold(false);
        }
    }

    /**
     * Prepera folder structure for file if not exists
     *
     * @param  string $path
     *
     * @return void
     * @throws Exception if unable to create directory
     *
     * @access private
     */
    private function prepareUploadSpace(string $path)
    {
        if(!file_exists($path)) {
            $mkdir = mkdir($path, 0777, true);
            if(!$mkdir) {
                throw new \Exception("Unable to create directory ".$path, 500);
            }
        }
    }
}