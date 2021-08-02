<?php


class DataFromFile implements IOData
{
  private string $path = '';

  public function __construct(string $path)
  {
    $this->path = $path;
  }

  public function getData() : array
  {
    if (!is_file($this->path)) {
      die('Указанный файл не существует' . PHP_EOL);
    }

    $ext = pathinfo($this->path, PATHINFO_EXTENSION);
    if ($ext !== 'json') {
      die('Принимаются только файлы типа JSON' . PHP_EOL);
    }

    try {
      $data = json_decode(file_get_contents($this->path), true, 512, JSON_THROW_ON_ERROR);
    } catch (Throwable $e) {
      die('Something happened ' . PHP_EOL . $e->getMessage());
    }

    return $data;
  }
}