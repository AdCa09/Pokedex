<footer>
    <a href="/">Pokemon</a>
    <a href="">register</a>
</footer>
<?php if (isset($_SESSION['favori']['status'])  && $_SESSION['favori']['status'] === 'success') : ?>
    <div class="alert alert-success">
    <?= $_SESSION['favori']['msg'] ?>
    </div>
<?php
    unset($_SESSION['favori']['status']);
    unset($_SESSION['favori']['msg']);
endif; ?>
<?php if (isset($_SESSION['favori']['status'])  && $_SESSION['favori']['status'] === 'delete') : ?>
    <div class="alert alert-delete">
         <?= $_SESSION['favori']['msg'] ?>
    </div>
<?php
    unset($_SESSION['favori']['status']);
    unset($_SESSION['favori']['msg']);
endif; ?>
</body>
</html>