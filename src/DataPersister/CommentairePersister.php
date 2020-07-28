<?php

namespace App\DataPersister;

use App\Entity\Commentaire;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;

class CommentairePersister implements DataPersisterInterface
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data): bool
    {
        return $data instanceof Commentaire;
    }

    public function persist($data)
    {
        //Mettre la date de création et le nom du createur
        $data->setDateCommentaire(new \DateTime());
        $data->setCreatedAt(new \DateTime());
        $data->setCreatedBy($data->getNom());

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