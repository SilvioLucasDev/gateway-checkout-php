<?php

namespace App\Domain\Models;

use App\Domain\Exceptions\InvalidRecordDataException;
use DateTime;

class Record
{
  public function __construct(
    public int       $id,
    public ?string    $type,
    public ?string    $message,
    public ?int       $is_identified,
    public ?string    $whistleblower_name,
    public ?string    $whistleblower_birth,
    public ?DateTime $created_at,
    public ?int       $deleted = 0
  ) {
    $this->checkWhistleblowerIsIdentified();
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
    int     $id,
    ?string $type,
    ?string $message,
    ?int    $is_identified,
    ?string $whistleblower_name,
    ?string $whistleblower_birth,
  ): Record {
    return new Record($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, null);
  }

  private function checkWhistleblowerIsIdentified(): void
  {
    if (isset($this->is_identified)) {
      if ($this->is_identified === 1 || $this->is_identified === '1') {
        if (!isset($this->whistleblower_name)) {
          throw new InvalidRecordDataException("The whistleblower's name must be informed!");
        }
        if (!isset($this->whistleblower_birth)) {
          throw new InvalidRecordDataException("It is necessary to inform the date of birth of the whistleblower!");
        }
      } else {
        $this->whistleblower_name = '';
        $this->whistleblower_birth = '';
      }
    }
  }
}
