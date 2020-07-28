<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;

class PostPersister implements DataPersisterInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data): bool
    {
        return $data instanceof Post;
    }

    public function persist($data)
    {
        //Mettre la date de création et le nom du createur
        $data->setCreatedAt(new \DateTime());
        $data->setCreatedBy($data->getNomAuteur());

        //Demande à doctrine de persister et d'insérer en BDD
        $this->em->persist($data);
        $this->em->flush();


    }

    public function remove($data)
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}