<?php

namespace App\Domain\Models;

use App\Domain\Exceptions\InvalidRecordDataException;
use DateTime;

class Record
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
  ): Record {
    $id = $id + 1;
    $created_at = new DateTime();
    return new Record($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, $created_at);
  }

  public static function update(
    int    $id,
    string $type,
    string $message,
    int    $is_identified,
    ?string $whistleblower_name,
    ?string $whistleblower_birth,
  ): Record {

    self::checkWhistleblowerIsIdentified($whistleblower_name, $whistleblower_birth, $is_identified);

    return new Record($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, null);
  }

  private static function checkWhistleblowerIsIdentified(?string $whistleblower_name, ?string $whistleblower_birth, int $is_identified): void
  {
    if (isset($whistleblower_name) || isset($whistleblower_birth)) {
      if (!$is_identified) throw new InvalidRecordDataException("An identity must be activated before setting a name or birthday for the whistleblower!");
      if (!isset($whistleblower_name) || empty($whistleblower_name)) throw new InvalidRecordDataException("The whistleblower's name must be informed!");
      if (!isset($whistleblower_birth) || empty($whistleblower_birth)) throw new InvalidRecordDataException("It is necessary to inform the date of birth of the whistleblower!");
    }
  }

  private function checkIdentifiedIsTrue(): void
  {
    if (isset($this->is_identified)) {
      if ($this->is_identified) {
        if (!isset($this->whistleblower_name)) throw new InvalidRecordDataException("The whistleblower's name must be informed!");
        if (!isset($this->whistleblower_birth)) throw new InvalidRecordDataException("It is necessary to inform the date of birth of the whistleblower!");
      } else {
        $this->whistleblower_name = '';
        $this->whistleblower_birth = '';
      }
    }
  }
}
