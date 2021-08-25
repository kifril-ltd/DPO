<?php

namespace App\Form;

use App\Entity\Book;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Название книги',

                'required' => true
            ])
            ->add('author', TextType::class, [
                'label' => 'Автор',

                'required' => true
            ])
            ->add('cover', FileType::class, [
                'label' => 'Обложка книги',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'maxSizeMessage' => 'Файл не должен превышать {{ limit }}',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Файл может должен иметь одно из следующих расширений {{ types }}',
                    ])
                ],
            ])
            ->add('pdf', FileType::class, [
                'label' => 'Файл с книгой',

                'mapped' => false,

                'required' => false,

                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'maxSizeMessage' => 'Файл не должен превышать {{ limit }}',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Загрузите PDF файл',
                    ])
                ],
            ])
            ->add('readDate', DateType::class, [
                'widget' => 'choice',
                'years' => range(date('Y'), date('Y') - 100),
                'label' => 'Дата прочтения',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
