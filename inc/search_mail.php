<?php

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Text\Body;
use Ddeboer\Imap\Search\Text\Subject;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Email\From;
use Ddeboer\Imap\Message\Headers;
use Ddeboer\Imap\Mailbox;
use Ddeboer\Imap\Message;
use Ddeboer\Imap\Search\LogicalOperator\OrConditions;

$username = $conf['mail']['username'];
$password = $conf['mail']['passsword'];
$server = new Server($conf['mail']['hostname']);
$connection = $server->authenticate($username, $password);

$subject = 'Request: Disease Query';
$subject = trim(preg_replace("/Re\:|re\:|RE\:|Fwd\:|fwd\:|FWD\:/i", '', $subject));
$threads = [];


$search_box = ['INBOX', '[Gmail]/Sent Mail'];
//$search_box = ['[Gmail]/Sent Mail'];
//$search_box = ['INBOX'];

foreach ($search_box as $value) {
    $mailbox = $connection->getMailbox($value);
    $search = new SearchExpression();

    $search->addCondition(new Subject($subject));

    if ($value == 'INBOX') {
        $search->addCondition(new From('ankit.kumar@asentech.com'));
        $search->addCondition(new To('nevakar.asentech@gmail.com'));
       
    }
    if ($value == '[Gmail]/Sent Mail') {
        $search->addCondition(new To('ankit.kumar@asentech.com'));
        $search->addCondition(new From('nevakar.asentech@gmail.com'));
    }

 //$search->addCondition(new OrConditions($arrayOrCondition));
//$search->addCondition(new Subject('Request: Disease Query'));
//$search->addCondition(new Unseen());
//$search->addCondition(new Deleted());
//$search->addCondition(new From('appleid@id.apple.com'));
//$arrayOrCondition = array();
//$arrayOrCondition = new Subject('php tutorial');
//$arrayOrCondition = new Subject('imap tutorial');
//$search->addCondition(new OrConditions($arrayOrCondition));
    $messages = $mailbox->getMessages($search);
    foreach ($messages as $message) {
        $message_id = $message->getHeaders()->get('message_id');
        $to_name = $message->getHeaders()->get('to')[0]->personal;
        $to_email = $message->getHeaders()->get('to')[0]->mailbox . '@' . $message->getHeaders()->get('to')[0]->host;
        $from_name = $message->getHeaders()->get('from')[0]->personal;
        $from_email = $message->getHeaders()->get('from')[0]->mailbox . '@' . $message->getHeaders()->get('from')[0]->host;
        $message_timestamp_gmt = $message->getHeaders()->get('udate');
        $message_subject = $message->getHeaders()->get('subject');
        $message_number = $message->getNumber();
        $message_body = $message->getBodyText();
        $threads[$message_timestamp_gmt] = [
            'message_id' => $message_id,
            'message_type' => $value,
            'to_name' => $to_name,
            'to_email' => $to_email,
            'from_name' => $from_name,
            'from_email' => $from_email,
            'message_timestamp_gmt' => $message_timestamp_gmt,
            'message_subject' => $message_subject,
            'message_number' => $message_number,
            'message_body' => $message_body,
            'message_html_body' => $message->getBodyHtml()
        ];
    }
}
$message_cnt = count($threads);
?>
<h3>Search Message(Message count:<?php echo $message_cnt ?>)</h3>
<?php
echo '<div class="row">';
if ($message_cnt) {
    ksort($threads);

    foreach ($threads as $value) {
        $k = 0;
        $message_id = $value['message_id'];
        $message_type = $value['message_type'];
        $to_name = $value['to_name'];
        $to_email = $value['to_email'];
        $from_name = $value['from_name'];
        $from_email = $value['from_email'];
        $message_timestamp_gmt = $value['message_timestamp_gmt'];
        $message_subject = $value['message_subject'];
        $message_number = $value['message_number'];
        $message_body = $value['message_body'];
        $message_html_body = $value['message_html_body'];

        if ($k) {
            $message_body = $message_html_body;
        }


        echo '<div class="panel panel-default">';
        echo '<div class="panel-heading" style="height:40px"><div class="col-sm-6 panel-title">' . $message_subject . '('.$message_type.')</div><div class="col-sm-6" style="text-align:right"><b>Message Number:</b>' . $message_number . ' | <b>Message Id: </b>' . $message_id . '</div></div>';
        echo '<div class="panel-body">';
        echo '<div class="row">';
        echo '<div class="col-sm-6 p-3 mb-2 bg-primary text-warning"><b>Sender Name:</b> ' . $from_name . ' </div>';
        echo '<div class="col-sm-6 p-3 mb-2 bg-warning text-success"><b>Sender Email:</b> ' . $from_email . ' </div>';
        echo '</div>';
        echo '<div class="row">';
        echo '<div class="col-sm-6 p-3 mb-2 bg-warning text-success"><b>Recipient Date:</b> ' . $to_email . ' </div>';
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

