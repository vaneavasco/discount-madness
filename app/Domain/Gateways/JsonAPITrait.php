<?php

namespace App\Domain\Gateways;

trait JsonAPITrait
{
    protected function getData(string $fileName, array $filters = []): array
    {
        $jsonData = $this->readJsonData($fileName);

        return $this->filterData($jsonData, $filters);
    }

    protected function readJsonData(string $fileName): array
    {
        $fileContents = file_get_contents(storage_path('app/jsondata/' . $fileName . '.json'));

        return json_decode($fileContents, true);
    }

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