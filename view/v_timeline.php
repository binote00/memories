<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 31-03-18
 * Time: 15:59
 */

$user = new User();
$events = $user->getTimelineEventsFromUser($_SESSION['id']);
$content = '<div class="timeline">
    <div class="timeline__wrap">
        <div class="timeline__items">
        '.$events.'
        </div>
    </div>
</div>';