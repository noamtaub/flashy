<?php

class DataFilter
{
    private $tableData;

    public function __construct(array $tableData)
    {
        $this->tableData = $tableData;
    }

    public function getDataByCol(array $cols): string
    {
        $newData = [$this->getRowOutput($cols)];
        foreach ($this->tableData as $row) {
            $rowData = $this->getRowCols($cols, $row);
            $newData[] = $this->getRowOutput($rowData);
        }
        return implode(PHP_EOL, $newData);
    }

    private function getRowCols(array $cols, array $row): array
    {
        $rowData = [];
        foreach ($cols as $col) {
            $rowData[] = $row[$col];
        }
        return $rowData;
    }

    private function getRowOutput(array $row): string
    {
        return implode(',', $row);
    }
}
