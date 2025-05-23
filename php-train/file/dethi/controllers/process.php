<?php
require_once '../models/question.php';
$ques = new Questions();
$exam = $_POST['exam'] ?? '';
$question = $_POST['question'] ?? '';
$answer = $_POST['answer'] ?? '';

$dataQuestion = [
    'exam' => $exam,
    'question' => $question,
    'answer' => $answer,
];

$questions = $ques->store($dataQuestion);
header("Location: list.php");