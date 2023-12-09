<?php

namespace App\Tests;

use App\Form\IntCollectionType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;


class IntCollectionTypeTest extends TypeTestCase
{

    /**
     * @dataProvider provideFormInputs
     */
    public function testErrorNumber($input, $expectedErrorCount)
    {
        $form = $this->factory->create(IntCollectionType::class, []);

        $form->submit(['int_array' => $input]);

        $this->assertCount($expectedErrorCount, $form->getErrors(true, true));

    }

    public function testCorrectErrorMessage(): void
    {
        $formData = [
            'int_array' => ['a','b'],
        ];

        $form = $this->factory->create(IntCollectionType::class, []);

        $form->submit($formData);

        $this->assertEquals('This value is not valid.', $form->getErrors(true, true)[0]->getMessage());
    }

    private function provideFormInputs()
    {
     return [
         'null triggers 1 error' => [null, 1],
         'empty triggers 1 error' => [[], 1],
         'only valid values triggers no error' => [[1,2,3], 0],
         'one wrong value amond valid values triggers one error' => [[1,'hi',3], 1],
         '2 values that are all wrong should only trigger 2 errors' => [['hi','there'], 2],
     ];

    }
    protected function getExtensions()
    {
        return [
            new ValidatorExtension(Validation::createValidator()),
        ];
    }}
