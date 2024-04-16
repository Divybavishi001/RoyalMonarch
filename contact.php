
<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function isEmail($email) {
        return preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email);
    }
	
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $select_price = htmlspecialchars($_POST['select_price']);
    $select_service = htmlspecialchars($_POST['select_service']);
    $subject = htmlspecialchars($_POST['subject']);
    $comments = htmlspecialchars($_POST['comments']);
    $verify = $_POST['verify'];

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="error_message">Attention! Please enter a valid email address.</div>';
        exit();
    }

    if (trim($comments) == '') {
        echo '<div class="error_message">Attention! Please enter your message.</div>';
        exit();
    }

    $e_subject = 'You\'ve been contacted by ' . $first_name . '.';
    $e_body = "You have been contacted by $first_name. $first_name selected service of $select_service, their additional message is as follows. Customer max budget is $select_price, for this project." . PHP_EOL . PHP_EOL;
    $e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
    $e_reply = "You can contact $first_name via email, $email or via phone $phone";

    $msg = wordwrap($e_body . $e_content . $e_reply, 70);

    $headers = "From: $email" . PHP_EOL;
    $headers .= "Reply-To: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

    $address = "divybavishi001@gmail.com";

    if (!preg_match('/[\r\n]/', $first_name) && !preg_match('/[\r\n]/', $email)) {
        if (mail($address, $e_subject, $msg, $headers)) {
            echo "<fieldset>";
            echo "<div id='success_page'>";
            echo "<h1>Email Sent Successfully.</h1>";
            echo "<p>Thank you <strong>$first_name</strong>, your message has been submitted to us.</p>";
            echo "</div>";
            echo "</fieldset>";
        } else {
            echo 'ERROR! Failed to send email.';
        }
    } else {
        echo 'ERROR! Invalid data detected.';
    }
} else {
    echo 'ERROR! Invalid request.';
}
