<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Articles</title>
    <style>
        .image-list {
            list-style: none;
            font-size: 0;
        }
        .image-list li {
            display: inline-block;
            widht: 25%;
        }
        .image-list img {
            widht: 100%;
        }
    </style>
</head>
<body>

    <ul class="image-list">
        <?php foreach($imageList as $image): ?>
            <li>
                <img src="<?=$image?>">
            </li>
        <?php endforeach ?>
    </ul>


    <ul>
        <?php foreach($list as $link): ?>
            <li><a href="<?=$link?>"><?=$link?></a></li>
        <?php endforeach ?>
    </ul>
</body>
</html>