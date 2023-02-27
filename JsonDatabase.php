<?php
  class JsonDatabase
  {
      /**
       * @throws Exception
       */
      public function crateTable(string $tableName): void
      {
          $tableProps = [
              "next_id" => 1,
              "data" => []
          ];
          $this->saveFileData($tableName, $tableProps, true);
      }

      /**
       * @throws Exception
       */
      public function insert(string $tableName, array $data): void
      {

          if (!$this->isAssociativeArray($data)) {
              throw new Exception('Not valid data');
          }
          $tableContent = $this->getDataFile($tableName);
          $id = $tableContent['next_id'];
          $data['id'] = $id;
          $tableContent['next_id']++;
          $tableContent['data'][$id] = $data;
          $this->saveFileData($tableName, $tableContent);
      }

      /**
       * @throws Exception
       */
      public function insertMulti(string $tableName, array $data): void
      {
          if ($this->isAssociativeArray($data)) {
              throw new Exception('Not valid data');
          }
          foreach ($data as $row) {
              $this->insert($tableName, $row);
          }
      }

      /**
       * @throws Exception
       */
      public function delete(string $tableName, int $id): void
      {
          $tableContent = $this->getDataFile($tableName);
          if (!$tableContent['data'][$id]) {
              throw new Exception('Not found id');
          }
          unset($tableContent['data'][$id]);
          $this->saveFileData($tableName, $tableContent);

      }

      /**
       * @throws Exception
       */
      public function findAll(string $tableName): array
      {
          $tableContent = $this->getDataFile($tableName);
          return $tableContent['data'];

      }

      /**
       * @throws Exception
       */
      public function find(string $tableName, int $id): array
      {
          $tableContent = $this->getDataFile($tableName);
          if (!$tableContent['data'][$id]) {
              throw new Exception('Not found id');
          }
          return $tableContent['data'][$id];
      }

      /**
       * @throws Exception
       */
      public function update(string $tableName, int $id, array $newData): void
      {
          $tableContent = $this->getDataFile($tableName);
          $row = $tableContent['data'][$id];
          if (!$row) {
              throw new Exception('Not found row');
          }
          $tableContent['data'][$id] = $newData;
          $tableContent['data'][$id]['id'] = $id;
          $this->saveFileData($tableName, $tableContent);
      }

      /**
       * @throws Exception
       */
      private function getDataFile(string $tableName): array
      {
          $filePath = $this->getTablePath($tableName);
          if (!file_exists($filePath)) {
              throw new Exception('Table not found');
          }
          $tableContent = file_get_contents($filePath);
          return json_decode($tableContent, true);
      }

      /**
       * @throws Exception
       */
      private function saveFileData(string $tableName, array $data, bool $isCreateTable = false): void
      {
          $tablePath = $this->getTablePath($tableName);
          $isFileExist = file_exists($tablePath);
          if ($isFileExist && $isCreateTable) {
              throw new Exception("Table already exist");
          }
          if (!$isFileExist && !$isCreateTable) {
              throw new Exception("Table not exist");
          }
          file_put_contents($tablePath, json_encode($data));
      }

      /**
       * @throws Exception
       */
      private function getTablePath(string $tableName): string
      {
          if (!$tableName) {
              throw new Exception('Table name not valid');
          }
          $tableFolder = __DIR__ . "/tables";
          if (!is_dir($tableFolder)) {
              mkdir($tableFolder);
          }
          return "$tableFolder/$tableName.json";
      }

      private function isAssociativeArray(array $arr): bool
      {
          if (empty($arr)) {
              return false;
          }
          return array_keys($arr) !== range(0, count($arr) - 1);
      }

  }
