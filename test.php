<?php
$imap         = imap_open('{imap.gmail.com:993/imap/ssl}INBOX', 'nevakar.asentech@gmail.com', '_HP3w6hD');
$subject     = 'Request: Disease Query';
$threads     = array();

//remove re: and fwd:
$subject = trim(preg_replace("/Re\:|re\:|RE\:|Fwd\:|fwd\:|FWD\:/i", '', $subject));

//search for subject in current mailbox
$results = imap_search($imap, 'SUBJECT "'.$subject.'"', SE_UID);

//because results can be false
if(is_array($results)) {
    //now get all the emails details that were found
    $emails = imap_fetch_overview($imap, implode(',', $results), FT_UID);
   
    //foreach email
    foreach ($emails as $email) {
        //add to threads
        //we date date as the key because later we will sort it
        $threads[strtotime($email->date)] = $email;
    }   
}

//now reopen sent messages
imap_reopen($imap, '{imap.gmail.com:993/imap/ssl}[Gmail]/Sent Mail');

//and do the same thing

//search for subject in current mailbox
$results = imap_search($imap, 'SUBJECT "'.$subject.'"', SE_UID);

//because results can be false
if(is_array($results)) {
    //now get all the emails details that were found
    $emails = imap_fetch_overview($imap, implode(',', $results), FT_UID);
   
    //foreach email
    foreach ($emails as $email) {
        //add to threads
        //we date date as the key because later we will sort it
        $threads[strtotime($email->date)] = $email;
    }   
}

//sort keys so we get threads in chronological order
ksort($threads);


echo '<pre>'.print_r($threads, true).'</pre>';
exit;
?>
