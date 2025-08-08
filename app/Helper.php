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
            $questionText = strip_tags(str_replace('&nbsp;', '', $questionText),'<img>');
            $questionText = str_replace('</span></p> <p class="MsoNormal"><span lang="EN">', '', $questionText);
            
            // Convert HTML entities to appropriate characters
            $questionText = self::convertHtmlEntities($questionText);

            // Remove the last element (empty string) from the array
//            array_pop($parts);

            $options = [];
            foreach ($parts as $option) {
                $isCorrect = strpos($option, $delimeters['answer']) !== false;
                $optionText = strip_tags(trim(str_replace($delimeters['answer'], '', $option)),'<img>');
                $optionText = strip_tags(trim(str_replace('<br>', '', $optionText)),'<img>');
                $optionText = strip_tags(trim(str_replace('&nbsp;', '', $optionText)),'<img>');
                $optionText = strip_tags(trim(str_replace('<br style="mso-special-character: line-break;"><!--[endif]--></span></p>', '', $optionText)),'<img>');
                
                // Convert HTML entities to appropriate characters in options
                $optionText = self::convertHtmlEntities($optionText);

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

    /**
     * Convert HTML entities to appropriate plain text characters
     * 
     * @param string $text
     * @return string
     */
    public static function convertHtmlEntities($text)
    {
        // First, use PHP's built-in html_entity_decode to handle most entities
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Apply custom replacements for common problematic characters
        
        // Dashes and hyphens - convert to regular hyphen
        $text = str_replace("\xE2\x80\x93", '-', $text); // En dash
        $text = str_replace("\xE2\x80\x94", '-', $text); // Em dash
        $text = str_replace("\xE2\x88\x92", '-', $text); // Minus sign
        
        // Ellipsis - convert to 5 dots
        $text = str_replace("\xE2\x80\xA6", '.....', $text); // Unicode ellipsis
        
        // Quotes - convert to regular quotes
        $text = str_replace("\xE2\x80\x98", "'", $text); // Left single quote
        $text = str_replace("\xE2\x80\x99", "'", $text); // Right single quote
        $text = str_replace("\xE2\x80\x9C", '"', $text); // Left double quote
        $text = str_replace("\xE2\x80\x9D", '"', $text); // Right double quote
        
        // Non-breaking spaces and special spaces
        $text = str_replace("\xC2\xA0", ' ', $text);     // Non-breaking space
        $text = str_replace("\xE2\x80\x82", ' ', $text); // En space
        $text = str_replace("\xE2\x80\x83", ' ', $text); // Em space
        $text = str_replace("\xE2\x80\x89", ' ', $text); // Thin space
        
        // Mathematical symbols
        $text = str_replace("\xC3\x97", 'x', $text);     // Multiplication sign
        
        return trim($text);
    }
}
