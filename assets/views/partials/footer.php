<footer>
    <a href="/">Pokemon</a>
    <a href="">register</a>
</footer>
<?php if (isset($_SESSION['favori']['status'])  && $_SESSION['favori']['status'] === 'success') : ?>
    <div class="alert alert-success">
    <img src="../../assets/public/img/pokemon/pikachu.png">
    <?= $_SESSION['favori']['msg'] ?>
    </div>
<?php
    unset($_SESSION['favori']['status']);
    unset($_SESSION['favori']['msg']);
endif; ?>
<?php if (isset($_SESSION['favori']['status'])  && $_SESSION['favori']['status'] === 'delete') : ?>
    <div class="alert alert-delete">
    <img src="../../assets/public/img/pokemon/mewtwo.png">
         <?= $_SESSION['favori']['msg'] ?>
    </div>
<?php
    unset($_SESSION['favori']['status']);
    unset($_SESSION['favori']['msg']);
endif; ?>
</body>
</html>