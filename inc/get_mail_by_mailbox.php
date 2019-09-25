<?php

use Ddeboer\Imap\Server;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Search\Email\To;
use Ddeboer\Imap\Search\Text\Body;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$username = $conf['mail']['username'];
$password = $conf['mail']['passsword'];
$server = new Server($conf['mail']['hostname']);
$connection = $server->authenticate($username, $password);
?>
<h3>Get Mail From Mail box</h3>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Mail Count</th>

        </tr>
    </thead>
    <tbody>

        <?php
        $mailboxes = $connection->getMailboxes();
        foreach ($mailboxes as $mailbox) {
            // Skip container-only mailboxes (we can't open this mailboxes)
            if ($mailbox->getAttributes() & \LATT_NOSELECT) {
                continue;
            }
            //printf("Mailbox '%s' has %s messages\n", $mailbox->getName(), $mailbox->count());

            echo '<tr>';
            echo '<td>' . $mailbox->getName() . '</td>';
            echo '<td>' . $mailbox->count() . '</td>';
            echo '</tr>';
        }
        ?>

    </tbody>
</table>