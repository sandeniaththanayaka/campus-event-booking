
<?php
session_start();
include 'includes/db.php';
session_unset();     // session variables මකනවා
session_destroy();   // session එක විනාශ කරනවා
header('Location: index.php');
exit;