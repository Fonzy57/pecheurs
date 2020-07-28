<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 * @ApiResource(
 *      attributes={
 *          "order"={"createdAt":"DESC"}
 *      },
 *      normalizationContext={"groups"={"read:commentaire"}},
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class,
 *      properties={"post": "exact"}
 * )
 */
class Commentaire
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:commentaire"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:commentaire"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:commentaire"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:commentaire"})
     */
    private $contenu_commentaire;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read:commentaire"})
     */
    private $date_commentaire;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="commentaires")
     * @Groups({"read:commentaire"})
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getContenuCommentaire(): ?string
    {
        return $this->contenu_commentaire;
    }

    public function setContenuCommentaire(string $contenu_commentaire): self
    {
        $this->contenu_commentaire = $contenu_commentaire;

        return $this;
    }

    public function getDateCommentaire(): ?\DateTimeInterface
    {
        return $this->date_commentaire;
    }

    public function setDateCommentaire(\DateTimeInterface $date_commentaire): self
    {
        $this->date_commentaire = $date_commentaire;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
