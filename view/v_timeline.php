<?php
/**
 * Created by PhpStorm.
 * User: JF
 * Date: 31-03-18
 * Time: 15:59
 */

if (!isset($_SESSION['id'])) {
    header('Location: index.php');
} else {
    $user = new User();
    $events = $user->getTimelineEventsFromUser($_SESSION['id']);
    $content = '
        <div class="timeline">
            <div class="timeline__wrap">
                <div class="timeline__items">
                ' . $events[0] . '
                </div>
            </div>
        </div>' . $events[1];
}