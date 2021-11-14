<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $title; ?></title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&family=Roboto&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/css/bootstrap.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/template/vendor/fontawesome-free/css/all.min.css">
  <script src="/template/js/swal.js"></script>
</head>

<body>

  <?= $this->renderSection('content'); ?>

  <section id="footer" class="pt-3">
    <footer>
      Copyright <i class="far fa-copyright fa-xs fa-fw"></i> <?= date('Y', time()); ?>
      <br>
      Yapim taruna marelan
    </footer>
  </section>


  <script src="/js/jquery.min.js"></script>
  <script src="/js/jquery.easing.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/main.js"></script>
</body>

</html>