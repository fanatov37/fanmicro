<?php

namespace App\Service\Parse;

/**
 * Class CvsParseService
 *
 * @package App\Service\Parse
 */
class CvsParseService implements ParseTypeInterface
{
    /**
     * @param string $filePath
     *
     * @return array|Data[]
     * @throws \App\Exception\ClientTypeNotFoundException
     * @throws \App\Exception\OperationNotFoundException
     */
    public function parseFile(string $filePath) : array
    {
        $operationData = file_get_contents($filePath);
        $operationData = str_getcsv($operationData, "\n");

        $result = [];
        foreach ($operationData as $item) {
            $explodeItem = explode(',', $item);
            $result[] = (new Data())
                ->setDate($explodeItem[0])
                ->setUserId($explodeItem[1])
                ->setClient($explodeItem[2])
                ->setOperation($explodeItem[3])
                ->setAmount($explodeItem[4])
                ->setCurrency($explodeItem[5])
            ;
        }

        return $result;
    }
}
