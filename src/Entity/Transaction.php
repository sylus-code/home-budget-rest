<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $amount;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"transaction_get_list", "payment_get_list"})
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Payment", inversedBy="transactions")
     * @ORM\JoinColumn(nullable=true)
     * @Groups("transaction_get_list")
     */
    private $payment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }
}
