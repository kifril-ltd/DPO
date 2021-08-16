<?php

require_once(__DIR__ . "/../core/repository.php");

/**
 * FeedbackRepo -- Репозиторий для работы с таблицей feedback в БД
 */
class FeedbackRepo extends Repository
{

    /**
     * getLastFeedbackByEmail -- получения последнего запроса по email
     *
     * @param string $email Email запрашивающего
     * @return feedback
     */
    public function getLastFeedbackByEmail($email)
    {
        $rows = $this->db->row("SELECT date FROM feedback WHERE email=:email ORDER BY date DESC", ['email' => $email]);
        return empty($rows) ? null : $rows[0];
    }

    /**
     * addFeedback -- Добавление нового запроса на обратную связь
     *
     * @return datetime
     */
    public function addFeedback($post)
    {
        if (!empty($post)) {
            $params = [];
            foreach ($post as $key => $value) {
                $params[$key] = $value;
            }

            $params['date'] = date("d-m-Y H:i:s");

            $stmp = $this->db->query('INSERT into feedback (surname, name, patronymic, email, phone, comment, date) VALUES (:surname, :name, :patronymic, :email, :phone, :comment, :date)', $params);
            return $params['date'];
        }
    }
}
