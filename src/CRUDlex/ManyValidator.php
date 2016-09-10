<?php

/*
 * This file is part of the CRUDlex package.
 *
 * (c) Philip Lehmann-Böhm <philip@philiplb.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CRUDlex;

use \Valdi\Validator\ValidatorInterface;

/**
 * A validator to check many.
 */
class ManyValidator implements ValidatorInterface {

    /**
     * {@inheritdoc}
     */
    public function isValid($value, array $parameters) {

        if (in_array($value, [null, ''])) {
            return true;
        }

        $data         = $parameters[0];
        $field        = $parameters[1];
        $manyEntity   = $data->getDefinition()->getManyEntity($field);
        $validIds     = array_keys($data->getIdToNameMap($manyEntity, null));
        $candidateIds = array_column($value, 'id');

        return array_values(array_intersect($validIds, $candidateIds)) == $candidateIds;
    }

    /**
     * {@inheritdoc}
     */
    public function getInvalidDetails() {
        return 'many';
    }

}