<?php
$title = $viewPokemon[0]['name'];
require_once __DIR__ . '../../partials/header.php';

$maxCapacity = 255;
$id = sprintf("#%04d", $viewPokemon[0]['id']);

$hp = ($viewPokemon[0]['hp'] / $maxCapacity) * 100;
$attackCapactity = ($viewPokemon[0]['attack'] / $maxCapacity) * 100;
$defense = ($viewPokemon[0]['defense'] / $maxCapacity) * 100;
$specificDefense = ($viewPokemon[0]['specific_defense'] / $maxCapacity) * 100;
$specificAttack = ($viewPokemon[0]['specific_attack'] / $maxCapacity) * 100;
$speed = ($viewPokemon[0]['speed'] / $maxCapacity) * 100;

?>
<main id="show">
    <a href="/">Homepage</a>

    <section>
        <div class="pokemon">
            <div class="pokemon-content">
                <h2><?= $viewPokemon[0]['name']; ?></h2>
                <div class="attacks">
                    <?php
                    $attacks = attacks($viewPokemon[0]['id']);
                    foreach ($attacks as $attack) :
                    ?>
                        <div class="attack"><?= $attack['name']; ?></div>
                    <?php endforeach; ?>
                </div>
                <div class="capacities">
                    <div class="capacity">
                        <h3>hp</h3>
                        <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                            <div class="capacity-value" style="width:<?= $hp; ?>%;" title="<?= $viewPokemon[0]['hp']; ?>"></div>
                        </div>
                    </div>
                    <div class="capacity">
                        <h3>attack</h3>
                        <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                            <div class="capacity-value" style="width:<?= $attackCapactity; ?>%;" title="<?= $viewPokemon[0]['attack']; ?>"></div>
                        </div>
                    </div>
                    <div class="capacity">
                        <h3>defense</h3>
                        <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                            <div class="capacity-value" style="width:<?= $defense; ?>%;" title="<?= $viewPokemon[0]['defense']; ?>"></div>
                        </div>
                    </div>
                    <div class="capacity">
                        <h3>specific defense</h3>
                        <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                            <div class="capacity-value" style="width:<?= $specificDefense; ?>%;" title="<?= $viewPokemon[0]['specific_defense']; ?>"></div>
                        </div>
                    </div>
                    <div class="capacity">
                        <h3>specific attack</h3>
                        <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                            <div class="capacity-value" style="width:<?= $specificAttack; ?>%;" title="<?= $viewPokemon[0]['specific_attack']; ?>"></div>
                        </div>
                    </div>
                    <div class="capacity">
                        <h3>speed</h3>
                        <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                            <div class="capacity-value" style="width:<?= $speed; ?>%;" title="<?= $viewPokemon[0]['speed']; ?>"></div>
                        </div>
                    </div>
                </div>
                <div class="evolutions">
                    <h2>Evolution</h2>
                    <div class="evolution">
                        <?php
                        $evolutionsPokemon = evolution($viewPokemon[0]['id']);

                        $pokemoninit = displayPokemonID($evolutionsPokemon[0]['id_pokemon_initial'], 'name,image');
                        ?>
                        <div class="evolution-content">
                            <div class="evolution-image">
                                <a href="pokemon?name=<?= $pokemoninit[0]['name'] ?>">
                                    <img src="/assets/public/img/pokemon/<?= $pokemoninit[0]['image']; ?>" alt="<?= $pokemoninit[0]['name']; ?>">
                                </a>
                            </div>
                            <h3>
                                <a href="pokemon?name=<?= $pokemoninit[0]['name'] ?>">
                                    <?= $pokemoninit[0]['name']; ?>
                                </a>
                            </h3>
                        </div>
                        <?php
                        foreach ($evolutionsPokemon as $pokemonEvo) :
                            $pokemonSelect = displayPokemonID($pokemonEvo['id_pokemon_evolved'], 'name,image');
                            //var_dump($pokemonSelect);
                        ?>
                            <div class="evolution-content">
                                <div class="evolution-image">
                                    <a href="pokemon?name=<?= $pokemonSelect[0]['name']; ?>">
                                        <img src="/assets/public/img/pokemon/<?= $pokemonSelect[0]['image']; ?>" alt="<?= $pokemonSelect[0]['name']; ?>">
                                    </a>
                                </div>
                                <h3>
                                    <a href="pokemon?name=<?= $pokemonSelect[0]['name']; ?>">
                                        <?= $pokemonSelect[0]['name'] ?>
                                    </a>
                                </h3>
                            </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="pokemon-image">
                <h3><?= $id ?></h3>
                <img src="/assets/public/img/pokemon/<?= $viewPokemon[0]['image']; ?>" alt="">
            </div>
        </div>

    </section>
</main>

<?php
require_once __DIR__ . '../../partials/footer.php';
?>