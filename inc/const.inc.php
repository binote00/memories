<?php
/**
 *
 * User: Binote
 * Date: 16-11-17
 * Time: 14:04
 */

define('DEBUG_MODE', true);
define('LOG_EMAIL', 'binote@hotmail.com');
define('IMG_MAX_SIZE', 2097152);

define('EVENT_TYPE_MESSAGE', 1);
define('EVENT_TYPE_IMAGE', 2);
define('EVENT_TYPE_VIDEO', 3);
define('EVENT_TYPE_PEOPLE', 4);
define('EVENT_TYPE_EVENT', 5);

define('DATA_TYPE_MESSAGE', 1);
define('DATA_TYPE_IMAGE', 2);
define('DATA_TYPE_VIDEO', 3);
define('DATA_TYPE_PEOPLE', 4);
define('DATA_TYPE_EVENT', 5);
define('DATA_TYPE_TAG', 6);

define('CARDS_PER_PAGE', 9);

/**
 * @param int $data_type
 * @return string
 */
function getRedirect($data_type)
{
    if ($data_type == DATA_TYPE_EVENT) {
        return 'event';
    } elseif ($data_type == DATA_TYPE_PEOPLE) {
        return 'people';
    } elseif ($data_type == DATA_TYPE_VIDEO) {
        return 'video';
    } elseif ($data_type == DATA_TYPE_IMAGE) {
        return 'image';
    } elseif ($data_type == DATA_TYPE_MESSAGE) {
        return 'message';
    } elseif ($data_type == DATA_TYPE_TAG) {
        return 'tag';
    }
}

require_once 'text.inc.php';

