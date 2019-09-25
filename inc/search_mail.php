<?php

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Search\Text\Subject;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Email\From;




$username = $conf['mail']['username'];
$password = $conf['mail']['passsword'];
$server = new Server($conf['mail']['hostname']);
$connection = $server->authenticate($username, $password);

$mailbox = $connection->getMailbox('INBOX');
$search = new SearchExpression();
//$search->addCondition(new To('email.to@address.com'));
$search->addCondition(new From('ankit.kumar@asentech.com'));
$search->addCondition(new Subject('Request: Disease Query'));
//$search->addCondition(new Unseen());
//$search->addCondition(new Deleted());
//$search->addCondition(new From('appleid@id.apple.com'));
//$arrayOrCondition = array();
//$arrayOrCondition = new Subject('php tutorial');
//$arrayOrCondition = new Subject('imap tutorial');
//$search->addCondition(new OrConditions($arrayOrCondition));
$messages = $mailbox->getMessages($search);

$message_cnt = count($messages);
?>
<h3>Search Message(Message count:<?php echo $message_cnt ?>)</h3>
<?php


echo '<div class="row">';
if($message_cnt){
foreach ($messages as $message) {
    
    echo '<div class="panel panel-default">';
    echo '<div class="panel-heading" style="height:40px"><div class="col-sm-6 panel-title">' . $message->getSubject() . '</div><div class="col-sm-6" style="text-align:right"><b>Message Number:</b>'.$message->getNumber().' | <b>Message Id: </b>'.$message->getId().'</div></div>';
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
}
} else {
    echo '<div >No Message is unseen</div>';
    
}

echo '</div>';

$connection->expunge();

