<?php
/**
 * Class Doc Comment
 *
 * PHP version 7.0
 *
 * @category PHP_Class
 * @package  AppBundle
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

/**
 * Class UserType
 *
 * @category PHP_Class
 * @package  AppBundle\Form\Type
 * @author   trinhvo <ttvdep@gmail.com>
 * @license  License Name
 * @link     Link Name
 */
class UserType extends AbstractType
{
    /**
     * Function buildForm User
     *
     * @param FormBuilderInterface $builder Some argument description
     * @param array                $options Some argument description
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => "Nom d'utilisateur"])
            ->add(
                'password',
                RepeatedType::class,
                [
                'type'              => PasswordType::class,
                'invalid_message'   =>
                    'Les deux mots de passe doivent correspondre.',
                'required'          => true,
                'first_options'     => ['label' => 'Mot de passe'],
                'second_options'    => [
                    'label' => 'Tapez le mot de passe à nouveau'],
                ]
            )
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'label'     => 'Type de compte',
                    'choices'   => [
                        'User'  => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN'],
                    'expanded'  => true,
                    'multiple'  => true,
                    'required'  => true,
                ]
            );
    }
}
