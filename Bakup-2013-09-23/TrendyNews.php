<?php
include_once 'MessageManager.php';
$messageManager = new MessageManager();
$trends = $messageManager->getTrends();
echo '<ul>';

foreach ($trends as $trendItem) {
    $trendItem = str_replace("#", "", $trendItem);
    echo '<li ><a href="Trends.php?t=' . $trendItem . '">' . '#' . $trendItem . '</a></li>';
}

echo '</ul>'
?>