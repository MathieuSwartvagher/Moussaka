<?php

namespace App\Artists\Infrastructure\Symfony\Form;


use App\Artists\Infrastructure\Symfony\Model\Album;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class AlbumType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $user = $this->security->getUser();
        $artists = $user->getMyArtists();
        $artistChoices = [];
        foreach ($artists as $artist) {
            $artistChoices[$artist->getName()] = $artist;
        }        
        $builder
            ->add('name')
            ->add('artist', ChoiceType::class, [
                'choices' => $artistChoices,
                'label' => 'Choisissez une option',
                'required' => true,
            ]);    
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
