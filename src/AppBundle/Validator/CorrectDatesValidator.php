<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 3/11/16
 * Time: 10:27
 */

namespace AppBundle\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class CorrectDatesValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        $endDate = ($object->getEndDate() === null)?new \DateTime('2069-12-31'):$object->getEndDate();
        if ( $object->getEndDate() !== null && $object->getStartDate() === null ) {
            $this->context->addViolation('app.form.teamsAndProjects.edit.validation.missingStartDate');
        }
        elseif ( $object->getStartDate() > $endDate) {
            $this->context->addViolation('app.form.teamsAndProjects.edit.validation.correctDates');
        }
    }
}
