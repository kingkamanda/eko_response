<?php
require_once __DIR__ . '/Db.php';

/**
 * Support live-chat data access (public side). A conversation is all the
 * support_message rows for a single user_id; "live" updates are done by
 * polling fetch_conversation() for messages newer than the last seen id.
 */
class Support extends Db
{
    private $dbconn;

    public function __construct()
    {
        $this->dbconn = $this->connect();
    }

    /** A user sends a message to support. Returns the new message id. */
    public function send_user_message($user_id, $body)
    {
        $body = trim($body);
        if ($body === '') {
            return 0;
        }
        $stmt = $this->dbconn->prepare(
            "INSERT INTO support_message (user_id, sender, body) VALUES (?, 'user', ?)"
        );
        $stmt->execute([$user_id, mb_substr($body, 0, 1000)]);
        return (int) $this->dbconn->lastInsertId();
    }

    /** Messages in a user's conversation newer than $since (0 = all). */
    public function fetch_conversation($user_id, $since = 0)
    {
        $stmt = $this->dbconn->prepare(
            "SELECT message_id, sender, body, created_at
             FROM support_message
             WHERE user_id = ? AND message_id > ?
             ORDER BY message_id ASC"
        );
        $stmt->execute([$user_id, (int) $since]);
        // Mark support replies as read now that the user is viewing them.
        $this->dbconn->prepare(
            "UPDATE support_message SET is_read = 1 WHERE user_id = ? AND sender = 'support'"
        )->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
