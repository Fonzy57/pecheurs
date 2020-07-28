<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PostRepository;
use ApiPlatform\Core\Annotation\ApiFilter;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ApiResource(
 *      normalizationContext={"groups"={"read:post"}},
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get"}
 * )
 * @ApiFilter(SearchFilter::class,
 *      properties={"commentaire": "exact"}
 * )
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"read:post"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:post"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:post"})
     */
    private $photo_poisson;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read:post"})
     */
    private $taille_poisson;

    /**
     * @ORM\Column(type="float")
     * @Groups({"read:post"})
     */
    private $poids_poisson;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read:post"})
     */
    private $contenu_post;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:post"})
     */
    private $nom_auteur;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read:post"})
     */
    private $prenom_auteur;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="post")
     * @Groups({"read:post"})
     */
    private $commentaires;

    //--------- Les différentes méthodes---------
        public function __construct()
        {
            $this->commentaires = new ArrayCollection();
        }

        public function getId(): ?int
        {
            return $this->id;
        }

        public function getTitre(): ?string
        {
            return $this->titre;
        }

        public function setTitre(string $titre): self
        {
            $this->titre = $titre;

            return $this;
        }

        public function getPhotoPoisson(): ?string
        {
            return $this->photo_poisson;
        }

        public function setPhotoPoisson(string $photo_poisson): self
        {
            $this->photo_poisson = $photo_poisson;

            return $this;
        }

        public function getTaillePoisson(): ?float
        {
            return $this->taille_poisson;
        }

        public function setTaillePoisson(float $taille_poisson): self
        {
            $this->taille_poisson = $taille_poisson;

            return $this;
        }

        public function getPoidsPoisson(): ?float
        {
            return $this->poids_poisson;
        }

        public function setPoidsPoisson(float $poids_poisson): self
        {
            $this->poids_poisson = $poids_poisson;

            return $this;
        }

        public function getContenuPost(): ?string
        {
            return $this->contenu_post;
        }

        public function setContenuPost(string $contenu_post): self
        {
            $this->contenu_post = $contenu_post;

            return $this;
        }

        public function getNomAuteur(): ?string
        {
            return $this->nom_auteur;
        }

        public function setNomAuteur(string $nom_auteur): self
        {
            $this->nom_auteur = $nom_auteur;

            return $this;
        }

        public function getPrenomAuteur(): ?string
        {
            return $this->prenom_auteur;
        }

        public function setPrenomAuteur(string $prenom_auteur): self
        {
            $this->prenom_auteur = $prenom_auteur;

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

        /**
         * @return Collection|Commentaire[]
         */
        public function getCommentaires(): Collection
        {
            return $this->commentaires;
        }

        public function addCommentaire(Commentaire $commentaire): self
        {
            if (!$this->commentaires->contains($commentaire)) {
                $this->commentaires[] = $commentaire;
                $commentaire->setPost($this);
            }

            return $this;
        }

        public function removeCommentaire(Commentaire $commentaire): self
        {
            if ($this->commentaires->contains($commentaire)) {
                $this->commentaires->removeElement($commentaire);
                // set the owning side to null (unless already changed)
                if ($commentaire->getPost() === $this) {
                    $commentaire->setPost(null);
                }
            }

            return $this;
        }
}
