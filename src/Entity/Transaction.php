<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @ApiResource(
 *     collectionOperations={
 *      "get"={
 *          "normalization_context"={"groups"={"transaction_read"}}
 *          },
 *      "post"
 *     },
 *     itemOperations={
 *          "get"={
 *              "normalization_context"={
 *                  "groups"={"transaction_details_read"}
 *               }
 *          },
 *          "put",
 *          "patch",
 *          "delete"
 *     }
 * )
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user_details_read","sejour_details_read","transaction_read","transaction_details_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"user_details_read","sejour_details_read","transaction_read","transaction_details_read"})
     */
    private $date_transaction;

    /**
     * @ORM\Column(type="float")
     * @Groups({"user_details_read","sejour_details_read","transaction_read","transaction_details_read"})
     */
    private $montant;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"user_details_read","sejour_details_read","transaction_read","transaction_details_read"})
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"user_details_read","sejour_details_read","transaction_read","transaction_details_read"})
     */
    private $date_maj;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction_details_read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Sejour::class, inversedBy="transactions")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"transaction_details_read"})
     */
    private $sejour;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateTransaction(): ?\DateTimeInterface
    {
        return $this->date_transaction;
    }

    public function setDateTransaction(\DateTimeInterface $date_transaction): self
    {
        $this->date_transaction = $date_transaction;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateMaj(): ?\DateTimeInterface
    {
        return $this->date_maj;
    }

    public function setDateMaj(?\DateTimeInterface $date_maj): self
    {
        $this->date_maj = $date_maj;

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

    public function getSejour(): ?Sejour
    {
        return $this->sejour;
    }

    public function setSejour(?Sejour $sejour): self
    {
        $this->sejour = $sejour;

        return $this;
    }
}
