<?php

namespace App\Entity;

use App\Repository\NewsletterSubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterSubscriptionRepository::class)]
class NewsletterSubscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
      private ?string $email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

       public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
}

