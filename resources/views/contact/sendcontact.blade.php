<h1>Hi, Admin!</h1>
<p>You received an email with the following information:</p>
<label>Name: <?= Input::get('contact_name') ?></label><br>
<label>Email: <?= Input::get('contact_email') ?></label><br>
<p>Message: <?= Input::get('contact_messages') ?></p>