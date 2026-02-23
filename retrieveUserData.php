<?php
$stmt = $db->prepare("SELECT adg_users.*, adg_users_status.status
                      FROM adg_users
                      INNER JOIN adg_users_status ON adg_users.id_status = adg_users_status.id
                      WHERE adg_users.id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>