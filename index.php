<?php
$conf = require_once('config.php');
require_once('vendor/autoload.php');
?>
<?php require_once('inc/header.php'); ?>

<div class="container">
    <div class="col-sm-3">
        <?php require_once('inc/left.php'); ?>
    </div>
    <div class="col-sm-9">

        <?php
        if (isset($_GET['q'])) {

            $url = $_GET['q'];
            switch ($url) {
                case 'url_decode':
                    require_once('inc/url_decode.php');
                    break;
                case 'get_mailbox_list':
                    require_once('inc/get_mailbox_list.php');
                    break;
                case 'get_inbox_mail_list':
                    require_once('inc/get_inbox_mail_list.php');
                    break;
                case 'search_mail':
                    require_once('inc/search_mail.php');
                    break;
                case 'get_mail_by_mailbox':
                    require_once('inc/get_mail_by_mailbox.php');
                    break;
                case 'get_unseen_mail':
                    require_once('inc/get_unseen_mail.php');
                    break;
                default:
                    require_once('inc/front.php');
            }
        } else {
            require_once('inc/front.php');
        }
        ?>
    </div>
</div>
<?php require_once('inc/footer.php'); ?>

