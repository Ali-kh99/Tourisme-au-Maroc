<?php

namespace App\Entity;

use App\Repository\RestoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ville;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=RestoRepository::class)
 * @Vich\Uploadable
 */
class Resto
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    // /**
    //  * @ORM\OneToOne(targetEntity=Marker::class)
    //  */
    // private $marker;

    /**
     * @ORM\Column(type="string", length=150)
     * @var string
     */
    private $imgPath;

    /**
     * @Vich\UploadableField(mapping="resto_path", fileNameProperty="imgPath")
     * @var File
     */
    private $imgPathFile;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Ville", inversedBy="restos")
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=RestoLike::class, mappedBy="resto")
     */
    private $likes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImgPath(): ?string
    {
        return $this->imgPath;
    }

    public function setImgPath(?string $imgPath): self
    {
        $this->imgPath = $imgPath;

        return $this;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->likes = new ArrayCollection();
    }

    /**
     * toString
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getVille(): ?Ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getImgPathFile()
    {
        return $this->imgPathFile;
    }

    /**
     * @param mixed $imgPathFile
     * @throws \Exception
     */
    public function setImgPathFile(File $image = null): void
    {
        $this->imgPathFile = $image;
        if ($image) {
            $this->updatedAt = new \DateTime('now');
        }
    }

     public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|RestoLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(RestoLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setResto($this);
        }

        return $this;
    }

    public function removeLike(RestoLike $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getResto() === $this) {
                $like->setResto(null);
            }
        }

        return $this;
    }
      /** 
    *  @param User $user
    *  @return boolen
    */
    public function isLikedByUser(User $user):bool{
        foreach($this->likes as $like){
            if($like->getUser()===$user)return true;
        }
        return  false ;
      }
}
