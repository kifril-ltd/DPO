<?php

class Feedback
{
    /**
     * validate -- производит валидацию модели Feedback
     *
     * @param array $post объект для проверки
     * @return array
     */
    public static function validate(array $post): array
    {
        $errors = [];

        $fields = [
            'surname' => 'Фамилия',
            'name' => 'Имя',
            'patronymic' => 'Отчетсво',
            'email' => 'Email',
            'phone' => 'Телефон'
        ];

        foreach ($post as $key => $value) {
            if ($value == "") {
                $errors[] = ['field_id' => "id-{$key}", 'error_text' => "Поле \"{$fields[$key]}\" является обязательным"];
            }

            if ($key == 'email') {
                $re = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
                if (!preg_match($re, $value)) {
                    $errors[] = ['field_id' => "id-{$key}", 'error_text' => "Email не соответсвует допустимому формату!"];
                }
            }

            if ($key == 'phone') {
                $re = '/^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/';
                if (!preg_match($re, $value)) {
                    $errors[] = ['field_id' => "id-{$key}", 'error_text' => "Телефон не соответсвует формату РФ!"];
                }
            }
        }

        return $errors;
    }
}
