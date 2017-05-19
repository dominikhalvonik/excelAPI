<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 19.05.2017
 * Time: 10:43
 */

namespace ExportAPI\Factory\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use ExportAPI\Service\DownloadFile;
use ExportAPI\Model\ManageFiles;
use Zend\Http\Response\Stream;
use Zend\Http\Headers;

class DownloadFileFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var \ExportAPI\Model\ManageFiles $manageFilesModel */
        $manageFilesModel = $container->get(ManageFiles::class);
        $stream = new Stream();
        $headers = new Headers();
        return new DownloadFile($manageFilesModel, $stream, $headers);
    }
}