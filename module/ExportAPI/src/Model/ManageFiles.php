<?php

namespace ExportAPI\Model;

use ExportAPI\Interfaces\ManageFilesInterface;
use Doctrine\ORM\EntityManager;
use Application\Entity\Files;
use Application\Entity\OauthClients;
/**
 * Created by PhpStorm.
 * User: Dominik
 * Date: 18.05.2017
 * Time: 13:24
 */
class ManageFiles implements ManageFilesInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager $entityManager
     */
    private $entityManager;

    /**
     * Create an object of ManageFiles
     *
     * @param  EntityManager $entityManager
     * @return object
     *
     * @access public
     */
    public function __construct(EntityManager $entityManager)
    {
        //\Doctrine\ORM\EntityManager for database operations
        $this->entityManager = $entityManager;
    }

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
    public function createFileRecord(string $clientId, string $filePath)
    {
        $client = $this->entityManager->getRepository(OauthClients::class)->find($clientId);

        $fileRecord = new Files();
        $fileRecord->setClient($client);
        $fileRecord->setFilepath($filePath);
        $fileRecord->setCreatedAt(new \DateTime());

        $this->entityManager->persist($fileRecord);
        $this->entityManager->flush();
    }

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
    public function getFilePathByName(string $clientId, string $fileName)
    {
        if(strlen($fileName) > 1) {
            $result = $this->entityManager->getRepository(Files::class)->createQueryBuilder('f')
                ->where('f.client = :client_id')
                ->andWhere('f.filepath LIKE :filePath')
                ->setParameter('client_id', $clientId)
                ->setParameter('filePath', '%'.$fileName.'%')
                ->getQuery()
                ->getResult();
        } else {
            $result = $this->entityManager->getRepository(Files::class)->createQueryBuilder('f')
                ->where('f.client = :client_id')
                ->setParameter('client_id', $clientId)
                ->getQuery()
                ->getResult();
        }

        return $result;
    }

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
    public function getFilePathById(string $clientId, string $fileId)
    {
        $result = $this->entityManager->getRepository(Files::class)->createQueryBuilder('f')
            ->where('f.client = :client_id')
            ->andWhere('f.id = :id')
            ->setParameter('client_id', $clientId)
            ->setParameter('id', $fileId)
            ->getQuery()
            ->getOneOrNullResult();

        return $result;
    }
}