<?php
$courses = $data['courses'];
?><h2>รายวิชาที่เปิดให้ลงทะเบียน</h2>
<table border="1">
    <thead>
        <tr>
            <th>รหัสวิชา</th>
            <th>ชื่อวิชา</th>
            <th>อาจารย์ผู้สอน</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= $course['course_code'] ?></td>
                <td><?= $course['course_name'] ?></td>
                <td><?= $course['instructor'] ?></td>
                <td>ลงทะเบียน</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>