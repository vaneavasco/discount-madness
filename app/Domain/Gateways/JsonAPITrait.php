<?php

namespace App\Domain\Gateways;

/**
 * Trait JsonAPITrait
 * @package App\Domain\Gateways
 */
trait JsonAPITrait
{
    /**
     * @param string $fileName
     * @param array $filters
     *
     * @return array
     */
    protected function getData(string $fileName, array $filters = []): array
    {
        $jsonData = $this->readJsonData($fileName);

        return $this->filterData($jsonData, $filters);
    }

    /**
     * @param string $fileName
     *
     * @return array
     */
    protected function readJsonData(string $fileName): array
    {
        $fileContents = file_get_contents(storage_path('app/jsondata/' . $fileName . '.json'));

        return json_decode($fileContents, true);
    }

    /**
     * @param array $data
     * @param array $filters
     *
     * @return array
     */
    protected function filterData(array $data, array $filters): array
    {
        return array_filter($data, function ($item) use ($filters) {
            foreach ($filters as $filterKey => $filterValue) {
                if (!array_key_exists($filterKey, $item)) {
                    return false;
                }

                if ($item[$filterKey] != $filterValue) {
                    return false;
                }
            }

            return true;
        });
    }
}