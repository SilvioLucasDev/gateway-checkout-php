<?php
class Record
{
  public function __construct(
    readonly int    $id,
    readonly string $type,
    readonly string $message,
    readonly int    $is_identified,
    readonly string $whistleblower_name,
    readonly string $whistleblower_birth,
    readonly string $created_at,
    readonly int    $deleted = 0
  ) {}

    public static function create(
        int    $id,
        string $type,
        string $message,
        int    $is_identified,
        string $whistleblower_name,
        string $whistleblower_birth
    ) {
        $id = $id + 1;
        $created_at = date('Y-m-d H:i:s');
        return new Record($id, $type, $message, $is_identified, $whistleblower_name, $whistleblower_birth, $created_at);
    }
}
