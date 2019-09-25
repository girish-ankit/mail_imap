<?php

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Search\Text\Subject;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Email\From;
use Ddeboer\Imap\Mailbox;
use Ddeboer\Imap\Message\Headers;

$username = $conf['mail']['username'];
$password = $conf['mail']['passsword'];
$server = new Server($conf['mail']['hostname']);
$connection = $server->authenticate($username, $password);

$mailbox = $connection->getMailbox('INBOX');
$search = new SearchExpression();
//$search->addCondition(new To('email.to@address.com'));
$search->addCondition(new From('ankit.kumar@asentech.com'));
//$search->addCondition(new Subject('Request: Disease Query'));
$search->addCondition(new Subject('Status Update'));
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
if ($message_cnt) {
    foreach ($messages as $message) {
        
        $k =1;
        
        $message_id = $message->getHeaders()->get('message_id');
        $to_name = $message->getHeaders()->get('to')[0]->personal;
        $to_email = $message->getHeaders()->get('to')[0]->mailbox . '@' . $message->getHeaders()->get('to')[0]->host;
        $from_name = $message->getHeaders()->get('from')[0]->personal;
        $from_email = $message->getHeaders()->get('from')[0]->mailbox . '@' . $message->getHeaders()->get('from')[0]->host;
        $message_timestamp_gmt = $message->getHeaders()->get('udate');
        $message_subject = $message->getHeaders()->get('subject');
        $message_number = $message->getNumber();
        $message_body = $message->getBodyText();
        $message_html_body = $message->getBodyHtml();
        if($k){
         $message_body = $message_html_body;   
        }
        
        
        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading" style="height:40px"><div class="col-sm-6 panel-title">' . $message_subject . '</div><div class="col-sm-6" style="text-align:right"><b>Message Number:</b>' . $message_number . ' | <b>Message Id: </b>' . $message_id . '</div></div>';
        echo '<div class="panel-body">';
        echo '<div class="row">';
        echo '<div class="col-sm-6 p-3 mb-2 bg-primary text-warning"><b>Sender Name:</b> ' . $from_name . ' </div>';
        echo '<div class="col-sm-6 p-3 mb-2 bg-warning text-success"><b>Sender Email:</b> ' . $from_email . ' </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-sm-6 p-3 mb-2 bg-warning text-success"><b>Recipient Date:</b> ' . $to_email  . ' </div>';
        echo '<div class="col-sm-6 p-3 mb-2 bg-primary text-warning"><b>Date:</b> ' . date('d/m/Y H:i:s', $message_timestamp_gmt) . '</div>';
        echo '</div>';
        echo '<p>' . $message_body . '</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<div >No Message is unseen</div>';
}

echo '</div>';

$connection->expunge();

