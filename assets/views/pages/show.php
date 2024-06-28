<?php
$title = isset($viewPokemon[0]['name'])?$viewPokemon[0]['name']:'';
require_once __DIR__ . '../../partials/header.php';

$pokemonExist = count($viewPokemon);

if ($pokemonExist > 0) {

    if (isset($_SESSION['user'])) {
        $user = checkUser($_SESSION['user']);
        $id_user = $user[0]['id'];
    } else {
        $id_user = 0;
    }

    $maxCapacity = 200;
    $num = sprintf("#%04d", $viewPokemon[0]['num']);

    $hp = ($viewPokemon[0]['hp'] / $maxCapacity) * 100;
    $attackCapactity = ($viewPokemon[0]['attack'] / $maxCapacity) * 100;
    $defense = ($viewPokemon[0]['defense'] / $maxCapacity) * 100;
    $specificDefense = ($viewPokemon[0]['specific_defense'] / $maxCapacity) * 100;
    $specificAttack = ($viewPokemon[0]['specific_attack'] / $maxCapacity) * 100;
    $speed = ($viewPokemon[0]['speed'] / $maxCapacity) * 100;
}
?>
<main id="show">
    <a href="/">Homepage</a>
    <?php if ($pokemonExist > 0): ?>
        <section>
            <div class="pokemon">
                <div class="pokemon-content">
                    <form action="../../favori/add?page=" method="post" id="">
                        <?php

                        $favoriPokemon = favori($id_user, $viewPokemon[0]['id']);
                        $select = ($favoriPokemon != 0) ? 'select' : '';
                        ?><input type="hidden" name='id' value="<?= $viewPokemon[0]['id']; ?>">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="" class="<?= $select; ?>" viewBox="0 0 16 16">
                                <path
                                    d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                            </svg>
                            <!-- <img class="<?= $select; ?>" src="../../assets/public/img/logo/star.svg"> -->
                        </button>
                    </form>
                    <h2><?= $viewPokemon[0]['name']; ?></h2>
                    <div class="attacks">
                        <?php
                        $attacks = attacks($viewPokemon[0]['id']);
                        foreach ($attacks as $attack):
                            ?>
                            <div class="attack"><?= $attack['name']; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="capacities">
                        <div class="capacity">
                            <h3>hp</h3>
                            <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                                <div class="capacity-value" style="width:<?= $hp; ?>%;"
                                    title="<?= $viewPokemon[0]['hp']; ?>"></div>
                            </div>
                        </div>
                        <div class="capacity">
                            <h3>attack</h3>
                            <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                                <div class="capacity-value" style="width:<?= $attackCapactity; ?>%;"
                                    title="<?= $viewPokemon[0]['attack']; ?>"></div>
                            </div>
                        </div>
                        <div class="capacity">
                            <h3>defense</h3>
                            <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                                <div class="capacity-value" style="width:<?= $defense; ?>%;"
                                    title="<?= $viewPokemon[0]['defense']; ?>"></div>
                            </div>
                        </div>
                        <div class="capacity">
                            <h3>specific defense</h3>
                            <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                                <div class="capacity-value" style="width:<?= $specificDefense; ?>%;"
                                    title="<?= $viewPokemon[0]['specific_defense']; ?>"></div>
                            </div>
                        </div>
                        <div class="capacity">
                            <h3>specific attack</h3>
                            <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                                <div class="capacity-value" style="width:<?= $specificAttack; ?>%;"
                                    title="<?= $viewPokemon[0]['specific_attack']; ?>"></div>
                            </div>
                        </div>
                        <div class="capacity">
                            <h3>speed</h3>
                            <div class="capacity-bar" title="<?= $maxCapacity; ?>">
                                <div class="capacity-value" style="width:<?= $speed; ?>%;"
                                    title="<?= $viewPokemon[0]['speed']; ?>"></div>
                            </div>
                        </div>
                    </div>
                    <div class="evolutions">
                        <h2>Evolution</h2>
                        <div class="evolution">
                            <?php
                            $evolutionsPokemon = evolution($viewPokemon[0]['id']);

                            if($evolutionsPokemon):

                            $pokemoninit = displayPokemonID($evolutionsPokemon[0]['id_pokemon_initial'], 'name,image');
                            ?>
                            <div class="evolution-content">
                                <div class="evolution-image">
                                    <a href="pokemon?name=<?= $pokemoninit[0]['name'] ?>">
                                        <img src="/assets/public/img/pokemon/<?= $pokemoninit[0]['image']; ?>"
                                            alt="<?= $pokemoninit[0]['name']; ?>">
                                    </a>
                                </div>
                                <h3>
                                    <a href="pokemon?name=<?= $pokemoninit[0]['name'] ?>">
                                        <?= $pokemoninit[0]['name']; ?>
                                    </a>
                                </h3>
                            </div>
                            <?php
                            foreach ($evolutionsPokemon as $pokemonEvo):
                                $pokemonSelect = displayPokemonID($pokemonEvo['id_pokemon_evolved'], 'name,image');
                                //var_dump($pokemonSelect);
                                ?>
                                <div class="evolution-content">
                                    <div class="evolution-image">
                                        <a href="pokemon?name=<?= $pokemonSelect[0]['name']; ?>">
                                            <img src="/assets/public/img/pokemon/<?= $pokemonSelect[0]['image']; ?>"
                                                alt="<?= $pokemonSelect[0]['name']; ?>">
                                        </a>
                                    </div>
                                    <h3>
                                        <a href="pokemon?name=<?= $pokemonSelect[0]['name']; ?>">
                                            <?= $pokemonSelect[0]['name'] ?>
                                        </a>
                                    </h3>
                                </div>

                            <?php endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="pokemon-image">
                    <h3><?= $num ?></h3>
                    <img src="/assets/public/img/pokemon/<?= $viewPokemon[0]['image']; ?>" alt="">
                </div>
            </div>
        </section>
    <?php else: ?>
        <div class='nofound'>The pokemon "<?= $_GET['name']; ?>" was not found</div>
    <?php endif; ?>
</main>

<?php
require_once __DIR__ . '../../partials/footer.php';
?>