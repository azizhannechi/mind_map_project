<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Détail de l objectif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
<div class="container">
    <h1 class="mb-4">Objectif : <?php echo e($objectif->titre); ?></h1>

    <div class="card shadow-sm p-4">
        <h4>Lieu : <?php echo e($objectif->lieu); ?></h4>
        <p><strong>Description :</strong> <?php echo e($objectif->description); ?></p>
        <p><strong>Slug :</strong> <?php echo e($objectif->slug); ?></p>
        <a href="<?php echo e(url('/map')); ?>" class="btn btn-primary mt-3">Retour à la carte</a>
    </div>
</div>
</body>
</html><?php /**PATH E:\mind_map_project\mind_map_project\resources\views/objectif.blade.php ENDPATH**/ ?>