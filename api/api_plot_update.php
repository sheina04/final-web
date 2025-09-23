<?php
// api/api_plot_update.php
require __DIR__ . '/api_bootstrap.php';
require __DIR__ . '/api_db.php';

try {
  // Accept JSON or form-data
  $input = $_POST;
  if (empty($input)) {
    $raw = file_get_contents('php://input');
    if ($raw) { $j = json_decode($raw, true); if (is_array($j)) $input = $j; }
  }

  $plot_code          = trim($input['plot_code'] ?? '');
  if ($plot_code === '') { json_err('plot_code is required', 400); exit; }

  $status             = $input['status'] ?? null;                     // available | occupied | reserved
  $reserved_for       = trim($input['reserved_for'] ?? '') ?: null;
  $reservation_expiry = trim($input['reservation_expiry'] ?? '') ?: null; // YYYY-MM-DD or ''
  $notes              = trim($input['notes'] ?? '') ?: null;

  // optional owner block (create/find owner then attach to plot)
  $owner_name   = trim($input['owner_name'] ?? '');
  $owner_email  = trim($input['owner_email'] ?? '');
  $owner_phone  = trim($input['owner_phone'] ?? '');
  $owner_addr   = trim($input['owner_address'] ?? '');
  $purchase_date= trim($input['purchase_date'] ?? '');

  $pdo->beginTransaction();

  // 1) Upsert owner if provided
  $owner_id = null;
  if ($owner_name !== '') {
    // Try to find existing owner by (name,email) combo if email exists, else by name only.
    if ($owner_email !== '') {
      $q = $pdo->prepare("SELECT id FROM owners WHERE name=? AND email=? LIMIT 1");
      $q->execute([$owner_name, $owner_email]);
      $owner_id = $q->fetchColumn();
    } else {
      $q = $pdo->prepare("SELECT id FROM owners WHERE name=? LIMIT 1");
      $q->execute([$owner_name]);
      $owner_id = $q->fetchColumn();
    }

    if (!$owner_id) {
      $ins = $pdo->prepare("
        INSERT INTO owners (name, contact, email, address, purchase_date)
        VALUES (?,?,?,?,NULLIF(?,''))");
      $ins->execute([
        $owner_name,
        $owner_phone ?: null,
        $owner_email ?: null,
        $owner_addr ?: null,
        $purchase_date
      ]);
      $owner_id = (int)$pdo->lastInsertId();
    } else {
      // Update basic fields when provided
      $upd = $pdo->prepare("
        UPDATE owners
           SET contact = COALESCE(NULLIF(?,''), contact),
               email   = COALESCE(NULLIF(?,''), email),
               address = COALESCE(NULLIF(?,''), address),
               purchase_date = COALESCE(NULLIF(?,''), purchase_date)
         WHERE id = ?");
      $upd->execute([$owner_phone, $owner_email, $owner_addr, $purchase_date, $owner_id]);
    }
  }

  // 2) Update plot
  $sql = "UPDATE plots
             SET status = COALESCE(?, status),
                 reserved_for = ?,
                 reservation_expiry = NULLIF(?, ''),
                 notes = ?,
                 owner_id = ".($owner_id ? (int)$owner_id : "owner_id")."
           WHERE plot_code = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    $status,
    $reserved_for,
    $reservation_expiry,
    $notes,
    $plot_code
  ]);

  if ($stmt->rowCount() === 0) {
    // If plot didn’t exist, create it (optional, remove if not desired)
    $ins = $pdo->prepare("
      INSERT INTO plots (plot_code, status, reserved_for, reservation_expiry, notes, owner_id)
      VALUES (?, COALESCE(?, 'available'), ?, NULLIF(?, ''), ?, ?)
    ");
    $ins->execute([
      $plot_code,
      $status,
      $reserved_for,
      $reservation_expiry,
      $notes,
      $owner_id
    ]);
  }

  $pdo->commit();
  json_ok(['ok'=>true, 'plot_code'=>$plot_code, 'owner_id'=>$owner_id]);

} catch (Throwable $e) {
  if ($pdo->inTransaction()) $pdo->rollBack();
  json_err($e->getMessage(), 500);
}
