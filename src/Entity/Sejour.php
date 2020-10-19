<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\SejourRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=SejourRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *      "get"={
 *          "normalization_context"={"groups"={"sejour_read"}}
 *          },
 *      "post"
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={"sejour_details_read"}
 *               }
 *          },
 *          "put",
 *          "patch",
 *          "delete"
 *     }
 * )
 */
class Sejour
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_read","user_details_read","sejour_read","sejour_details_read","transaction_details_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Groups({"user_read","user_details_read","sejour_read","sejour_details_read","transaction_details_read"})
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Groups({"user_read","user_details_read","sejour_read","sejour_details_read","transaction_details_read"})
     */
    private $prix;

    /**
     * @ORM\Column(type="float")
     * @Groups({"user_read","user_details_read","sejour_read","sejour_details_read","transaction_details_read"})
     */
    private $somme_reglee;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user_read","user_details_read","sejour_read","sejour_details_read","transaction_details_read"})
     */
    private $date_debut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"user_read","user_details_read","sejour_read","sejour_details_read","transaction_details_read"})
     */
    private $date_fin;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="sejours")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"sejour_details_read"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="sejour", orphanRemoval=true)
     * @Groups({"sejour_details_read"})
     */
    private $transactions;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getSommeReglee(): ?float
    {
        return $this->somme_reglee;
    }

    public function setSommeReglee(float $somme_reglee): self
    {
        $this->somme_reglee = $somme_reglee;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setSejour($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getSejour() === $this) {
                $transaction->setSejour(null);
            }
        }

        return $this;
    }
}
