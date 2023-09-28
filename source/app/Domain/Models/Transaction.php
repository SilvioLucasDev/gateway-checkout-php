<?php

namespace App\Domain\Models;

use App\Domain\Exceptions\InvalidRecordDataException;
use DateTime;

class Transaction
{
  public function __construct(
    public int       $id,
    public string    $type,
    public string    $message,
    public int       $is_identified,
    public ?string   $whistleblower_name,
    public ?string   $whistleblower_birth,
    public ?DateTime $created_at,
    public int       $deleted = 0
  ) {
    $this->checkIdentifiedIsTrue();
  }

  public static function create(
    int     $id,
    string  $type,
    string  $message,
    int     $is_identified,
    ?string $whistleblower_name,
    ?string $whistleblower_birth
  ): Transaction {
    $id = $id + 1;
    $created_at = new DateTime();
    return new Transaction($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, $created_at);
  }

  public static function update(
    int    $id,
    string $type,
    string $message,
    int    $is_identified,
    ?string $whistleblower_name,
    ?string $whistleblower_birth,
  ): Transaction {
    return new Transaction($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, null);
  }

  private function checkIdentifiedIsTrue(): void
  {
    if (isset($this->is_identified)) {
      if ($this->is_identified) {
        if (!isset($this->whistleblower_name)) throw new InvalidRecordDataException("The whistleblower's name must be informed!");
        if (!isset($this->whistleblower_birth)) throw new InvalidRecordDataException('It is necessary to inform the date of birth of the whistleblower!');
      }
    }
  }
}
