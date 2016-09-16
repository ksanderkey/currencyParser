<!-- srs/Resources/views/base.html.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Мониторинг индексов</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="/css/style.css">
</head>
</head>
<body>
<div class="container">
    <section id="currency-dushboard">
        <header class="text-center">
            <h1>Мониторинг индексов</h1>
        </header>
        <ul class="currency-list">
            <?php foreach ($currency as $name => $cur): ?>
                <li>
                    <span class="icon-<?= $name ?>"><span class="path1"></span><span class="path2"></span><span
                            class="path3"></span><span class="path4"></span></span>
                    <span class="value"><?= $cur ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</div>
</body>
</html>