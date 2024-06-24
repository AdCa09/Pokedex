<?php
$title = "Home";
require_once __DIR__ . '../../partials/header.php';

//display Pokemon
$viewPokemon = displayPokemon();

?>

<main>
    <h1>Pokedex - Homepage</h1>
    <section>
        <div class="list">
            <?php foreach ($viewPokemon as $pokemon): ?>
            <div class="pokemon">
                <div class="pokemon-content"><img src="../../assets/public/img/pokemon/<?= $pokemon['image'];?>" alt="<?= $pokemon['name'];?>" srcset="">
                    <h3>#<?= $pokemon['id'];?></h3>
                    <h2>
                        <a href="pokemon?name=<?= $pokemon['name'];?>">
                            <?= $pokemon['name'];?>
                        </a>
                    </h2>
                    <div class="attacks">
                        <?php 
                        $attacks = attacksCard($pokemon['id']);
                        foreach ($attacks as $attack):
                        ?>
                        <div class="attack"><?= $attack['name']; ?></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
    </section>


</main>

<?php
require_once __DIR__ . '../../partials/footer.php';
?>