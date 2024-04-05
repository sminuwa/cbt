<?php

namespace App;

use stdClass;

class Helper
{
    public static function extractQuestions($text, $delimeters = ['question' => '??', 'option' => '**', 'answer' => '==', 'difficulty' => ['S', 'M', 'D']])
    {
        // Split the string into individual questions
        $questionsArray = explode($delimeters['question'], $text);

        // Remove the first element (empty string) from the array
        array_shift($questionsArray);

        $questions = [];

        foreach ($questionsArray as $questionString) {
            // Split each question into question text and options
            $parts = explode($delimeters['option'], trim($questionString));
            $questionText = array_shift($parts);
            preg_match('/{(.*?)}/', $questionText, $matches);
            $difficulty = isset($matches[1]) ? $matches[1] : 'S';

            // Remove the difficulty indicator from the question text
            $questionText = preg_replace('/\{[SMD]\}/', '', $questionText);
            $questionText = str_replace('<br>', '', $questionText);
            $questionText = str_replace('&nbsp;', '', $questionText);
            // Remove the last element (empty string) from the array
//            array_pop($parts);

            $options = [];
            foreach ($parts as $option) {
                $isCorrect = strpos($option, $delimeters['answer']) !== false;
                $optionText = trim(str_replace($delimeters['answer'], '', $option));
                $optionText = trim(str_replace('<br>', '', $optionText));
                $optionText = trim(str_replace('&nbsp;', '', $optionText));
                $optionText = trim(str_replace('<br style="mso-special-character: line-break;"><!--[endif]--></span></p>', '', $optionText));
                $options[] = (object)[
                    'text' => $optionText,
                    'isCorrect' => $isCorrect
                ];
            }

            // Create question object
            $questionObj = new stdClass();
            $questionObj->text = trim($questionText);
            $questionObj->difficulty = $difficulty;
            $questionObj->options = $options;

            // Add question object to questions array
            $questions[] = $questionObj;
        }
        return $questions;
    }

    public static function indexToChar($index)
    {
        return chr($index + 65);
    }
}
