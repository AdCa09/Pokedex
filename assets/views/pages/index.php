<?php
$title = "Home";
require_once __DIR__ . '../../partials/header.php';

$page = pagination();
$pagination = $page - 1;

if (isset($_SESSION['user'])) {
    $user = checkUser($_SESSION['user']);
    $id_user = $user[0]['id'];
} else {
    $id_user = 0;
}

?>
<main>
    <section>
        <div class="list">
            <?php foreach ($viewPokemon as $pokemon) : ?>
                <div class="pokemon">
                    <div class="pokemon-content">
                        <form action="../../favori/add" method="post" id="">
                            <?php

                            $favoriPokemon = favori($id_user, $pokemon['id']);
                            $select = ($favoriPokemon != 0) ? 'select' : '';
                            echo $favoriPokemon;
                            ?><input type="hidden" name='id' value="<?= $pokemon['id']; ?>">
                            <button type="submit">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="" class="<?= $select; ?>" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                </svg>
                            </button>
                        </form>
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
        if (intval($_SESSION['pageIndex']) != intval($pagination)) : ?>
            <div class="button">
                <button><a href="?page=<?= intval($page); ?>">More ..</a></button>
            </div>
        <?php endif; ?>
    </section>
</main>
<?php
require_once __DIR__ . '../../partials/footer.php';
?>