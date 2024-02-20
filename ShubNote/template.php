<?php
$pass = password_hash("testt", PASSWORD_BCRYPT);
echo $pass."<br>";
echo var_dump(password_verify("testt", "$2y$10\$sK8KhywBIyVmCWD3ALSaRuswyBc9iRXsXLVwGP5GoBQm9ow5qt0Qq"));
?>