<?php
session_start();
session_unset();     // session variables මකනවා
session_destroy();   // session එක විනාශ කරනවා
header('Location: index.php');
exit;