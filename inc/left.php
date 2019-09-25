<?php
if (isset($_GET['q'])) {
   $value = '/?q='.$_GET['q']; 
}else{
    $value = '/';
}
?>
<div id="page-id" data-value="<?php echo $value ?>" style="display:none"></div>
<div class="vertical-menu" id="left-menu">
    <a href="/" >Home</a>
    <a href="?q=url_decode">URL Encryption</a>
    <a href="/?q=get_mailbox_list">Get Mail box list</a>
    <a href="/?q=get_inbox_mail_list">Get Mail From Inbox</a>
    <a href="/?q=search_mail">Search Mail</a>
    <a href="/?q=get_unseen_mail">Unseen Mail</a>
    <a href="/?q=get_mail_by_mailbox">Get Mail by Mail Box</a>

</div>

