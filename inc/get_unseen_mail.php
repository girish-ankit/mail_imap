<?php

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Text\Body;

$username = $conf['mail']['username'];
$password = $conf['mail']['passsword'];
$server = new Server($conf['mail']['hostname']);
$connection = $server->authenticate($username, $password);

//print_r($connection);
?>
<h3>Unseen Mail</h3>
<?php
$mailbox = $connection->getMailbox('INBOX');
$messages = $mailbox->getMessages(new \Ddeboer\Imap\Search\Flag\Unseen());

$message_cnt = count($messages);

//print count($messages);
//print_r($message_cnt);


echo '<div class="row">';
if ($message_cnt) {
    echo '<a href="/?q=get_unseen_mail&mark=seen" class="btn btn-danger">Mark as seen</a>';
    foreach ($messages as $message) {

        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading"><h3 class="panel-title">' . $message->getSubject() . ' </h3></div>';
        echo '<div class="panel-body">';
        echo '<div class="row">';
        echo '<div class="col-sm-6 p-3 mb-2 bg-primary text-warning"><b>Sender Name:</b> ' . $message->getFrom()->getName() . ' </div>';
        echo '<div class="col-sm-6 p-3 mb-2 bg-warning text-success"><b>Sender Email:</b> ' . $message->getFrom()->getAddress() . ' </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-sm-6 p-3 mb-2 bg-warning text-success"><b>Recipient Date:</b> ' . $message->getTo()[0]->getAddress() . ' </div>';
        echo '<div class="col-sm-6 p-3 mb-2 bg-primary text-warning"><b>Date:</b> ' . $message->getDate()->format('d/m/Y H:i:s') . '</div>';
        echo '</div>';
        echo '<p>' . $message->getBodyText() . '</p>';
        echo '</div>';
        echo '</div>';

        if (isset($_GET['mark'])) {
            if ($_GET['mark'] == 'seen') {
                $message->markAsSeen();
            }
        }
    }
} else {
    echo '<div >No Message is unseen</div>';
}

echo '</div>';

$connection->expunge();

