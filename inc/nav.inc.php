<?php
/**
 *
 * User: Binote
 * Date: 06-11-17
 * Time: 08:38
 */
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-navbar">
    <a class="navbar-brand" href="index.php">Memories</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbar-memories"
            aria-controls="navbar-memories" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbar-memories">
        <ul class="navbar-nav mr-auto">
            <?= $nav_extends ?>
        </ul>
        <form class="form-inline mt-2 mt-md-0" action="index.php?view=search" method="post">
            <div class="bl-memories">
                <input name="text" class="form-control mr-sm-2" type="text" placeholder="Recherche par #tag" id="nav-search"
                   list="search-tags" aria-label="Recherche">
            </div>
            <datalist id="search-tags"></datalist>
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit"><?= TXT_SEARCH ?></button>
        </form>
    </div>
</nav>
