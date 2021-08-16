<?php

require_once(__DIR__ . "/models/Feedback.php");
require_once(__DIR__ . "/repos/FeedbackRepo.php");

$errors = [];

if (!empty($_POST)) {
    $errors = Feedback::validate($_POST);
    if (!empty($errors)) {
        header('Content-Type: application/json');
        http_response_code(422);
        echo json_encode($errors);
    }

    $feedbackRepo = new FeedbackRepo();
    $feedback = $feedbackRepo->getLastFeedbackByEmail($_POST['email']);

    if (is_null($feedback)) {
        $answer_date = processFeedback($feedbackRepo, $_POST);
        echo "С вами свяжутся в $answer_date";
    } else {
        $now = new DateTime(date("d-m-Y H:i:s"));
        $feedback_date = new DateTime($feedback['date']);
        $diff = $now->diff($feedback_date);
        $diff_hours = $diff->h + $diff->days * 24;
        $diff_i = $diff->i;
        $diff_s = $diff->s;

        if ($diff_hours < 1) {
            $allowed_time = date_add($feedback_date, date_interval_create_from_date_string('1 hour'))->format('H:i:s');
            echo "Последний запрос был отправлен менее часа назад, пожалуйста, подожите до $allowed_time";
        } else {
            $answer_date = processFeedback($feedbackRepo, $_POST);
            echo "С вами свяжутся после $answer_date";
        }
    }
}

function processFeedback($feedbackRepo, $post)
{
    $date = new DateTime($feedbackRepo->addFeedback($post));
    sendEmail($post);
    return date_add($date, new DateInterval('PT1H30M'))->format('H:i:s');
}

function sendEmail($post)
{
    $to = 'manager@exaple.com';
    $subject = 'Запрос обратной связи';
    $message = "ФИО: $post[surname] $post[name] $post[patronymic]" . "\r\n" .
        "Телефон: $post[phone]" . "\r\n" .
        "Email: $post[email]" . "\r\n" .
        "Сообщение: $post[comment]";

    $headers = 'From: feedback@example.com' . "\r\n" .
        'Reply-To: feedback@example.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);
}
