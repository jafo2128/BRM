<?php
/**
 * Created by Fateslayer
 */
$about_link = '/BRM/html/about.html';
$contact_link = '/BRM/html/contact.html';
$feedback_link = '/BRM/html/feedback.html';
echo("
    <div class='panel-footer' id='page_footer'>
        <a href=$about_link>About</a><span> | </span>
        <a href=$contact_link>Contact</a><span> | </span>
        <a href=$feedback_link>Feedback</a>
    </div>"
    );
?>
