<?php

use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Your\Form\LoginType;

class LoginFormTest extends KernelTestCase
{
    private $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
        parent::__construct();
    }

    protected function setUp(): void
    {
        $kernel = self::bootKernel();

        $container = $kernel->getContainer();
        $this->formFactory = $container->get('form.factory');
    }

    public function testLoginFormSubmission()
    {
        $formData = [
            'username' => 'testuser',
            'password' => 'testpassword',
        ];

        $form = $this->formFactory->create(LoginFormAuthenticator::class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertTrue($form->isValid());
    }
}
