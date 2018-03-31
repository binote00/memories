<?php
/**
 * Created by PhpStorm.
 * User: Binote
 * Date: 06-11-17
 * Time: 08:38
 */
?>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="index.php">Memories</a>
    <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php?view=profile"><?= TXT_PROFILE ?></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="# id=" nav-drop-tools" data-toggle="dropdown">
                Journal
                </a>
                <div class="dropdown-menu">
                    <a class="dropdown-item text-capitalize" href="index.php?view=event"><?= TXT_EVENT ?></a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=images"><?= TXT_IMAGE ?></a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=message"><?= TXT_MESSAGE ?></a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=people"><?= TXT_PEOPLE ?></a>
                    <a class="dropdown-item text-capitalize" href="index.php?view=tag"><?= TXT_TAG ?></a>
                </div>
            </li>
            <?= $nav_extends ?>
        </ul>
        <form class="form-inline mt-2 mt-md-0" action="index.php?view=search" method="post">
            <input name="text" class="form-control mr-sm-2" type="text" placeholder="Recherche par #tag" id="nav-search"
                   list="search-tags" aria-label="Recherche">
            <datalist id="search-tags"></datalist>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?= TXT_SEARCH ?></button>
        </form>
    </div>
</nav>
