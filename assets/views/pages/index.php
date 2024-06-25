<?php

$title = "Home";
require_once __DIR__ . '../../partials/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$pagination = $page;
$page += 1;

?>

<main>
    <h1>Pokedex - Homepage</h1>
    <section>
        <div class="list">
            <?php foreach ($viewPokemon as $pokemon) : ?>
                <div class="pokemon">
                    <div class="pokemon-content">
                        <a href="pokemon?name=<?= $pokemon['name']; ?>">
                            <img src="../../assets/public/img/pokemon/<?= $pokemon['image']; ?>" alt="<?= $pokemon['name']; ?>">
                        </a>
                        <h3><?= sprintf("#%04d", $pokemon['id']); ?></h3>
                        <h2>
                            <a href="pokemon?name=<?= $pokemon['name']; ?>">
                                <?= $pokemon['name']; ?>
                            </a>
                        </h2>
                        <div class="attacks">
                            <?php
                            $attacks = attacksCard($pokemon['id']);
                            foreach ($attacks as $attack) :
                            ?>
                                <div class="attack"><?= $attack['name']; ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php
        if(intval($_SESSION['pageIndex'])!= intval($pagination)) : ?>
        <div class="button" >
            <button><a href="?page=<?= intval($page);?>">More ..</a></button>
        </div>
        <?php endif; ?>
    </section>
</main>
<?php
require_once __DIR__ . '../../partials/footer.php';
?>