<?php

namespace ExportAPI\Interfaces;

/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 18.05.2017
 * Time: 13:20
 */

interface ManageFilesInterface
{
    /**
     * Create record in database that given file was stored on the server
     *
     * @param  string $clientId     client id from OAuth
     * @param  string $filePath
     *
     * @return void
     *
     * @access public
     */
    public function createFileRecord(string $clientId, string $filePath);

    /**
     * Return array of File objects that match the file name criteria
     *
     * @param  string $clientId     client id from OAuth
     * @param  string $fileName
     *
     * @return array
     *
     * @access public
     */
    public function getFilePathByName(string $clientId, string $fileName);

    /**
     * Return array of File objects that match the ID criteria
     *
     * @param  string $clientId     client id from OAuth
     * @param  string $fileId
     *
     * @return array
     *
     * @access public
     */
    public function getFilePathById(string $clientId, string $fileId);

    /*
    public function deleteFileRecord($fileName);
    */
}