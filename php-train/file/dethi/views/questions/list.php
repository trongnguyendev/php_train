<style>
    .create {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.question-table {
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    border-collapse: collapse;
    width: 100%;
    max-width: 90%px;
}

.question-table th, .question-table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #ddd;
}

.answer-input {
    width: 100%;
    padding: 8px 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

</style>

<div class="create">
    <form class="form" action="#" method="POST">
        <table class="question-table">
            <tr>
                <th>Câu Hỏi</th>
                <th>Câu Trả Lời</th>
                <th></th>
            </tr>
            <?php foreach($questions as $key => $item): ?>
            <tr>
                <td><?= htmlspecialchars($item[1]);?></td>
                <td><input type="text" name="answerCandidate" class="answer-input"></td>
            </tr>
            <?php endforeach; ?>
            <td><button type="submit">Gửi</button></td>
        </table>
    </form>
</div>
