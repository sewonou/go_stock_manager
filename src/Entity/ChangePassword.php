<?php

namespace App\Entity;

use App\Repository\ChangePasswordRepository;
use Symfony\Component\Validator\Constraints as Assert;



class ChangePassword
{
    #[Assert\NotBlank(message: "L'ancien mot de passe   est obligatoire")]
    private ?string $oldPassword = null;

    #[Assert\NotBlank(message: "Le mouveau mot de passe  est obligatoire")]
    private ?string $newPassword = null;

    #[Assert\NotBlank(message: "la confirmation du nouveau mot de passe  est obligatoire")]
    #[Assert\EqualTo(propertyPath: "newPassword", message: "Vous n'avez pas correctement confirmé votre mot de passe")]
    private ?string $confirmPassword = null;



    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(?string $oldPassword): static
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(?string $newPassword): static
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(?string $confirmPassword): static
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
