<?php

class LinkRecord
{
    public function __construct(
        public string $url, 
        public string $description
    ) {}
}

function processLine(string $line): LinkRecord {
    [$url, $description] = explode(';', $line);
    return new LinkRecord($url, $description);
}

function getLinks(): array {
    $lines = file_get_contents('./links.txt');
    $links = [];

    if ($lines !== false) {
        foreach (explode("\n", $lines) as $line) {
            $line = trim($line);
            $links[] = processLine($line);
        }
    }

    return $links;
}

$links = getLinks();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Zadanie 4</title>
</head>
<body>
    <ul>
        <?php foreach ($links as $link): ?>
            <li>
                <p>
                    <a href="<?= $link->url ?>" target="_blank"><?= $link->url ?></a>
                    &middot; <?= $link->description ?>
                </p>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>


