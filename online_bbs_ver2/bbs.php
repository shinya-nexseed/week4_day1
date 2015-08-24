<?php
    $db = mysqli_connect('localhost', 'root', 'mysql', 'online_bbs_ver2') or die(mysqli_connect_error());
    mysqli_set_charset($db, 'utf8');
?>

<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = mysqli_real_escape_string($db, $_POST['name']);
        $comment = mysqli_real_escape_string($db, $_POST['comment']);

        $sql = sprintf('INSERT INTO messages SET name="%s", comment="%s", created_at="%s" ',
            $name,
            $comment,
            date('Y-m-d H:i:s')
        );
        mysqli_query($db, $sql);
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ひとこと掲示版</title>
  <!-- cssの読み込み -->
  <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" type="text/css" href="assets/font-awesome/css/font-awesome.css">
</head>
<body>
  <h1>ひとこと掲示版</h1>
  <form action="bbs.php" method="post">
    名前: <input type="text" name="name"><br>
    ひとこと: <input type="text" name="comment" size="60"><br>
    <input type="submit" name="submit" value="送信">
  </form>
  <?php
      $sql = 'SELECT * FROM `messages` ORDER BY `created_at` DESC';
      $results = mysqli_query($db, $sql) or die(mysqli_error($db));
      echo count($results);
  ?>
  <ul>
    <?php while ($message = mysqli_fetch_assoc($results)): ?>
    <li><?php echo $message['name'] ?>: <?php echo $message['comment'] ?></li>
    <?php endwhile; ?>
  </ul>
</body>
</html>
