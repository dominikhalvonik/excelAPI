<?php

namespace ExportAPITest\V1\Rpc\ExportXls;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Zend\Stdlib\ArrayUtils;
use ExportAPI\V1\Rpc\ExportXls\ExportXlsControllerFactory;
use ExportAPI\Service\ExportFile;
use ExportAPI\Model\ManageFiles;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 19.05.2017
 * Time: 18:22
 */
class ExportXlsControllerFactoryTest extends  AbstractHttpControllerTestCase
{
    /** @var ExportXlsControllerFactory */
    protected $factory;

    /** @var \Prophecy\Prophecy\ObjectProphecy */
    protected $serviceLocator;

    public function setUp()
    {
        // The module configuration should still be applicable for tests.
        // You can override configuration here with test case specific values,
        // such as sample view templates, path stacks, module_listener_options,
        // etc.
        $configOverrides = [
            'module_listener_options' => [
                'config_cache_enabled' => false,
            ],
        ];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $this->serviceLocator = $this->prophesize(ServiceLocatorInterface::class);

        $factory       = new ExportXlsControllerFactory();
        $this->factory = $factory;
    }

    public function testInvoke()
    {
        $exportFile = $this->prophesize(ExportFile::class);
        $this->serviceLocator->get(ExportFile::class)
            ->willReturn($exportFile)
            ->shouldBeCalled();

        $manageFilesModel = $this->prophesize(ManageFiles::class);
        $this->serviceLocator->get(ManageFiles::class)
            ->willReturn($manageFilesModel)
            ->shouldBeCalled();

        $controllerManager = $this->prophesize(ControllerManager::class);
        $controllerManager->getServiceLocator()
            ->wilLReturn($this->serviceLocator)
            ->shouldBeCalled();

        $result = $this->factory->__invoke($controllerManager->reveal());
        $this->assertInstanceOf(ExportXlsControllerFactory::class, $result);
    }
}