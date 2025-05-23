<?php
require_once '../models/question.php';
$question = new Questions();
$questions = $question->all();

// Nhóm câu hỏi theo đề
$groupedQuestions = [];
foreach ($questions as $q) {
    $exam = trim($q[0]); // exam
    $groupedQuestions[$exam][] = $q;
}

// Chọn đề
$examId = '1'; // hoặc lấy từ URL $_GET['exam'] ?? '1';
$selectedQuestions = [];

if (isset($groupedQuestions[$examId])) {
    $questionsInExam = $groupedQuestions[$examId];
    if (count($questionsInExam) > 10) {
        $randomKeys = array_rand($questionsInExam, 10);
        foreach ((array)$randomKeys as $key) {
            $selectedQuestions[] = $questionsInExam[$key];
        }
    } else {
        $selectedQuestions = $questionsInExam;
    }
}

$questions = $selectedQuestions;
require_once '../views/questions/list.php';
