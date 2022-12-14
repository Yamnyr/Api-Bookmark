<?php

namespace App\Serialization;


use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;

class UserDeNormalizer implements ContextAwareDenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;

    const ALREADY_CALLED = 'USER_DENORMALIZER_ALREADY_CALLED';

    private UserPasswordHasherInterface $passwordHasher;
    private Security $security;

    public function __construct(UserPasswordHasherInterface $passwordHasher, Security $security)
    {
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }


    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
    {
        if (!isset($context[self::ALREADY_CALLED]) && $type == User::class) {
            return true;
        }
        return false;
    }

    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] == true;
        if (isset($data['password'])){
            $data['password'] == $data['password']->hashPassword();
        }

    }
}
