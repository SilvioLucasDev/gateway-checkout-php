<?php

namespace App\Models;

use DateTime;

class Record
{
  public function __construct(
    public int       $id,
    public ?string    $type,
    public ?string    $message,
    public ?int       $is_identified,
    public ?string   $whistleblower_name,
    public ?string   $whistleblower_birth,
    public ?DateTime $created_at,
    public ?int       $deleted = 0
  ) {
  }

  public static function create(
    int    $id,
    string $type,
    string $message,
    int    $is_identified,
    ?string $whistleblower_name,
    ?string $whistleblower_birth
  ): Record {
    $id = $id + 1;
    $created_at = new DateTime();
    return new Record($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, $created_at);
  }

  public static function update(
    int    $id,
    ?string $type,
    ?string $message,
    ?int    $is_identified,
    ?string $whistleblower_name,
    ?string $whistleblower_birth,
    ?int $deleted
  ): Record {
    return new Record($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, null, $deleted);
  }
}
