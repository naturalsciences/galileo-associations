<?php
/**
 * Created by PhpStorm.
 * User: duchesne
 * Date: 3/11/16
 * Time: 10:25
 */

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Doctrine\Common\Annotations;

/** @Annotations */
class CorrectDates extends Constraint
{
    public function validatedBy()
    {
        return 'correct_dates';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
