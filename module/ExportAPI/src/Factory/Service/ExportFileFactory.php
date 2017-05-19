<?php
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 05.05.2017
 * Time: 9:55
 */

namespace ExportAPI\Factory\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use ExportAPI\Service\ExportFile;
use ExportAPI\Model\ManageFiles;

class ExportFileFactory implements FactoryInterface
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
        return new ExportFile($manageFilesModel);
    }
}